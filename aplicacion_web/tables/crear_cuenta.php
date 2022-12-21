<?php  
  require 'conexion.php';
  require 'funcs.php';

  $errores = array();
  $resultado = array();

  if (!empty($_POST)) {
    // code...

    //Variables
    $nombre = $Con->real_escape_string($_POST['nombre']);
    $apaterno = $Con->real_escape_string($_POST['apaterno']);
    $amaterno = $Con->real_escape_string($_POST['amaterno']);
    $usuario = $Con->real_escape_string($_POST['user']);
    $password = $Con->real_escape_string($_POST['password']);
    $passconf = $Con->real_escape_string($_POST['passconf']);

    //Funciones Registro
    if (isNullReg($nombre,$apaterno,$amaterno,$usuario,$password,$passconf)) {
      // code...
      $errores[]="Debe llenar todos los campos";
    }
    if (!validaPassword($password,$passconf)) {
      // code...
      $errores[]="Las contraseñas no coinciden";  
    }
    if (usuarioExiste($usuario)) {
      // code...
      $errores[]="Datos Incorrectos";
    }
    if (count($errores)==0) {
      // code...
      $pass_hash = hashPassword($password);
      $registro = registraUsuario($nombre,$apaterno,$amaterno,$usuario,$pass_hash);
      if ($registro > 0) {
        // code...
        $resultado[] = "Usuario registrado con éxito";
      }else {
        // code...
        $errores[] = "Error al registrar el usuario";
      }
    }
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">

    <title>GAMIWEB</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	   <!-- Animate.css -->
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">
    <!-- Icons-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- bootstrap-progressbar -->
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- PNotify -->
    <link href="../vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body style="background: #F7F7F7">
    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <?php echo resultBlock($errores); ?>
          <?php echo results($resultado); ?>
          <form action="crear_cuenta.php" method="post" id="register">
            <h1 style="color: #6e0635;">Crear cuenta</h1>
              <div>
                <input type="text" class="form-control" placeholder="Nombre" name="nombre" id="nombre" value="<?php if(isset($nombre)) echo $nombre; ?>" style="border-color: #6e0635;" required />
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Apellido Paterno" name="apaterno" id="apaterno" value="<?php if(isset($apaterno)) echo $apaterno; ?>" style="border-color: #6e0635;" required />
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Apellido Materno" name="amaterno" id="amaterno" value="<?php if(isset($amaterno)) echo $amaterno; ?>" style="border-color: #6e0635;" required />
              </div>
             <div>
               <input type="text" class="form-control" placeholder="Nombre de usuario" name="user" id="user" value="<?php if(isset($user)) echo $user; ?>" style="border-color: #6e0635;" required />
             </div> 
              <div>
                <input type="password" class="form-control" placeholder="Contraseña" name="password" id="password" style="border-color: #6e0635;" required />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Confirma tu contraseña" name="passconf" id="passconf" style="border-color: #6e0635;" required />
              </div>
              <div>
                <button type="submit" class="btn btn-primary btn-block">Crear cuenta</button>
                <button type="submit" class="btn btn-danger btn-block">Cancelar</button>
              </div>
              

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link" style="color: #6e0635;">¿Ya tienes una cuenta?
                  <a href="login.php" class="to_register" style="color: #6e0635;"> Iniciar sesión </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <i class="material-icons" style="color: #6e0635;">computer</i>
                  <p style="color: #6e0635;">GAMIWEB</p>
                </div>
              </div>
          </form>
        </section>
       </div>
        
      </div>
    </div>
   <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
   <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- PNotify -->
    <script src="../vendors/pnotify/dist/pnotify.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.nonblock.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </body>
</html>
