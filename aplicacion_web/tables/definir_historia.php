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
  
  //obtener id de la tabla grupo
  $sql="SELECT id, nomGrupo FROM grupo WHERE  id_user = '$idUsuario'";
  $result= $Con->query($sql); 

  $sqlHistoria = "SELECT * FROM historia";
  $resHis = $Con->query($sqlHistoria); 
  $renglonResHistoria=mysqli_fetch_array($resHis);

  $queryPaisaje = "SELECT * FROM paisaje";
  $ResultadoP = $Con->query($queryPaisaje);

  $queryPersonaje = "SELECT * FROM personaje";
  $ResultadoPer = $Con->query($queryPersonaje);
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

      <link href="../vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="../vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="../vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- starrr -->
    <link href="../vendors/starrr/dist/starrr.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <style type="text/css">
      tablescroll{
        height: 150px;
        width: 50%;
        overflow:auto;
      }
    </style>
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
          <div class="row">
          <h3>Crear actividades</h3>
          <div class="tile_count" align="center" >
            <form  method="POST"> 
              <br>
                <!-- text area-->
                <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h5>Definir historia</h5>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div id="alerts" ></div>
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
                        <div>

                      <!--inicio vista modal-->
                        <div class="x_title">
                          <h5>Definir persoanje</h5>
                        </div>

                        <div class="col-md-6">
                         <!--imagen 1 -->
                          <?php 
                            while ($newRen = $ResultadoP->fetch_assoc() ) {
                            
                          ?>
                          <div class="col-md-6 col-sm-6"  align="center">
                            <div class="animated flipInY" >
                             <img src="<?php echo $newRen['imagen_paisaje']; ?>" height="190" width="210" align="center"><br>
                                <input type="radio" name="idPaisaje" id="idPaisaje_<?php echo $newRen['id_paisaje'];?>" style="align-content: center;" value="<?php echo $newRen['id_paisaje']?>">
                            </div>
                            <br>
                          </div>
                          <?php
                            }
                          ?> 
                        
                        </div>


                      <div class="col-md-6">
                        <?php 
                          while ($ren = $ResultadoPer->fetch_assoc() ) {
                          
                        ?>
                          <div class="col-md-6 col-sm-6">
                            <div class="animated flipInY">
                              <img src="<?php echo $ren['imagen_personaje']; ?>" height="190" width="210" align="center"><br>
                              <input type="radio" name="idPersonaje" id="idPersonaje_<?php echo $ren['id_personaje'];?>" value="<?php echo $ren['id_personaje'];?>">
                              
                            </div>
                            <br>
                          </div>
                        <?php
                          }
                        ?> 
                        
                      </div>

                      <br>
                      <br>
                      <div class="col-md-6"></div>
                      <div class="col-md-12"></div>
                        <div align="center" class="col-md-12">
                          <input type="button" align="center" class="btn btn-success btn-block" name="guardar" style="width: 80px;" value="Guardar" onclick="Guardar();">
                        </div>

                      <div>
                        <input type="hidden" name="idGrupo" id="idGrupo" value="<?php echo $_GET['idGrupo']?>">
                      </div>

                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        </div>

        <!-- footer content
        <footer>
          <div class="pull-right">
            
          </div>
          <div class="clearfix"></div>
        </footer>
       footer content -->
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

    <script type="text/javascript" src="../tables/crudDefinir_historia.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

    <!-- initialize WYSIWYG-->

    <script type='text/javascript'>
      $('#editorOne').wysiwyg();

      
      $(".dropdown-menu > input").click(function (e) {
            e.stopPropagation();
        });
    </script>  

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  </body>
</html>
