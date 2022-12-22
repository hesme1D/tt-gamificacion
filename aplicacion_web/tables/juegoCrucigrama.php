<?php 
  session_start();
  require 'conexion.php';

  $errores = array();
  $resultado = array();

  if (!isset($_SESSION['id_usuario'])) {
    // code...
    header("Location: login.php");
  }

  $idUsuario = $_SESSION['id_usuario'];

  $Cx = "SELECT id, nombre, apaterno, amaterno, user, foto FROM usuarios WHERE id = '$idUsuario'";
  $result = $Con->query($Cx);

  $row = $result->fetch_assoc();

  $Cruci = $_GET['idActividad'];

  //Variables para el crucigrama
  $QueryConCruci= "SELECT * FROM crucigrama_preguntas WHERE crucigrama_id_actividades ='$Cruci'";
  $ResultadoCruci=mysqli_query($Con, $QueryConCruci);
  $RCruci=mysqli_fetch_array($ResultadoCruci);

  $idActividad = $_GET['idActividad'];
  $mostrarCruci="SELECT * FROM crucigrama WHERE id_actividades='$idActividad'";
  $ResultCruci=mysqli_query($Con, $mostrarCruci);
  $resCruci=mysqli_fetch_array($ResultCruci);

  $QueryRanking = "SELECT * FROM ranking_actividad WHERE actividad_id= '$idActividad'  AND id_usuario = '$idUsuario'";
  $ResultadoRanking = mysqli_query($Con, $QueryRanking);
  $_num_filas = mysqli_num_rows($ResultadoRanking);

  $QueryAct = "SELECT * FROM crear_act WHERE idActividad = '$idActividad'";
  $ResultadoAct = mysqli_query($Con, $QueryAct);
  $Res = mysqli_fetch_array($ResultadoAct);
  $ren = $Res['puntajeT'];


  $bandRegistros=1;
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

    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

     <!--Estilo para el crucigrama-->
    <link rel="stylesheet" href="../tables/css/crucigrama/estilosCrucigrama.css">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;" align="center">
              <a href="" class="site_title"><i class="fa fa-desktop"></i> <span>GAMIWEB</span></a>
            </div>

            <div class="clearfix"></div>
            <!-- imagen de bienvenida-->
            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?php echo $row['foto']; ?>" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Bienvenido</span>
                <h2><?php echo $row['nombre']; ?></h2> <!-- nombre de usuario-->
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
                        $sql="SELECT * from grupo WHERE id_user = '$idUsuario'";
                        $result= mysqli_query($Con, $sql);

                        while ($mostrar=mysqli_fetch_array($result)
                        ) {
                        
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
                      <!-- se tiene que agregar el nombre del usuario-->
                      <img src="<?php echo $row['foto']; ?>" alt=""><?php echo $row['user'];?> <!--cambio aquí-->  
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item"  href="login.php"><i class="fa fa-sign-out pull-right"></i>Cerrar sesión</a>
                    </div>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- Página básica en blanco--> 
        <div class="right_col">
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" name="idActv" id="idActv" value="<?php echo $_GET['idActividad'];?>">
              <input type="hidden" name="idGrupo" id="idGrupo" value="<?php echo $_GET['idGrupo'];?>">
              <input type="hidden" name="idHistoria" id="idHistoria" value="<?php echo $_GET['idHistoria'];?>">
              <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $idUsuario;?>">
              <input type="hidden" name="puntaje" id="puntajeT" value="<?php echo $ren;?>">
            </div>

              <h3>Crucigrama </h3>
              <div class="col-md-12" align="center">
                <div class="x_title">
                  <h3><?php echo " ".$resCruci['nom_act']; ?></h3>
                </div>
              </div>

              <?php 
                if($_num_filas >= 1){
              ?>
              <!-- modal mostrar actividad -->
              <div id="btn_puntaje" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-body fondoPuntaje">
                      <div class="fondoPuntaje">
                        <h1>Ya has realizado esta actividad...</h1>
                      </div>
                        
                    </div>
                    <div class="modal-footer">
                       <a href="../tables/mostrar_actividad.php?idGrupo=<?php echo $_GET['idGrupo']?>" class="btn btn-primary">Cerrar</a>
                    </div>

                  </div>
                </div>
              </div>
              <?php 
                }else{
              ?>
               <!-- modal para historia particular -->
              <div id="btn_H" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" >
                <div class="modal-dialog modal-lg"  >
                  <div class="modal-content" style="width: 1035px; height: 535px;">
                    <div class="modal-body" >
                      <canvas id="problematica" width="1000" height="600"></canvas>
                    </div>
                  </div>
                </div>
              </div>
              

          <div class="col-md-12" align="center"><button type="button" class="btn btn-success submit" data-toggle="modal" data-target=".bs-example-modal-sm" id="pista" onclick="mostrarPista();">Pista</button>
            <button type="button" class="btn btn-success submit" id="validar" onclick="procesaCrucigrama();">Validar</button>
           </div>

          <div class="col-md-12">
            <div class="x_panel" align="center">
              <div class="grid" id="grid">
              </div>
              <br>
              <table id="datatable1" class="table table-striped table-bordered" style="width:50%" align="left">
                <thead>
                  <tr align="center">
                    <th colspan="2">Horizontales</th>
                  </tr>
                <tr>
                  <th>Id</th>
                  <th>Descripción</th>
                </tr>
              </thead>
                <tbody>
                </tbody>
              </table>
              <table id="datatable2" class="table table-striped table-bordered" style="width:50%" align="right">
                <thead>
                  <tr align="center">
                    <th colspan="2">Verticales</th>
                  </tr>
                <tr>
                  <th>Id</th>
                  <th>Descripción</th>
                </tr>
              </thead>
              <tbody>
              </tbody> 
              </table>
              <br>

          </div>
        </div>

        <?php 
          }
        ?>
        <!--Modal pista-->
        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel2" style="color: #265E31;">Pista</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="desabilitar();"><span aria-hidden="true">×</span></button>
              </div>
              <div class="modal-body" align="center">
                <h5 id="npista" style="color: #265E31"></h5>
              </div>
              <div class="modal-footer">
              </div>
            </div>
          </div>  
        </div>

       <!--footer content -->
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

    <!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

    <script src="../tables/css/crucigrama/palabra.js"></script>
    <script src="../tables/css/crucigrama/words.js"></script>
    <script src="../tables/css/crucigrama/estructuraCrucigrama.js"></script>
    <script src="../tables/css/crucigrama/generadorCrucigramaAlumno.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  </body>
</html>
