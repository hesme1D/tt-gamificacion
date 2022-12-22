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

  /*$QueryActividad = "SELECT * FROM actividades WHERE id_historia='$historia' AND id = (SELECT MAX(id) from actividades)";
  //echo $QueryActividad;
  $ResultQueryA = $Con->query($QueryActividad);
  $RenglonId = $ResultQueryA->fetch_assoc(); */
  
  $bandRegistros =1;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">

    <title>GAMIWEB</title>

    <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
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
        <div class="right_col" style="height: 130vh;">
          <h3 align="right"><button type="button" name="tipsSerp" class="btn-round btn-primary" data-toggle="modal" data-target="#tipsSerp" align="right"><i class="fa fa-info-circle"></i></button></h3>

          <h1>Serpientes y escaleras</h1>
          <input type="hidden" name="tipo" id="idTipo" value="<?php echo $tipo;?>">
          <input type="hidden" name="idGrupo" id="idGrupo" value="<?php echo $_GET['idGrupo'];?>">
          <input type="hidden" name="idHistoria" id="idHistoria" value="<?php echo $_GET['idHistoria'];?>">
          <div class="tile_count" align="center">
            <form class="form-horizontal" method="POST" id="preguntas">
              <div align="left"> <!--nombre actividad-->
                <table>
                  <tr style="align-items: center;">
                    <td width=""><h3>Nombre actividad  </h3></td>
                    <td style="align-content: center;"><input type="text" name="nom_act" id="nom_act" placeholder="Nombre actividad" style="border-radius: 10px; width: 200px;"></td>
                  </tr>
                </table>
              </div>  
              <br>  
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h5>Definir historia</h5>
                      
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content"> <!--Text area-->
                  <div id="alerts"></div>
                  <!-- editor WYSIWYG -->
                  <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editorOne">
                    
                    <div class="btn-group">
                      <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li>
                          <a data-edit="fontSize 5">
                            <p style="font-size:17px">Huge</p>
                          </a>
                        </li>
                        <li>
                          <a data-edit="fontSize 3">
                            <p style="font-size:14px">Normal</p>
                          </a>
                        </li>
                        <li>
                          <a data-edit="fontSize 1">
                            <p style="font-size:12px">Small</p>
                          </a>
                        </li>
                      </ul>
                    </div>

                    <div class="btn-group">
                      <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                      <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                      <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                      <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                    </div>

                    <div class="btn-group">
                      <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                      <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                      <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                      <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                    </div>

                    <div class="btn-group">
                      <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                      <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                      <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                      <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                    </div>
                  </div>
                  
                    <div id="editorOne" class="editor-wrapper"></div>
                    <textarea name="descr" id="descr" style="display:none;"></textarea>
                    
                    <br>

                    <input type="button" align="center" class="btn btn-success" name="guardarSerpientes"  value="Guardar Historia" onclick="crearActividad(<?php echo $_GET['idHistoria']?>,<?php echo $_GET['tipo']?>); guardarTextSerpYesc();">

                <!--Modal tips-->
                <div id="tipsSerp" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
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
                          <div class="carousel-inner" style="width:800px">
                            <div class="carousel-item active">
                              <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="First slide">¿Qué debe ir en el campo "Definir Historia"?</h5>
                              <hr style="background-color: #75163F; width: 50%;">
                              <br>
                              <h6 style="color: #75163F; font-family:sans-serif;">La historia particular debe tener una completa relación con la historia principal antes descrita ya que sirve para <b>complementar</b> y <b>agregar detalles específicos</b> de cada actividad al contexto del juego.</h6>
                            </div>
                            <div class="carousel-item" >
                              <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="Second slide">¿En qué consiste el juego?</h5>
                              <hr style="background-color: #75163F; width: 50%;">
                              <h6 style="color: #75163F; font-family:sans-serif;">El juego de mesa virtual consiste en un tablero que tiene serpientes y escaleras. El jugador tiene que lanzar un dado para poder avanzar en el tablero, pero cuidado porque este juego tiene obstáculos.</h6>
                            </div>
                            <div class="carousel-item">
                              <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="Second slide">¿En qué consiste el juego?</h5>
                              <hr style="background-color: #75163F; width: 50%;">
                              <h6 style="color: #75163F; font-family:sans-serif;">. Si se cae en una serpiente el jugador tendrá que responder una pregunta de opción múltiple; si la respuesta es correcta el jugador podrá seguir avanzando, de lo contrario caerá. Por otra parte, si el jugador cae en una escalera deberá responder una pregunta, si la respuesta es correcta podrá subir la escalera, de no ser así, se queda en su casilla de juego.</h6>
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

            </form>
          </div>
        </div>
      </div>
    </div>
        </div>

        </div>
        <!-- fin pág blanco-->  
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

    <!-- bootstrap-wysiwyg -->
    <script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="../vendors/google-code-prettify/src/prettify.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

    <script src="../tables/crudSerpYesc.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	
  </body>
</html>
