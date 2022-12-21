<?php 
  session_start();
  require 'conexion.php';
  require 'funcs.php';

  if (!isset($_SESSION['id_usuario'])) {
    // code...
    header("Location: login.php");
  }

  $idUsuario = $_SESSION['id_usuario'];

  $Cx = "SELECT id, nombre, apaterno, amaterno, user, foto FROM usuarios WHERE id = '$idUsuario'";
  $result = $Con->query($Cx);

  $row = $result->fetch_assoc();

  $errores = array();
  $resultado = array();

  $QueryUsuarios="SELECT * FROM usuarios";
    
  $idGrupo = $_GET['idGrupo'];
  
  //echo $idHistoria;
  
  $sql="SELECT * FROM grupo WHERE  id_user = '$idUsuario'";
  $result= $Con->query($sql); 
  //echo $num_rows;
  $bandRegistros=0;

 $idHistoria=0;

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
        <div class="right_col" style="height: 100%;">
          <div class="">
            <div class="page-title">
              <div class="title_left">
              </div>
            </div>

            <input type="hidden" name="idGrupo" id="idGrupo" value="<?php echo $_GET['idGrupo']?>">

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_content">

                    <h3 align="right"><button type="button" name="tipsHA" class="btn-round btn-primary" data-toggle="modal" data-target="#tipsHA" align="right"><i class="fa fa-info-circle"></i></button></h3>

                    <!-- mostrar la historia y el personaje-->
                    <div class="col-md-12">
                      <?php 
                        $sqlHis = "SELECT * FROM problematica where grupo_id_grupo = '$idGrupo'";
                        $resultHis = $Con->query($sqlHis);
                        $personaje = $resultHis->fetch_assoc();
                        $num_rows = mysqli_num_rows($resultHis);
                        if($num_rows == '1') {

                        
                        $idHistoria = $personaje['id'];
                      ?>
                        <div id="historiaG"></div>
                        <div class="col-md-12" align="center">
                          <canvas id="problematica" width="1000" height="500"></canvas>
                          <br>
                        </div>
                        
                      <?php
                        }
                      ?>
                    </div>
                    <br>
                    <div class="col-md-12"></div>
                    <div class="col-md-12"></div>
                    <div class="col-md-12"></div>
                    <div class="col-md-12"></div>
                    <br>

                    <!-- agregar alumnos-->
                      <div class="col-md-12 align-items-center" >
                        <div class="x_panel" align="center" style="border-radius: 10px; background: #E0E0E0;">
                          <div class="x_content">
                            <br />
                            <form class="form-horizontal form-label-left" style="align-content: center;">
                              <div class="form-group row " style="align-items: center;">
                                <div class="col text-center">
                                  <div>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#buscar-agregar">Agregar alumnos</button>
                                  </div>
                                  <br>
                                  <div>
                                  <?php 
                                   if($num_rows == '0') {
                                    ?>
                                     <a href="definir_historia.php?idGrupo=<?php echo $_GET['idGrupo']?>" type="button" class="btn btn-success"> Crear Historia </a>
                                   <?php
                                   }else{
                                    }
                                   ?>
                                  </div>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

                    <?php 
                      if($num_rows == '1') {
                    ?>
                     <!-- Crear actividades-->
                      <div class="col-md-12">
                        <div class="x_panel" style="border-radius: 10px; background: #E0E0E0;">
                          <div class="x_content">
                            <div class="col text-left">
                              <!-- valor de la historia-->

                              
                              <!--<input type="hidden" name="idHistoria" id="idHistoria" value=" echo $renglonResHistoria['id'];">-->
                              <font style="vertical-align: inherit; font-size: 22px;" class="fa fa-user"> Crear nueva actividad <a href="elegir_actividad.php?idGrupo=<?php echo $_GET['idGrupo']?>&idHistoria=<?php echo $idHistoria?> " class="fa fa-edit"></a></font>
                              
                            </div>
                          </div>
                        </div>  
                      </div>
                      <?php
                        }else{
                        
                        }
                      ?>

                      <!-- mostrar actividades -->
                      <div class="x_content">
                      <?php
                      $QueryACreada = "SELECT * FROM nomact WHERE id_historia='$idHistoria' ORDER BY id_actividades DESC ";
                      $resultAct = mysqli_query($Con, $QueryACreada);
                      //echo $sqlActCreada;
                        while ($mostrarAct=mysqli_fetch_array($resultAct)) {
                      ?>

                      <div class="col-md-12 col-center" >
                        <div class="animated flipInY col-lg-12 col-md-12 col-sm-12">
                          <div class="tile-stats" align="left">
                            <div >
                              <h3><a href="<?php echo $mostrarAct['url']?>?idGrupo=<?php echo $_GET['idGrupo']?>&idHistoria=<?php echo $idHistoria?>&tipo=<?php echo $mostrarAct['tipo_id']?>&idActividad=<?php echo $mostrarAct['id']?>"><?php echo $mostrarAct['nom_act']?></a></h3>
                              <h6><a><?php echo $mostrarAct['historia_part']?></a></h6>
                              <h4><?php echo $mostrarAct['nombre']?></h4>
                            </div>
                          </div>
                        </div>
                      </div>
                      <br>
                       <?php
                        }
                        //consulta para los retos
                      $QueryRetosC = "SELECT a.id, a.tipo_id, t.nombre,  t.url, h.historia FROM actividades  AS a JOIN tipo t ON(a.tipo_id=t.id) JOIN historia AS h ON(a.id_historia=h.id) WHERE t.id=6 AND a.id_historia='$idHistoria'";
                      $resultRetosC = mysqli_query($Con, $QueryRetosC);
                      //echo $sqlActCreada;
                        while ($RenglonC=mysqli_fetch_array($resultRetosC)) {
                      ?>

                      <div class="col-md-12 col-center" >
                        <div class="animated flipInY col-lg-12 col-md-12 col-sm-12">
                          <div class="tile-stats" align="left">
                            <div >
                              <h3><a href="<?php echo $RenglonC['url']?>?idGrupo=<?php echo $_GET['idGrupo']?>&idHistoria=<?php echo $idHistoria?>&tipo=<?php echo $RenglonC['tipo_id']?>&idActividad=<?php echo $RenglonC['id']?>"><?php echo $RenglonC['nombre']?></a></h3>
                              <h6><a><?php echo $RenglonC['historia']?></a></h6>
                              
                            </div>
                          </div>
                        </div>
                      </div>
                      <br>
                       <?php
                        }
                      ?>
                    </div>


                  </div>
                </div>
              </div>  
            </div>
          </div>
        </div>

        <!--Modal Tips-->
        <div id="tipsHA" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content" style="width: 110%;">
              <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel" style="color: #75163F">Tips</h3>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
              </div>
            <div class="modal-body">
              <table>
                <!--Recuadro para el tip-->
                <div class="col-md-12" style="height: 30vh;">
                <div class="box box-solid" style="background: #EBB9F8; border-color: #EBB9F8; height: 200px;">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="width:800px; height: 170px; align-items: center;">
                  <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                  </ol>
                  <div class="carousel-inner">
                    <div class="carousel-item active" style="width:800px" align="center">
                      <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="First slide">¿Qué pasa si doy clic en "Agregar alumnos"?</h5>
                      <hr style="background-color: #75163F; width: 50%;">
                      <h6 style="color: #75163F; font-family:sans-serif;">Se muestra una ventana que contiene dos secciones: la primera permite hacer una búsqueda de alumnos, una vez que el alumno se encontró dentro de la base de datos aparece en la parte inferior del buscador con un botón (+); al presionar dicho botón el alumno se agrega a la tabla de la siguiente sección y con eso queda agregado al grupo. Si se agregó un alumno por error, puede ser eliminado.</h6>
                    </div>
                    <div class="carousel-item" style="width:800px" align="center">
                      <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="Second slide">¿Qué pasa si doy clic en "Crear Historia"?</h5>
                      <hr style="background-color: #75163F; width: 50%;">
                      <h6 style="color: #75163F; font-family:sans-serif;">Se mostrará una nueva ventana en la cuál se hace una descripción <b>detallada</b> de la problemática a resolver medinate el juego, acompañada de un personaje creado por el usuario utilizando las imágenes que aparecerán al seleccionar la locación acorde a la problemática descrita. <br> Una vez creada la historia, se activará el botón para crear actividades</h6>
                    </div>
                    <div class="carousel-item" style="width:800px" align="center">
                      <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="Third slide">¿Qué pasa si doy clic en "Elegir actividad"?</h5>
                      <hr style="background-color: #75163F; width: 50%;">
                      <h6 style="color: #75163F; font-family:sans-serif;">Se mostrará una nueva ventana que permite la creación de actividades o retos para dar inicio con la gamificación de su contenido. <br>Las actividades creadas se mostrarán a manera de lista justo debajo del botón para crear actividades. Cabe mencionar que puedes acceder a tus actididades al dar clic en la actividad correspondiente.</h6>
                    </div>

                  </div>
                  
                </div>
                </div>
                <!-- /.box -->
                </div>
              </table>
            </div>
              <div class="modal-footer"></div>
            </div>
          </div>
        </div>
        
        <!--Modal para buscar y agregar alumnos-->
        <div id="buscar-agregar"class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" >
              <div class="modal-content" style="width: 110%;">
                <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Búsqueda de alumnos</h4>
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
                    <!--Recuadro para la pregunta-->
                    <div class="col-md-12">
                      <div class="box-body">
                          <!--Aquí van los inputs-->
                          <input type="hidden" name="idGrupo" id="idGrupo" value="<?php echo $_GET['idGrupo']?>">
                          <div class="col-md-12 col-sm-12  form-group pull-right top_search" align="center">
                            <div class="input-group">
                              <input type="text" id="busqueda" class="form-control" placeholder="Nombre alumno...">
                                <span class="input-group-btn">
                                <button id="buscar" class="btn btn-secondary" type="submit" onclick="buscaPalabra();">Buscar</button>
                                </span>
                              </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-12"></div>
                    <div class="col-md-12"></div>
                    <div class="col-md-12"></div>
                    <div class="col-md-12"></div>
                    <div>
                    <div class="col-md-12 col-sm-12  ">
                      <table class="table table-striped" id="tabla1">
                        <tbody>
                          <?php  
                            if (isset($_POST['palabra'])) {
                            // code...
                            $palabra = $_POST['palabra'];
                              
                            $QueryBusqueda= "SELECT id, nombre, apaterno, amaterno FROM usuarios WHERE nombre LIKE '%$palabra%' OR apaterno LIKE '%$palabra%' OR amaterno LIKE '%$palabra%'";
                            
                            $Resultado = mysqli_query($Con, $QueryBusqueda);
                          ?>
                          <tr>
                          <td width="85%" id="nomalumno"><h5 style="color: black;"><?php echo $renglon ?></h5></td>
                          <td align="center" width="15%"><button type="submit" class="btn btn-outline-inverse" name="addAlumno" id="addAlumno" onclick="addAlumno(); "><i class="fa fa-plus"></i></button></td>
                          </tr>
                         <!-- Aquí va el php  q quité -->
                         <?php  
                            }
                          ?>
                        </tbody>
                      </table>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Alumnos agregados</h4>
                        <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>-->
                      </div>
                      <div class="row">
                      <div class="col-sm-12">
                        <br>
                      <div class="card-box table-responsive">
                    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Apellido Paterno</th>
                          <th>Apellido Materno</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        //if ($bandRegistros==1) {
                          // code...
                        //echo ("hlola");
                        if (isset($_POST['addAlumno'])) {
                          // code...
                          //echo ("hola");
                          $QueryAlumnos ="SELECT * FROM grupo_usuarios WHERE id_grupo='$num_rowss'";
                           //echo $QueryAdd;
                            $ResultadoAdd=mysqli_query($Con,$QueryAlumnos);
                          
                          while ($renglonAlumno=mysqli_fetch_array($ResultadoAdd)) {
                            // code...

                            echo "<tr id='row".$renglonAlumno['id']."'>";
                            echo "<td>".$renglonAlumno['nombre']."</td>";
                            echo "<td>".$renglonAlumno['apaterno']."</td>";
                            echo "<td>".$renglonAlumno['amaterno']."</td>";
                            echo '<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target=".modal-danger" onclick="IdentificaEliminar('.$renglonAlumno['id_usuario'].')">Eliminar</button> </td>';
                          }
                        }

                        ?>
                        <br>
                      </tbody>
                    </table>
                  </div>
                  </div>
              </div>
                    </div>
                </div>
                </div>
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

    <script src="../tables/Buscador.js"></script>
    <script src="../tables/crudDefinir_historia.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
  </body>
</html>
