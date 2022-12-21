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

  $historia=$_GET['idHistoria'];
  $tipo = $_GET['tipo'];

  $id_memorama= $_GET['idActividad'];
  $QueryMemorama = "SELECT * FROM memorama WHERE id_actividades='$id_memorama'";
  $ResultadoM = mysqli_query($Con, $QueryMemorama);
  $num_rows = mysqli_num_rows($ResultadoM);
  $ResM = mysqli_fetch_array($ResultadoM);
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

        <!-- inicio página blanco -->
        <div class="right_col">
          <h3 align="right"><button type="button" name="tipsMem" class="btn-round btn-primary" data-toggle="modal" data-target="#tipsMem" align="right"><i class="fa fa-info-circle"></i></button></h3>

          <h1>Memorama</h1>
          <input type="hidden" name="tipo" id="idTipo" value="<?php echo $tipo;?>">
          <input type="hidden" name="idGrupo" id="idGrupo" value="<?php echo $_GET['idGrupo'];?>">
          <input type="hidden" name="idHistoria" id="idHistoria" value="<?php echo $_GET['idHistoria'];?>">
          <input type="hidden" name="idActv" id="idActv" value="<?php echo $_GET['idActividad']?>">
          <div class="tile_count" align="center">
            <form class="form-horizontal" method="POST">
              <br>
              <div>
                <div class="col-md-12">
                    
                    <?php
                      if ($num_rows=='1'){
                    ?>
                    


                    <div class="title_right" align="left">
                      <h3>Seleccionar imágenes</h3>
                      <?php 
                        $QueryImagen = "SELECT * FROM imagenes WHERE memorama_id_actividades='$id_memorama'";
                        //echo $QueryImagen;
                        $ResImagen = mysqli_query($Con, $QueryImagen);
                        $filas = mysqli_num_rows($ResImagen);

                      ?>
                      <div class="col-md-5 col-sm-12 col-xs-12 form-group pull-right top_search"></div>

                      <div class="col-md-12">
                        <section id="Images" class="images-cards">
                          <form class="form-horizontal" method="POST" enctype="multipart">
                            <div>
                             <br>
                             <label for="imgAdd"> </label>
                             <input type="file" name="img" size="60" id="seleccionImagen"  accept="image/png">
                             <div id="muestraImg"></div>
                            </div>
                            <br>

                            <?php 
                            if($filas<=12)
                            {
                              echo '<button type="button" class="btn btn-primary submit" name="guardar" id="guardar" onclick="guardarImagen();">Guardar</button>';
                            }else{
                              echo '<button type="button" class="btn btn-primary submit" name="guardar" id="guardar" onclick="guardarImagen();" disabled>Guardar</button>';
                            }
                          ?>
                            
                          </form>
                        </section>
                        <br>
                      </div>
                    </div>

                    <br>

                     <!-- aquí inicia la visualización de las imágenes -->
                      <?php
                        while($nuevo_R = mysqli_fetch_array($ResImagen)) {   
                        echo '<div class="col-md-6 col-sm-6 col-lg-4" id="row_">';
                        echo '<div class="animated flipInY" id="btn_imagen">';
                          echo '<button  type="button" class="btn" data-toggle="modal" data-target=".modal-danger" onclick="IdentificaEliminar('.$nuevo_R['id'].')" background="black;" >
                            <img src="'.$nuevo_R['imagen'].'" height="200" width="200" align="center">
                          </button>';
                        echo '</div>';
                      echo '</div>';
                        }
                      }
                    ?>
                    <!-- fin visualización imágenes -->

                    <!--Modal tips-->
                    <div id="tipsMem" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content" style="width: 130%;">
                          <div class="modal-header">
                            <h3 class="modal-title" id="myModalLabel" style="color: #75163F">Tips</h3>
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                          </div>
                        <div class="modal-body">
                          <table>
                            <!--Recuadro para el tip-->
                            <div class="col-md-12" style="height: 35vh;">
                            <div class="box box-solid" style="background: #EBB9F8; border-color: #EBB9F8; height: 220px;">
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="width:800px; height: 180px; align-items: center;">
                              <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                              </ol>
                              <div class="carousel-inner" style="width:800px">
                                <div class="carousel-item active">
                                  <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="First slide">¿En qué consiste el juego?</h5>
                                  <hr style="background-color: #75163F; width: 35%;">
                                  <br>
                                  <h6 style="color: #75163F; font-family:sans-serif;">El memorama es un juego que puede ayudar a memorizar conceptos e información, consiste en una serie de cartas con pares acomodadas de manera inversa y aleatoria en la pantalla a manera de tablero. El usuario va destapando cartas al azar para descubrir las imágenes iguales. El juego termina cuando se agoten los intentos permitidos</h6>
                                </div>
                                <div class="carousel-item" >
                                  <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="Second slide">¿Qué tipo de formato de imagen se puede seleccionar?</h5>
                                  <hr style="background-color: #75163F; width: 35%;">
                                  <h6 style="color: #75163F; font-family:sans-serif;">Para agregar las imágenes al memorama es necesario que dichas imágenes estén en formato <b>PNG</b></h6>
                                </div>
                                <div class="carousel-item">
                                  <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="Third slide">¿Cómo agregar imágenes al tablero?</h5>
                                  <hr style="background-color: #75163F; width: 35%;">
                                  <br>
                                  <h6 style="color: #75163F; font-family:sans-serif;">Al seleccionar el botón "Elegir archivo" se selecciona <b>una imagen</b>, una vez seleccionada es necesario dar clic en "Guardar" para poder visualizarla y agregar más. Es decir, se agregan de una por una.<br>Se pueden agregar un mínimo de 6 imágenes y un máximo de 12.<br>
                                  Al darle clic en "Guardar cambios y mostrar" podrás visualizar la vista previa del juego.</h6>
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

                    <!-- modal para eliminar imagen -->
                    <div class="modal modal-danger fade" id="modal-danger">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title"> ADVERTENCIA</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>

                          <div class="modal-body">
                            <h6>La confirmación eliminará los datos seleccionados </h6>
                            <br>

                            <h6><b>¿Desea eliminarlos?</b></h6>
                          </div>

                          <div class="modal-footer">
                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-outline" name="eliminar" onclick="deleteImage();">Eliminar</button>
                          </div>

                        </div>
                      </div>
                    </div>

                    <!--  -->
                    <br>
                    <br>
                    <div class="col-md-12"></div>
                    <br>
                    <div  class="col-md-12" align="center">
                    <br>
                    <a class="btn btn-danger" style="width: 30%;" href="nom_clase.php?idGrupo=<?php echo $_GET['idGrupo'];?>">Guardar cambios y volver al inicio</a>
                    <a class="btn btn-secondary" style="width: 30%;" href="mostrar_memorama.php?idGrupo=<?php echo $_GET['idGrupo'];?>&idHistoria=<?php echo $_GET['idHistoria']?>&idActividad=<?php echo $id_memorama;?>">Guardar cambios y mostrar</a> 
                    <input type="hidden" name="idTipo" id="idTipo" value="<?php echo $_GET['idTipo']?>">
                  </div>
                   <div class="col-md-12">
                     
                   </div> 
                   <br>
                   <br>
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
    <!-- bootstrap-wysiwyg -->
    <script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="../vendors/google-code-prettify/src/prettify.js"></script>
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

    <script src="../tables/crudMemorama.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  </body>
</html>
