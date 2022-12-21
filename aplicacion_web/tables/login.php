<?php
  session_start();
  require 'conexion.php';
  require 'funcs.php';

  $errores = array();
  $Resultado = array();

  if (!empty($_POST)) {
    # code...
    $usuario = $Con->real_escape_string($_POST['user']);
    $password = $Con->real_escape_string($_POST['password']);

    if(isNullLogin($usuario, $password)) {
      # code...
      $errores[]= "Debe llenar todos los campos";
    }

    $errores[] = Login($usuario,$password);
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
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- PNotify -->
    <link href="../vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <?php echo resultBlock($errores); ?>
            <form action="login.php" method="post">
              <i class="fa fa-user fa-5x" style="color: #6e0635;"></i>
              <br>
              <div>
                <br>
                <input type="text" class="form-control" placeholder="Usuario" name="user" id="user" style="border-color: #6e0635;" required />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Contraseña" name="password" id="password" style="border-color: #6e0635;" required />
              </div>
              <div>
                <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                <!--<a class="btn btn-secondary submit" href="
                index.php">Ingresar</a> --> <!--agregar siguiente página-->
              </div>
              <div class="separator">
                <p class="change_link">
                  <a href="crear_cuenta.php" class="to_register" style="color: #6e0635;"> Crear cuenta </a>
                  <a href="rec_contraseña.php" class="" style="color: #6e0635;"> Olvidé mi contraseña</a> <!-- definir atributos-->
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
