<?php  
  require 'conexion.php';
  require 'funcs.php';

  $errores = array();
  $resultado = array();

  if (!empty($_POST)) {
    // code...
    $user_id = $Con->real_escape_string($_POST['user_id']);
    $usuario = $Con->real_escape_string($_POST['user']);
    $newpass = $Con->real_escape_string($_POST['newpass']);
    $confnewpass = $Con->real_escape_string($_POST['confnewpass']);

    if (isNullCambio($usuario, $newpass, $confnewpass)) {
      // code...
      $errores[]="Debe llenar todos los campos";
    }
    if (usuarioExiste($usuario)) {
      // code...
      $user_id = getValor('id', 'user', $usuario);

    } else{
      $errores[]="Datos Incorrectos";
    }

    if (validaPassword($newpass, $confnewpass)) {
      // code...
      $pass_hash = hashPassword($newpass);
      if(cambio($pass_hash,$user_id) && usuarioExiste($usuario)) {
        // code...
        $resultado[] = "Contraseña actualizada";
      } else {
        $errores[] = "Error al cambiar contraseña";
      }

    } else {
      $errores[]="Las contraseñas no coinciden";
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
    <!-- Animate.css -->
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">
    <!-- Icons-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

 <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div>
          <section class="login_content">
            <?php echo resultBlock($errores); ?>
            <?php echo results($resultado); ?>
            <form action="rec_contraseña.php" method="post">
              <h1 style="color: #6e0635;">Olvidé mi contraseña</h1>
              <input type="hidden" id="user_id" name="user_id" value="<?php  echo $user_id; ?>" />
              <div>
                <input type="text" class="form-control" placeholder="Usuario" name="user" id="user" style="border-color: #6e0635;" required />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Nueva contraseña" name="newpass" id="newpass" style="border-color: #6e0635;" required />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Confirmar contraseña" name="confnewpass" id="confnewpass" style="border-color: #6e0635;" required />
              </div>
              <div>
                <button type="submit" class="btn btn-primary btn-block">Aceptar</button> <!--agregar siguiente página-->
              </div>


              <div class="separator">
                <p class="change_link">
                  <a href="crear_cuenta.php" class="to_register" style="color: #6e0635;"> Crear cuenta </a>
                  <a href="login.php" class="" style="color: #6e0635;"> Inciar sesión</a> <!-- definir atributos-->
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
