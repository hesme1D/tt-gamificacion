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

  $idActividad = $_GET['idActividad'];
  //echo $idActividad;



  $QueryCategoria = "SELECT * FROM jeopardy_categoria WHERE Jeopardy_id_actividades = '$idActividad'";
  $ResultadoCategoria = $Con->query($QueryCategoria);

  $QueryJeopardy = "SELECT j.id_actividades, jc.Jeopardy_id_actividades, jc.nom_cat, jp.pregunta, jp.resp_uno, jp.resp_dos, jp.resp_tres, jp.resp_cuatro, jp.puntaje, jp.id, jp.categoria_id FROM jeopardy as j JOIN jeopardy_categoria as jc ON(j.id_actividades=jc.Jeopardy_id_actividades) JOIN jeopardy_preguntas as jp ON(jc.id=jp.categoria_id) WHERE j.id_actividades='$idActividad' ORDER by jp.puntaje ASC, jp.categoria_id"; 
  //echo $QueryJeopardy;
  $ResultadoJeopardy = $Con->query($QueryJeopardy);
 
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

    <!--estructura jeopardy-->
    <link rel="stylesheet" href="../tables/css/jeopardy/estilosJeopardy.css">

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
                  <li><a><i class="fa fa-group"></i>Grupos<span class="fa fa-chevron-down"></span></a>
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
            <?php
              $mostrarJeopardy = "SELECT * FROM jeopardy WHERE id_actividades = '$idActividad'";
              $resultJeopardy = mysqli_query($Con, $mostrarJeopardy);
              $resJeopa = mysqli_fetch_array($resultJeopardy);
            ?>
            <div class="x_panel"> 
              <div>
                <p><?php echo $resJeopa['historia_part'];?>
              </div>
            </div>
            
          </div>
            <table>
            <tr>
              <td>
                <h3>Vista previa: </h3>
              </td>
              <td>
                 <div class="tile_count" align="center">
                    <h5><?php echo $resJeopa['nom_act'];?></h5>
                </div>
              </td>
            </tr>
          </table>
            <div class="col-md-12">
                <div class="x_panel">
                  <table class="content_t"> 
                    <thead>
                      <?php
                        $NumCate = mysqli_num_rows($ResultadoCategoria);
                        //echo $NumCate;
                        while($mostrar = $ResultadoCategoria->fetch_assoc()){
                      ?>
                    <td>
                      <?php echo $mostrar['nom_cat'];?>
                    </td> 
                      <?php
                        }
                      ?>
                    </thead>
                    <tbody>
                      <tr>
                      <?php 
                        $Contador=1;
                        $NumCate = mysqli_num_rows($ResultadoCategoria);
                        // echo ("son: ".$NumCate." categorias");
                        while ($mostrarPuntaje = $ResultadoJeopardy->fetch_assoc()) {
                          //echo "-".$mostrarPuntaje['puntaje']."-";
                          if($Contador==$NumCate){ 
                            ?>
                             <td>
                            <button type="button" class="btn btn-block fondoPuntaje" data-toggle="modal" data-target=".bs-example-modal-lg" id="btn_puntaje_<?php echo $mostrarPuntaje['id'];?>" onclick="identificaID(<?php echo $mostrarPuntaje['id'];?>);"><?php echo $mostrarPuntaje['puntaje'];?> 
                            </button>
                            </td>
                        <?php
                            echo "</tr>";
                            $Contador=0;
                            //echo $Contador;
                            echo "<tr>";
                          }
                          else{

                              //echo $Contador;
                        ?>
                        <td>
                          <button type="button" class="btn btn-block fondoPuntaje" data-toggle="modal" data-target=".bs-example-modal-lg" id="btn_puntaje_<?php echo $mostrarPuntaje['id'];?>" onclick="identificaID(<?php echo $mostrarPuntaje['id'];?>);"><?php echo $mostrarPuntaje['puntaje'];?> 
                          </button>
                        </td>
                        <?php
                          }
                          $Contador++;
                        }
                        echo "</tr>";
                      ?>
                    </tbody>
                  </table>
                  <br>
                  <!-- modal para abrir la pregunta-->
                  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal-lg">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content" class="estilos" id="jeo">
                      <div class="modal-header" class="text-edit">
                        <div class="encabezado" id="categoriaAux"><h5 id="categoria" align="left"></h5></div>
                      </div>
                      <div class="modal-body" align="center">
                        <div class="encabezado" align="center" id="preguntaAux"><h3 align="center" id="pregunta"></h3></div>
                        <br>
                        <table width="100%" align="center">
                          <tr>
                            <td width="50%"><div class="btnR" id="btn1Aux" onclick="oprimir(0);"><h6 align="left" id="btn1"></h6></div></td>
                            <td width="50%"><div class="btnR" id="btn2Aux" onclick="oprimir(1);"><h6 align="left" id="btn2"></h6></div></td>
                          </tr>
                          <tr>
                            <td width="50%"><div class="btnR" id="btn3Aux" onclick="oprimir(2);"><h6 align="left" id="btn3"></h6></div></td>
                            <td width="50%"><div class="btnR" id="btn4Aux" onclick="oprimir(3);"><h6 align="left" id="btn4"></h6></div></td>
                          </tr>
                        </table>
                      </div>   
                    </div>
                  </div>
                </div>
                  
                  <div class="col-md-4"></div>
                  <div class="col-md-4" align="center">
                  <div class="x_panel">
                    <div class="x_content">
                      <div align="center">                          
                      <a class="btn btn-danger submit" href="crear_actividades.php?idGrupo=<?php echo $_GET['idGrupo'];?>&idHistoria=<?php echo $_GET['idHistoria']?>&idActividad=<?php echo $_GET['idActividad'];?>">Siguiente</a> 
                      </div>        
                    </div>                      
                  </div>
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

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../tables/css/jeopardy/crudRespuestasJeopardy.js"></script>
  </body>
</html>
