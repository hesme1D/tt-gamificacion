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

  $bandRegistros =1;

  $actividad = $_GET['idActividad'];
  $QueryRetos = "SELECT * FROM retos_preguntas WHERE actividades_id = '$actividad'";
  $ResultadoRetos = mysqli_query($Con, $QueryRetos);

  $num_filas = mysqli_num_rows($ResultadoRetos);

  /****************************************************************************************/


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

    <!-- PNotify -->
    <link href="../vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
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
                      <li><a href="nom_clase.php?idGrupo=<?php echo $mostrar['id']?>"><?php echo $mostrar['nomGrupo'];?></a></li>

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
                    <a href="usuario" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
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
        <div class="right_col">
           <!-- Este boton muestra la ultima actividad creada -->
            <input type="hidden" name="idActv" id="idActv" value="<?php echo $_GET['idActividad'];?>">
            <input type="hidden" name="idGrupo" id="idGrupo" value="<?php echo $_GET['idGrupo'];?>">
            <input type="hidden" name="idHistoria" id="idHistoria" value="<?php echo $_GET['idHistoria'];?>">

          <h3 align="right"><button type="button" name="tipsRetos" class="btn-round btn-primary" data-toggle="modal" data-target="#tipsRetos" align="right"><i class="fa fa-info-circle"></i></button></h3>
          <h3>Retos</h3>
           <div class="tile_count" align="center">
            <form class="form-horizontal" method="POST" id="retosId">
              <div class="col-md-12 col-sm-12"> 
                <div class="x_panel">
                  <div class="x_content">
                    <div class="title_right">

                        <h3 align="right">
                          <?php 
                            if($num_filas<3){
                              echo '<button id="btn_retos" type="button" class="btn btn-primary" data-toggle="modal" data-target="#retos_preguntas">Agregar</button>';
                            }else{
                              echo '<button id="btn_retos" type="button" class="btn btn-primary" data-toggle="modal" data-target="#retos_preguntas" disabled>Agregar</button>';
                            }
                          ?>
                        </h3>
                      </div>
                        <br>
                      <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                          <tr>
                          <th>Pregunta</th>
                          <th>Inciso a)</th>
                          <th>Inciso b)</th>
                          <th>Inciso c)</th>
                          <th>Inciso d)</th>
                          <th>Puntuación</th>
                          <th></th>
                          <th></th>
                        </tr>
                        </thead>
                        <tbody>
                          <?php  
                        if ($bandRegistros==1) {
                          // code...
                          //GENERAR LOS RENGLONES DE LA TABLA
                          
                          while ($renglonRetos=mysqli_fetch_array($ResultadoRetos)){
                            // code...
                            echo "<tr id='row_".$renglonRetos['id']."'>";
                            echo "<td>".$renglonRetos['pregunta']."</td>";
                            echo "<td>".$renglonRetos['respuesta']."</td>";
                            echo "<td>".$renglonRetos['inc_uno']."</td>";
                            echo "<td>".$renglonRetos['inc_dos']."</td>";
                            echo "<td>".$renglonRetos['inc_tres']."</td>";
                            echo "<td>".$renglonRetos['puntaje']."</td>";
                            echo '<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal-success" onclick="IdentificaActualizar('.$renglonRetos['id'].')"><i class="fa fa-edit"></i></button></td>';
                            echo '<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target=".modal-danger" onclick="IdentificaEliminar('.$renglonRetos['id'].')"><i class="fa fa-trash"></i></button></td>';
                            echo "</tr>";
                          }
                        }
                        ?>
                        </tbody>
                      </table>

                      <!--MODALS-->

                      <!--Modal tips-->
                      <div id="tipsRetos" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
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
                                  <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                                </ol>
                                <div class="carousel-inner" style="width:800px">
                                  <div class="carousel-item active">
                                    <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="First slide">¿Cuál es el objetivo de los retos?</h5>
                                    <hr style="background-color: #75163F; width: 50%;">
                                    <br>
                                    <h6 style="color: #75163F; font-family:sans-serif;">Ayudar a los alumnos con menor progreso para que puedan aumentar su avance o su ponderación en el ranking.</h6>
                                  </div>
                                  <div class="carousel-item" >
                                    <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="Second slide">¿En qué consiste el juego?</h5>
                                    <hr style="background-color: #75163F; width: 50%;">
                                    <h6 style="color: #75163F; font-family:sans-serif;">Consiste en generar un máximo de 3 preguntas de opción múltiple por reto, las cuáles al igual que en el quiz tienen puntaje por pregunta.</h6>
                                  </div>
                                  <div class="carousel-item">
                                    <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="Thirdh slide">¿Cómo genero las preguntas?</h5>
                                    <hr style="background-color: #75163F; width: 50%;">
                                    <h6 style="color: #75163F; font-family:sans-serif;">Al darle clic en "Agregar" se muestra una ventana que permite agregar las preguntas con sus posibles respuestas y su puntaje. Se deben respetar los espacios desigados, principalmente para la pregunta y la respuesta correcta.</h6>
                                  </div>
                                  <div class="carousel-item">
                                    <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="Fourth slide">¿Qué pasa si me equivoco al guardar las preguntas?</h5>
                                    <hr style="background-color: #75163F; width: 50%;">
                                    <h6 style="color: #75163F; font-family:sans-serif;">Las preguntas se mostrarán a manera de tabla conforme se vayan guardando. Los botones que aparecen permiten editar y eliminar respectivamente. <br>Al darle clic en "Guardar cambios y mostrar" podrás visualizar la vista previa del juego. Cabe mencionar que las preguntas cambian de manera automática cada vez que se seleccione una respuesta.</h6>
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

                      <!--Modal para agregar-->
                      <div id="retos_preguntas" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h3 class="modal-title" id="myModalLabel" style="color: #C99368;">Agregar nueva pregunta</h3>
                              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <table>
                                <!--Recuadro para la pregunta-->
                                <div class="col-md-12">
                                  <div class="box box-solid" style=" background: #fffe91; border-color: #fffe91">
                                    <div class="box-header with-border">
                                      <h5 class="box-title" style="color: #C99368">Pregunta</h5>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                      <!--Aquí van los inputs-->
                                      <input type="text" class="form-control" placeholder="Pregunta" id="pregunta">
                                    </div>
                                      <!-- /.box-body -->
                                  </div>
                                  <!-- /.box -->
                                </div>
                                <!--Estos div dan espacio entre los recuadros-->
                                <div class="col-md-12"></div>
                                <div class="col-md-12"></div>
                                <div class="col-md-12"></div>
                                <div class="col-md-12"></div>
                                <!--Recuadro para las respuestas-->
                                <div class="col-md-9">
                                  <div class="box box-solid" style="height: 150px; background: #fffe91; border-color: #fffe91">
                                    <div class="box-header with-border">
                                      <h5 class="box-title" style="color: #C99368;">Posibles respuestas</h5>
                                    </div>
                                    <!-- /.box-header -->
                                      <div class="box-body">
                                        <!--Aquí van los inputs-->
                                        <input type="text" class="form-control" placeholder="Respuesta" id="respuesta">
                                        <br>
                                        <input type="text" class="form-control" placeholder="Incorrecta 1" id="inc1">
                                        <br>
                                        <input type="text" class="form-control" placeholder="Incorrecta 2" id="inc2">
                                        <br>
                                        <input type="text" class="form-control" placeholder="Incorrecta 3" id="inc3">
                                      </div>
                                      <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->
                                  </div>
                                  <!--Recuadro para el puntaje-->
                                  <div class="col-md-3">
                                    <div class="box box-solid" style="height: 150px; background: #fffe91; border-color: #fffe91">
                                      <div class="box-header with-border">
                                        <br>
                                        <h5 class="box-title" style="color: #C99368;">Puntaje</h5>
                                      </div>
                                  <!-- /.box-header -->
                                    <div class="box-body">
                                      <!--Aquí van los inputs-->
                                      <input type="text" class="form-control" placeholder="Puntaje" id="puntaje">
                                    </div>
                                      <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->
                                  </div>
                                  </table>
                                  </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                                      <?php 
                                        if($num_filas<3)
                                        {
                                      
                                          echo '<button type="button" id="btn_uno" class="btn btn-primary submit" name="guardarRetos" onclick="addRetos();">Guardar</button>';
                                      
                                        }else{
                                          echo '<button type="button" id="btn_uno" class="btn btn-primary submit" name="guardarRetos" onclick="addRetos();" disabled>Guardar</button>';
                                        }
                                      ?>
                                    </div>
                                  </div>
                                </div>
                              </div>


                            <!--Modal para editar-->
                            <div class="modal modal-success" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                   <h3 class="modal-title" id="myModalLabel" style="color: #C99368;">Editar pregunta</h3>
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <table>
                                      <!--Recuadro para la pregunta-->
                                      <div class="col-md-12">
                                       <div class="box box-solid" style="background:#fffe91; border-color: #fffe91;">
                                          <div class="box-header with-border">
                                            <h5 class="box-title" style="color: #C99368">Pregunta</h5>
                                          </div>
                                          <!-- /.box-header -->
                                          <div class="box-body">
                                            <!--Aquí van los inputs-->
                                            <input type="text" class="form-control" placeholder="Pregunta" id="update_pregunta">
                                          </div>
                                          <!-- /.box-body -->
                                        </div>
                                        <!-- /.box -->
                                      </div>
                                      <!--Estos div dan un poco de espacio entre los recuadros-->
                                      <div class="col-md-12"></div>
                                      <div class="col-md-12"></div>
                                      <div class="col-md-12"></div>
                                      <div class="col-md-12"></div>
                                      <!--Recuadro para las respuestas-->
                                      <div class="col-md-9">
                                        <div class="box box-solid" style="height: 150px; background: #fffe91; border-color: #fffe91">
                                          <div class="box-header with-border">
                                            <h5 class="box-title" style="color: #C99368;">Posibles respuestas</h5>
                                          </div>
                                          <!-- /.box-header -->
                                          <div class="box-body">
                                            <!--Aquí van los inputs-->
                                            <input type="text" class="form-control" placeholder="Incorrecta 1" id="update_inc1">
                                            <br>
                                            <input type="text" class="form-control" placeholder="Respuesta" id="update_respuesta">
                                            <br>
                                            <input type="text" class="form-control" placeholder="Incorrecta 2" id="update_inc2">
                                            <br>
                                            <input type="text" class="form-control" placeholder="Incorrecta 3" id="update_inc3">
                                          </div> 
                                          <!-- /.box-body -->
                                        </div>
                                        <!-- /.box -->
                                      </div>
                                      <!--Recuadro para el puntaje-->
                                      <div class="col-md-3">
                                         <div class="box box-solid" style="height: 150px; background: #fffe91; border-color: #fffe91">
                                          <br>
                                          <div class="box-header with-border">
                                            <h5 class="box-title" style="color: #C99368;">Puntaje</h5>
                                          </div>
                                          <!-- /.box-header -->
                                            <div class="box-body">
                                              <!--Aquí van los inputs-->
                                              <input type="text" class="form-control" placeholder="Puntaje" id="updatePuntaje">
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                          <!-- /.box -->
                                      </div>
                                    </table>
                                  </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                      <button type="button" class="btn btn-primary" name="actualizarReto"  onclick="updateRetos();">Guardar</button>
                                    </div>
                                  </div>
                                </div>
                              </div>

                          <!--Modal para eliminar-->
                          <div class="modal modal-danger fade" id="modal-danger">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h3 class="modal-title" id="myModalLabel" style="color: #c99368">ADVERTENCIA</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                  <h6 style="color: #c99368">La confirmación eliminará la siguiente pregunta:</h6>
                                <br>
                                <h6 class="box-title" id="idpregunta" style="color: #D4AF37;"></h6>
                                <br>
                                <h6 style="color: #c99368"><b>¿Desea eliminarla?&hellip;</b></h6>
                               </div>
                              
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                 <input type="button" align="center" class="btn btn-primary " name="guardarPregunta" value="Eliminar" onclick="deleteRetos();" data-dismiss="modal">
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                          <br>
                    <div>
                     <a class="btn btn-danger" style="width: 30%;" href="nom_clase.php?idGrupo=<?php echo $_GET['idGrupo'];?>">Guardar cambios y volver al inicio</a>
                      <a class="btn btn-secondary" style="width: 30%;" href="mostrar_retos.php?idGrupo=<?php echo $_GET['idGrupo'];?>&idHistoria=<?php echo $_GET['idHistoria']?>&idActividad=<?php echo $_GET['idActividad'];?>">Guardar cambios y mostrar</a> 
                    </div>
                    
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- fin página en blanco -->
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

    <!-- PNotify -->
    <script src="../vendors/pnotify/dist/pnotify.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.nonblock.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

    <script src="../tables/crudRetos.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
  </body>
</html>
