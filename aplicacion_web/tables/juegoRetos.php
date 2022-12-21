<?php 
  session_start();
  require 'conexion.php';
  require 'funcs.php';

  //Si bandRegistros = 0 NO HAY REGISTRO
  //Si bandRegistros = 1 SI HAY REGISTRO
  //$bandRegistros=0;

  if (!isset($_SESSION['id_usuario'])) {
    // code...
    header("Location: login.php");
  }

  $idUsuario = $_SESSION['id_usuario'];

  $Cx = "SELECT id, nombre, apaterno, amaterno, user, foto FROM usuarios WHERE id = '$idUsuario' ";
  $result = $Con->query($Cx);

  $row = $result->fetch_assoc();

  $idGrupo=$_GET['idGrupo'];
  $retos = $_GET['idActividad'];
  //echo $retos;

  $QueryRetos = "SELECT * FROM retos_preguntas WHERE actividades_id= '$retos'";
  $ResultadoRetos = mysqli_query($Con,$QueryRetos);
  $RRetos = mysqli_fetch_array($ResultadoRetos);
  /****************************************************************************/
  $QueryRanking = "SELECT * FROM ranking_actividad WHERE actividad_id= '$retos' AND id_usuario = '$idUsuario' ";
  $ResultadoRanking = mysqli_query($Con, $QueryRanking);
  $_num_filas = mysqli_num_rows($ResultadoRanking);
  
  $bandRegistros=1;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

    <!--Estilo para el quiz-->
    <link rel="stylesheet" href="../tables/css/retos/estilosRetos.css">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">


  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container" style="display: block;">
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
                <h2><?php echo $row['nombre']?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu" style="display: block;">
              <div class="menu_section" style="display: block;">
                <h3>Inicio</h3>
                <ul class="nav side-menu">
                  <li><a href="index.php"><i class="fa fa-user"></i> Perfil </a></li>
                  <li><a href="actividades.php"><i class="fa fa-gamepad"></i> Actividades</a></li>
                  <li><a href="ranking.php"><i class="fa fa-sitemap"></i>Ranking</a></li>
                  <li><a href="premiaciones.php"><i class="fa fa-gift"></i> Premiaciones</a></li>
                  <li><a><i class="fa fa-group"></i>Tus grupos<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php
                        $sql="SELECT * from grupo WHERE  id_user = '$idUsuario'";
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

            <!-- /menu footer buttons -->
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
                      <img src="<?php echo $row['foto']; ?>" alt=""><?php echo utf8_decode($row['user'])?>
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

        <!-- page content -->
        <div class="right_col" style="display: block;">
          <div class="row">
            <h3>Retos</h3>
            <br>
            <input type="hidden" name="idActv" id="idActv" value="<?php echo $_GET['idActividad'];?>">
            <input type="hidden" name="idGrupo" id="idGrupo" value="<?php echo $_GET['idGrupo'];?>">
            <input type="hidden" name="idHistoria" id="idHistoria" value="<?php echo $_GET['idHistoria'];?>">
            <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $row['id'];?>">
            <input type="hidden" name="fila" id="fila" value="<?php echo $_num_filas?>">
            <?php 
              $QueryActC = "SELECT * FROM crear_retos WHERE id_retos = ".$_GET['idActividad'];
              $QueryMostrar = mysqli_query($Con, $QueryActC);
              $mostrar = mysqli_fetch_array($QueryMostrar);
              //echo $mostrar['puntajeT'];
            ?>

          <input type="hidden" name="idActCr" id="idActCr" value="<?php echo $mostrar['puntajeT'];?>">
            <?php 
              if($_num_filas >= 1){
            ?>
            <!-- modal mostrar actividad -->
            <div id="btn_H" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
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

            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_content" align="center">
                  <br />
                  <table align="center" width="70%">
                    <tr>
                      <td>

                      </td>
                      <td align=" center">
                        <h6 class="text-edit">Avance actividad</h6>  <!-- cambio aquí-->
                          <div class="progress progress-striped" align="center" style="border-radius: 10px; background: #EDEDED">
                            <div class="progress-bar progress-bar-success" role="progressbar"
                                 aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                                 id="progress">
                                 <h2 align="center" id="mostrar"></h2>
                            </div>
                          </div>
                      </td>

                      <td rowspan="3">
                      </td>
                    </tr>
                  </table>

                  <div class="col-md-12"></div>
                  <br>
                  <div class="col-md-12"></div>

                  <!-- estructura donde se muestran las preguntas y respuestas -->
                  <div class="estilos" id="retos"> <!-- cambio aquí-->
                    <div class="encabezado" id="preguntaAux"><h3 align="center" id="pregunta"></h3></div>
                    <div class="btnR" id="btn1Aux" onclick="oprimir(0), mostrarBarra();"><h6 align="center" id="btn1"></h6></div>
                    <div class="btnR" id="btn2Aux" onclick="oprimir(1), mostrarBarra();"><h6 align="center" id="btn2"></h6></div>
                    <div class="btnR" id="btn3Aux" onclick="oprimir(2), mostrarBarra();"><h6 align="center" id="btn3" ></h6></div>
                    <div class="btnR" id="btn4Aux" onclick="oprimir(3), mostrarBarra();"><h6 align="center" id="btn4"></h6></div>
                  </div>


                   <br>
                  <div class="col-md-12"></div>
                  <div class="col-md-12"></div>
                  <div class="col-md-12"></div>
                  <br>
                  <div class="col-md-4"></div> 
                  
                </div>
              </div>
            </div>
            <?php 
              }
            ?>



          </div>  
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

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="../tables/css/retos/crudRetosAlumnos.js"></script>
  </body>
</html>