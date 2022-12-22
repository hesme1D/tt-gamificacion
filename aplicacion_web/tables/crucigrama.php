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
  //Obtener registro x registro
  $bandRegistros=1;

  $historia=$_GET['idHistoria'];
  $tipo = $_GET['tipo'];
  $id_crucigrama = $_GET['idActividad'];
  //$memorama = $RenglonId['id'];//falla aquí
  $QueryCruci = "SELECT * FROM crucigrama WHERE id_actividades='$id_crucigrama'";
  //echo $QuerySerpYesc;
  $ResultadoC = mysqli_query($Con, $QueryCruci);
  $resC = mysqli_fetch_array($ResultadoC);
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

    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
	
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
                <h2><?php echo $row['nombre'];?></h2>
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

          <h3 align="right"><button type="button" name="tipsCruci" class="btn-round btn-primary" data-toggle="modal" data-target="#tipsCruci" align="right"><i class="fa fa-info-circle"></i></button></h3>
          <h1>Crucigrama</h1>
          <input type="hidden" name="tipo" id="idTipo" value="<?php echo $tipo;?>">
          <input type="hidden" name="idGrupo" id="idGrupo" value="<?php echo $_GET['idGrupo']?>">
          <input type="hidden" name="idHistoria" id="idHistoria" value="<?php echo $_GET['idHistoria']?>">
           <input type="hidden" name="idActv" id="idActv" value="<?php echo $_GET['idActividad'];?>">
          <div class="tile_count" align="center">
            <form class="form-horizontal" method="POST" id="idcru"> 
              <br>  
              <div class="col-md-12 col-sm-12 ">
                

                  <!-- agregar datos de crucigrama (palabra y descripción)-->
                  <div align="right">
                  <button type="button" class="btn btn-primary submit" data-toggle="modal" data-target="#Agregar">Agregar</button> </div><br>

                  <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                        <th>Palabra</th>
                        <th>Descripción</th>
                        <th width="10%" align="center"></th>
                        <th width="10%" align="center"></th>
                      </tr>
                      </thead>
                      <?php  
                        $QueryCrucigrama = "SELECT * FROM crucigrama_preguntas WHERE crucigrama_id_actividades = '$id_crucigrama'";
                        $ResultadoCrucigrama=mysqli_query($Con,$QueryCrucigrama);
                        if ($bandRegistros==1) {
                          // code...
                          //GENERAR LOS RENGLONES DE LA TABLA
                          while ($renglonCrucigrama=mysqli_fetch_array($ResultadoCrucigrama)) {
                            // code...
                            echo "<tr id='row_".$renglonCrucigrama['id']."'>";
                            echo "<td>".$renglonCrucigrama['palabra']."</td>";
                            echo "<td>".$renglonCrucigrama['descripcion']."</td>";
                            echo '<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal-success" onclick="IdentificaActualizar('.$renglonCrucigrama['id'].')"><i class="fa fa-edit"></i></button></td>';
                            echo '<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target=".modal-danger" onclick="IdentificaEliminar('.$renglonCrucigrama['id'].')"><i class="fa fa-trash"></i></button></td>';
                            echo "</tr>";
                          }
                        }
                      ?>
                      <tbody>
                        
                      </tbody>
                  </table>

                  <!--Modal tips-->
                  <div id="tipsCruci" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
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
                              <li data-target="#carouselExampleIndicators" data-slide-to="2" class="active"></li>
                              <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                            </ol>
                            <div class="carousel-inner" style="width:800px">
                              <div class="carousel-item active">
                                <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="First slide">¿En qué consiste el juego?</h5>
                                <hr style="background-color: #75163F; width: 50%;">
                                <br>
                                <h6 style="color: #75163F; font-family:sans-serif;">El crucigrama es un juego o pasatiempo lúdico de destreza intelectual que consiste en rellenar las casillas en blanco con letras de modo que horizontal y verticalmente formen palabras; para ello se ofrecen sus definiciones divididas en horizontales y verticales.</h6>
                              </div>
                              <div class="carousel-item" >
                                <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="Second slide">¿Cómo agregar palabras al crucigrama?</h5>
                                <hr style="background-color: #75163F; width: 50%;">
                                <h6 style="color: #75163F; font-family:sans-serif;">Al hacer clic en el botón "Agregar", se mostrará una ventana que contiene los campos "Palabra" y "Descripción" dichos campos se llenan y se guardan para generear la lista de palabras a utilizar. Las palabras agregadas se mostrarán a manera de tabla y en caso de algún error pueden ser editadas o eliminadas. <br>
                                Al darle clic en "Guardar cambios y mostrar" podrás visualizar la vista previa del juego.</h6>
                              </div>
                              <div class="carousel-item">
                                <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="Third slide">¿Cómo resolver el crucigrama?</h5>
                                <hr style="background-color: #75163F; width: 50%;">
                                <h6 style="color: #75163F; font-family:sans-serif;">La vista previa del juego muestra un crucigrama generado aleatoriamente con la lista de palabras (cada crucigrama que se genere al actualizar la página será diferente y puede contener mayor o menor número de palabras). Las casillas del crucigrama tienen un ID que hace referencia a su descripción correspondiente mostrada en las tablas en la parte inferior del crucigrama.</h6>
                              </div>
                              <div class="carousel-item">
                                <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="Fourth slide">¿Cómo resolver el crucigrama?</h5>
                                <hr style="background-color: #75163F; width: 50%;">
                                <h6 style="color: #75163F; font-family:sans-serif;">Se tienen dos botones: la <b>pista</b> es una herramienta que muestra una palabra del crucigrama para ayudar al usuario a resolverlo; el botón <b>validar</b> permite verificar si los campos se llenaron de manera adecuada, cabe recalcar que es importante el uso correcto de <b>acentos</b> en las palabras que lo requieran, de lo contrario será incorrecto.</h6>
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

                  <!-- inicio modal agregar -->
                  <form class="form-horizontal" method="POST" id="idCrucigrama">
                  <div id="Agregar" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header" >
                          <h3 class="modal-title" id="myModalLabel" style="color: #265E31;">Agregar nueva palabra</h3>
                          <button type="button" class="close" data-dismiss="modal" ><span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <!-- actualizar palabras-->
                        <div class="modal-body">
                          
                            <table>
                              <!--Recuadro para la palabra-->
                              <div class="col-md-12">
                                <div class="box box-solid" style="background: #78E58F; border-color: #78E58F;">
                                  <div class="box-header with-border">
                                    <h5 class="box-title" style="color: #265E31;">Palabra</h5>
                                  </div>
                                  <!-- /.box-header -->
                                  <div class="box-body">
                                    <!--Aquí van los inputs-->
                                    <input type="text-transform:uppercase;" class="form-control" placeholder="Palabra" id="palabra" onkeyup="javascript:this.value=this.value.toUpperCase();">
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
                              
                              <!--Recuadro para la descripcion-->
                              <div class="col-md-12">
                                <div class="box box-solid" style=" background: #78E58F; border-color: #78E58F;">
                                  <div class="box-header with-border">
                                    <h5 class="box-title" style="color: #265E31;">Descripción</h5>
                                  </div>
                                  <!-- /.box-header -->
                                  <div class="box-body">
                                    <!--Aquí van los inputs-->
                                    <input type="text" class="form-control" placeholder="Descripción" id="desc">
                                  </div>
                                  <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                              </div>          
                            </table>

                        </div>


                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                          <input type="button" class="btn btn-primary " name="guardarPaCruci" value="Guardar" onclick="guardarPalabra();">
                          
                        </div>

                      </div>
                    </div>
                  </div>
                 </form> 

                  <!--Modal para editar-->
                  <div id="Editar" class="modal modal-success" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="myModalLabel" style="color: #265E31;">Editar palabra</h3>
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <table id="tablaCrucigrama">
                            <!--Recuadro para la palabra-->
                            <div class="col-md-12">
                              <div class="box box-solid" style="background: #78E58F; border-color: #78E58F;">
                                <div class="box-header with-border">
                                  <h5 class="box-title" style="color: #265E31;">Palabra</h5>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                  <!--Aquí van los inputs-->
                                  <input type="text-transform:uppercase;" class="form-control" placeholder="Palabra" id="updateP" onkeyup="javascript:this.value=this.value.toUpperCase();">
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
                            
                            <!--Recuadro para la descripcion-->
                            <div class="col-md-12">
                              <div class="box box-solid" style=" background: #78E58F; border-color: #78E58F;">
                                <div class="box-header with-border">
                                  <h5 class="box-title" style="color: #265E31;">Descripción</h5>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                  <!--Aquí van los inputs-->
                                  <input type="text" class="form-control" placeholder="Descripción" id="updateDesc">
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.box -->
                            </div>          
                          </table>
                        </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" name="actualizar" onclick="updatePalabraC(); ">Actualizar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    

                  <!--Modal para eliminar-->
                  <div class="modal modal-danger fade" id="modal-danger">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="myModalLabel" style="color: #265E31;">ADVERTENCIA</h3>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                         <h6 style="color: #265E31">La confirmación eliminará la siguiente pregunta:</h6>
                        <br>
                        <h6 class="box-title" id="idPalabra" style="color: #367037;"></h6>
                        <br>
                        <h6 style="color: #265E31"><b>¿Desea eliminarla?&hellip;</b></h6>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                          <button type="button" class="btn btn-outline" name="eliminar" onclick="deleteCrucigrama();">Eliminar</button>
                        </div>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                    <!-- fin modals -->

                  <div align="center">
                    <br>
                    
                    <a class="btn btn-danger" style="width: 30%;" href="nom_clase.php?idGrupo=<?php echo $_GET['idGrupo'];?>">Guardar cambios y volver al inicio</a>
                    <a class="btn btn-secondary" style="width: 30%;" href="mostrar_crucigrama.php?idGrupo=<?php echo $_GET['idGrupo'];?>&idHistoria=<?php echo $_GET['idHistoria']?>&idActividad=<?php echo $_GET['idActividad'];?>">Guardar cambios y mostrar</a> 
                    <input type="hidden" name="idTipo" id="idTipo" value="<?php echo $_GET['idTipo']?>">
                  </div>

                </div>
              </div>
            </form>
          </div> 
        </div>
        <!-- fin página blanco--> 
      </div>
    </div> 

    <!-- jQuery -->
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
    <!-- bootstrap-wysiwyg -->
    <script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="../vendors/google-code-prettify/src/prettify.js"></script>
    <!-- jQuery Tags Input -->
    <script src="../vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="../vendors/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="../vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="../vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="../vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="../vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="../vendors/starrr/dist/starrr.js"></script>
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

    <!-- bootstrap-wysiwyg -->
    <script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="../vendors/google-code-prettify/src/prettify.js"></script>


    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

    <script src="../tables/crudCrucigrama.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   
  </body>
</html>
