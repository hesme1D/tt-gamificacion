<?php 
  session_start();
  require 'conexion.php';
  require 'funcs.php';

  if (!isset($_SESSION['id_usuario'])) {
    // code...
    header("Location: login.php");
  }

  $idUsuario = $_SESSION['id_usuario'];
  //echo $idUsuario;

  $Cx = "SELECT id, nombre, apaterno, amaterno, user, foto FROM usuarios WHERE id = '$idUsuario'";
  $result = $Con->query($Cx);

  $row = $result->fetch_assoc();

  $idGrupo=$_GET['idGrupo'];

  $QueryActCreada = "SELECT * FROM mostrar_act WHERE id_grupo_usuarios='$idGrupo' ORDER BY id ASC ";
  $ResultadoQuery = mysqli_query($Con, $QueryActCreada);
  $num_filas = mysqli_num_rows($ResultadoQuery);

  $QueryRetoCreado = "SELECT * FROM mostrar_retos WHERE id_users='$idUsuario' ";
  $ResultReto = mysqli_query($Con, $QueryRetoCreado);
  $filas = mysqli_num_rows($ResultReto);
  //echo $filas;


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
  
    <!-- bootstrap-progressbar -->
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;" align="center">
              <a href="index.php" class="site_title"><i class="fa fa-desktop"></i> <span>GAMIWEB</span></a>
            </div>

            <div class="clearfix"></div>
            <!-- imagen de bienvenida-->
            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?php echo $row['foto']?>" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Bienvenido</span>
                <h2><?php echo $row['nombre']?></h2>
              </div>
            </div>

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Inicio</h3>
                <ul class="nav side-menu">
                  <li><a href="index.php"><i class="fa fa-user"></i> Perfil </a></li>
                  <li><a href="actividades.php"><i class="fa fa-gamepad"></i> Actividades</a></li>
                  <li><a href="ranking.php"><i class="fa fa-sitemap"></i>Ranking</a></li>
                  <li><a href="premiaciones.php"><i class="fa fa-gift"></i> Premiaciones</a></li>
                  <li><a><i class="fa fa-group"></i>Tus grupos<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php
                        $sql="SELECT id, nomGrupo from grupo WHERE  id_user = '$idUsuario'";
                        $result= $Con ->query($sql);
                        while ($mostrar=$result->fetch_assoc()) {
                                              
                      ?>
                      <li><a href="nom_clase.php?idGrupo=<?php echo $mostrar['id']?>"><?php echo $mostrar['nomGrupo']?></a></li>

                      <?php
                        } 
                      ?>
                      <li><a href="nuevo_grupo.php">Crear grupo</a></li>
                    </ul>
                  </li>
                </ul>

                <!--agregar calendario-->
               
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons --> <!-- modificaciones de barra inferior-->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="">
                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="">
                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="">
                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.php">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <div class="nav toggle">
                  <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>
                <nav class="nav navbar-nav">
                <ul class=" navbar-right">
                  <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                      <img src="<?php echo $row['foto']; ?>" alt=""><?php echo $row['user']?>
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item"  href="login.php"><i class="fa fa-sign-out pull-right"></i>Cerrar sesión</a>
                    </div>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        <!-- /top navigation -->

        <!-- Página básica en blanco--> 
        <div class="right_col" >
          <input type="hidden" name="idGrupo" id="idGrupo" value="<?php echo $_GET['idGrupo'];?>">
          <div align="right">
            <button type="button" id="btn_H" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-lg">Abrir problemática</button>
          </div>
          
          <div class="col-md-12">
            <div class="x_panel">
              <div class="x_content">
                <div class="x_title">
                  <div class="col-md-12" align="center">
                    

                    
                    <br>
                  </div>
                  <div class="clearfix"></div>
                </div>

                <?php 
                  if($num_filas > 0){
                ?>
                <h3 align="center">Seguimiento de las actividades:</h3>
                <div class="form_wizards wizard_horizontal" id="wizard">
                  
                  <ul class="wizard_steps" style="width:100%;">
                    <?php
                      while($mostrar = mysqli_fetch_array($ResultadoQuery)){     
                    ?>
                    <li>
                      <a href="<?php echo $mostrar['url_juego']?>?idGrupo=<?php echo $_GET['idGrupo']?>&idHistoria=<?php echo $mostrar['id_historia']?>&idActividad=<?php echo $mostrar['idActividad']?>"  onclick="identificaID(<?php echo $mostrar['idActividad'];?>);" id="btn_puntaje_<?php echo $mostrar['idActividad'];?>">
                        <span class="step_no"></span>
                        <span class="step_descr"><?php echo $mostrar['nom_act']?>
                          <br />
                          <span class="step_descr">Dificultad: <?php echo $mostrar['nivel']?>
                          <br />
                          <small><?php echo $mostrar['nombre']?></small>
                          <br>
                          <span class="step_descr">Fecha límite: <b><?php echo $mostrar['fecha']?></b>
                          <br />
                        </span>
                      </a>
                    </li>
                    <?php 
                      }
                    ?>
                  </ul>
                
                </div>

                <?php 
                  }

                  if($filas > 0) {
                ?>
                <div class="x_title"></div>
                <h3 align="center">Retos:</h3>
                <div id="wizard" class="form_wizard wizard_horizontal" style="align-content: left;">
                  <ul class="wizard_steps">
                    <?php 
                       while($mos_retos = mysqli_fetch_array($ResultReto)){
                    ?>
                    <li>
                      <a href="<?php echo $mos_retos['url_juego']?>?idGrupo=<?php echo $_GET['idGrupo']?>&idHistoria=<?php echo $mos_retos['id_historia']?>&idActividad=<?php echo $mos_retos['id_retos']?>"><!--falta link de la página alumno-->
                        <span class="step_no"></span>
                          <br />
                          <span class="step_descr">Fecha entrega: <?php echo $mos_retos['fecha']?>  
                          <br>
                          <small><?php echo $mos_retos['nombre']?></small>
                        </span>
                      </a>
                    </li>
                    <?php 
                      }
                    ?>

                  </ul>
                </div>
                <?php 
                  }
                ?>

              </div>
            </div>
          </div>

          <!-- modal que muestra la historia general -->
          <div id="btn_H" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" >
              <div class="modal-content" style="width: 1035px; height: 600px;">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" onclick="deshabilitar();"><span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body" >
                  <canvas id="problematica" width="1000" height="600"></canvas>
                </div>
              </div>
            </div>
          </div>  

        </div>
       
        <!-- fin página blanco-->
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
    <!-- Chart.js -->
    <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../vendors/skycons/skycons.js"></script>
    <!-- jQuery Smart Wizard -->
    <script src="../vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
    <!-- Flot -->
    <script src="../vendors/Flot/jquery.flot.js"></script>
    <script src="../vendors/Flot/jquery.flot.pie.js"></script>
    <script src="../vendors/Flot/jquery.flot.time.js"></script>
    <script src="../vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="../vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
    <script src="../tables/mostrar_historia.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </body>
</html>
