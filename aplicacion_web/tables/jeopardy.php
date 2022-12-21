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
  $jeopardy = $_GET['idActividad'];
  $QueryJ = "SELECT * FROM jeopardy WHERE id_actividades = '$jeopardy'";
  $ResultadoJ = mysqli_query($Con, $QueryJ);
  $num_rows = mysqli_num_rows($ResultadoJ);

  $QueryJeopardy=" SELECT * FROM jeopardy_view WHERE id_actividades = '$jeopardy'";
  //Ejecutamos y guardamos el resultado
  //echo $QueryJeopardy;
  $ResultadoJeopardy=mysqli_query($Con,$QueryJeopardy);

  //Obtener registro x registro
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

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">

    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- jeopardy Style
    <link rel="stylesheet" href="../tables/css/jeopardy/estilosJeopardy.css"> -->
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
        <div class="right_col">
          <input type="hidden" name="tipo" id="idTipo" value="<?php echo $tipo;?>">
          <input type="hidden" name="idGrupo" id="idGrupo" value="<?php echo $_GET['idGrupo'];?>">
          <input type="hidden" name="idHistoria" id="idHistoria" value="<?php echo $_GET['idHistoria'];?>">
          <input type="hidden" name="idActv" id="idActv" value="<?php echo $_GET['idActividad'];?>">

          <h3 align="right"><button type="button" name="tipsJeop" class="btn-round btn-primary" data-toggle="modal" data-target="#tipsJeop" align="right"><i class="fa fa-info-circle"></i></button></h3>

          <h1>Jeopardy</h1>
          
          <div class="tile_count" align="center"> 
            <form class="col-md-12 col-sm-12" action="actionAddJeopardy.php" method="POST" id="cleax">
              <?php        
                if ($num_rows == '1') {
                  $sqlCategoria ="SELECT * FROM jeopardy_categoria where Jeopardy_id_actividades = '$jeopardy'";
                    $categoria=mysqli_query($Con, $sqlCategoria);
                    $filas = mysqli_num_rows($categoria);
                    if($filas<6)
                    {
                  
                      echo '<button type="button" name="addCat" id="btn1" class="btn btn-primary" data-toggle="modal" data-target="#Add" align="center">Agregar Nueva Categoría</button>';
                  
                    }else{
                      echo '<button type="button" name="addCat" id="btn1" class="btn btn-primary" data-toggle="modal" data-target="#Add" align="center" disabled>Agregar Nueva Categoría</button>';
                    }
              ?>
                
              <!-- inicio modal addCategoria -->
              <div id="Add" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel" style="color: #4E5692;">Agregar nueva categoria</h3>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <table>
                      <!--Recuadro para la pregunta-->
                      <div class="col-md-12">
                        <div class="box box-solid" style="  background: #5583A8; border-color: #5583A8;">
                          <div class="box-header with-border">
                             <h5 class="modal-title" id="myModalLabel" style="color: #fff;">Categoria</h5>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body">
                            <!--Aquí van los inputs-->
                            <input type="text" class="form-control" placeholder="Nombre categoría" id="categoria" name="categoria">
                          </div>
                          <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                      </div>
                    </table>
                  </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      <input type="button" align="center" class="btn btn-primary btn-block" id="guardarCat" name="guardarCat" style="width: 80px;" value="Guardar" onclick="guardarCategoria();">
                    </div>
                  </div>
                </div>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-12 col-xs-12 form-group pull-right top_search"></div>
                <h3 align="right"><button type="button" name="preguntasJuego" class="btn btn-primary" data-toggle="modal" data-target="#pregunta" align="right">Agregar</button></h3>
              </div>
              <br>

              <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                  <tr>
                  <th>Pregunta</th>
                  <th>Categoria</th> 
                  <th>Respuesta 1</th>
                  <th>Respuesta 2</th>
                  <th>Respuesta 3</th>
                  <th>Respuesta 4</th>
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
                    // falta una restricción para que agregue las preguntas conforme a la actividad creada no a la categotis 
                    while ($renglonJeopardy=mysqli_fetch_array($ResultadoJeopardy)) {
                      // code...
                      echo "<tr id='row_".$renglonJeopardy['id']."'>";
                      echo "<td>".$renglonJeopardy['pregunta']."</td>";
                      echo "<td>".$renglonJeopardy['nom_cat']."</td>";
                      echo "<td>".$renglonJeopardy['resp_uno']."</td>";
                      echo "<td>".$renglonJeopardy['resp_dos']."</td>";
                      echo "<td>".$renglonJeopardy['resp_tres']."</td>";
                      echo "<td>".$renglonJeopardy['resp_cuatro']."</td>";
                      echo "<td>".$renglonJeopardy['puntaje']."</td>";
                      echo '<td ><button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal-success"  onclick="IdentificaActualizar('.$renglonJeopardy['id'].')"><i class="fa fa-edit fa-sm" ></i></button></td>';
                      echo '<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target=".modal-danger" onclick="IdentificaEliminar('.$renglonJeopardy['id'].')"><i class="fa fa-trash"></i></button></td>';
                      echo "</tr>";
                    }
                  }
                  ?>
                </tbody>
              </table>
              <?php 
                }
              ?>
            </form>

            <!-- modal para agregar preguntas -->
            <form class="form-horizontal" action="actionAddPreguntasJ.php" method="POST" id="preguntasId">
              <div id="pregunta" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel" style="color: #4E5692;">Agregar nueva pregunta</h3>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                  </div>
                     <div class="modal-body">
                    <table>
                      <!--Recuadro para la pregunta-->
                      <div class="col-md-12">
                        <div class="box box-solid" style="background: #5583A8; border-color: #5583A8;">
                          <div class="box-header with-border">
                            <h5 class="box-title" style="color: #fff;">Pregunta</h5>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body">
                            <!--Aquí van los inputs-->
                            <input type="text" class="form-control" placeholder="Pregunta" name="pregunta1" id="pregunta1">
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
                        <div class="box box-solid" style=" height: 150px; background: #5583A8; border-color: #5583A8;">
                          <div class="box-header with-border">
                            <h5 class="box-title" style="color: #fff;">Posibles respuestas</h5>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body">
                            <!--Aquí van los inputs-->
                            <input type="text" class="form-control" placeholder="Respuesta" name="respuesta" id="respuesta">
                            <br>
                            <input type="text" class="form-control" placeholder="Incorrecta 1" name="incorrecta1" id="incorrecta1">
                            <br>
                            <input type="text" class="form-control" placeholder="Incorrecta 2" name="incorrecta2" id="incorrecta2">
                            <br>
                            <input type="text" class="form-control" placeholder="Incorrecta 3" name="incorrecta3" id="incorrecta3">
                          </div>
                          <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                      </div>
                      <!--Recuadro para el puntaje-->
                      <div class="col-md-3">
                        <div class="box box-solid" style=" height: 150px; background: #5583A8; border-color: #5583A8;">
                          <br>
                          <div class="box-header with-border">
                            <h5 class="box-title" style="color: #fff;">Puntaje</h5>
                          </div>
                          <!-- /.box-header -->
                            <div class="box-body">
                              <!--Aquí van los inputs-->
                              <input type="text" class="form-control" placeholder="Puntaje" name="puntaje" id="puntaje">
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

                      <!-- recuadro para elegir categoría-->
                      <div class="col-md-9">
                        <div class="box box-solid" style="background: #5583A8; border-color: #5583A8;">
                          <div class="box-header with-border">
                           <h5 class="box-title" style="color: #fff;">Seleccionar categoria</h5>
                          </div>
                          <!-- /.box-header -->
                            <div class="box-body">
                              <!--Aquí van los inputs-->
                              <select class="form-control" id="categoria1">
                                <?php  
                                
                                while($RenglonCategoria=mysqli_fetch_array($categoria)) {
                                    echo "<option value='".$RenglonCategoria['id']."'>".$RenglonCategoria['nom_cat']."</option>";
                                  }
                                ?>
                              </select>
                            </div>
                            <!-- /.box-body -->
                        </div>
                          <!-- /.box -->
                      </div>
                    </table>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                       <input type="button" align="center" class="btn btn-primary " name="guardarPregunta" value="Guardar" onclick="addJeopardy();">
                    </div>
                  </div>
                </div>
              </div>

              <!-- modal para editar -->
              <div class="modal modal-success" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h3 class="modal-title" id="myModalLabel" style="color: #4E5692;">Editar pregunta</h3>
                      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div class="modal-body">
                    <table>
                    <!--Recuadro para la pregunta-->
                    <div class="col-md-12">
                      <div class="box box-solid" style="background: #5583A8; border-color: #5583A8;">
                        <div class="box-header with-border">
                         <h5 class="box-title" style="color: #fff;">Pregunta</h5>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                          <!--Aquí van los inputs-->
                          <input type="text" class="form-control" placeholder="Pregunta" name="pregunta1" id="updatePregunta">
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
                      <div class="box box-solid" style=" height: 150px; background: #5583A8; border-color: #5583A8;">
                        <div class="box-header with-border">
                          <h5 class="box-title" style="color: #fff;">Posibles respuestas</h5>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                          <!--Aquí van los inputs-->
                          <input type="text" class="form-control" placeholder="Respuesta" name="respuesta" id="updateRes">
                          <br>
                          <input type="text" class="form-control" placeholder="Incorrecta 1" name="incorrecta1" id="updateInc1">
                          <br>
                          <input type="text" class="form-control" placeholder="Incorrecta 2" name="incorrecta2" id="updateInc2">
                          <br>
                          <input type="text" class="form-control" placeholder="Incorrecta 3" name="incorrecta3" id="updateInc3">
                        </div>
                        <!-- /.box-body -->
                      </div>
                      <!-- /.box -->
                    </div>
                    <!--Recuadro para el puntaje-->
                    <div class="col-md-3">
                      <div class="box box-solid" style="height: 150px; background: #5583A8; border-color: #5583A8;">
                        <br>
                        <div class="box-header with-border">
                         <h5 class="box-title" style="color: #fff;">Puntaje</h5>
                        </div>
                        <!-- /.box-header -->
                          <div class="box-body">
                            <!--Aquí van los inputs-->
                            <input type="text" class="form-control" placeholder="Puntaje" name="puntaje" id="updatePuntaje">
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

                    <!-- recuadro para elegir categoría-->
                    <div class="col-md-9">
                      <div class="box box-solid" style="background: #5583A8; border-color: #5583A8;">
                        <div class="box-header with-border">
                          <h5 class="box-title" style="color: #fff;">Seleccionar categoría</h5>
                        </div>
                        <!-- /.box-header -->
                        <form method="POST">
                          <div class="box-body">
                            <!--Aquí van los inputs-->
                            <select class="form-control" id="categoria2">
                              <?php  
                              $idActJeo = $_GET['idActividad'];
                              $sqlCategoria ="SELECT * FROM jeopardy_categoria where Jeopardy_id_actividades = '$idActJeo'";
                              $categoria=mysqli_query($Con, $sqlCategoria);
                              while($RenglonCategoria=mysqli_fetch_array($categoria)) {
                                  echo "<option value='".$RenglonCategoria['id']."'>".$RenglonCategoria['nom_cat']."</option>";
                                }
                              ?>
                            </select>
                          </div>
                        </form>
                          <!-- /.box-body -->
                      </div>
                        <!-- /.box -->
                    </div>
                  </table>
                </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      <button type="button" class="btn btn-primary" name="actualizar"  onclick="updatePalabraJ();">Guardar</button>
                    </div>
                  </div>
                </div>
              </div>

              <!--Modal para eliminar-->
              <div class="modal modal-danger fade" id="modal-danger">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h3 class="modal-title" id="myModalLabel" style="color: #5583A8;">ADVERTENCIA</h3>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                     <h6 style="color: #5583A8">La confirmación eliminará la siguiente pregunta:</h6>
                    <br>
                    <h6 class="box-title" id="idPregunta" style="color: #4E5692;"></h6>
                    <br>
                    <h6 style="color: #5583A8"><b>¿Desea eliminarla?&hellip;</b></h6>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                      <button type="button" class="btn btn-outline" name="eliminar" onclick="deletePreguntaJ();">Eliminar</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            </form>

            <!--Modal tips-->
            <div id="tipsJeop" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
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
                          <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="First slide">¿En qué consiste el juego?</h5>
                          <hr style="background-color: #75163F; width: 50%;">
                          <br>
                          <h6 style="color: #75163F; font-family:sans-serif;">Jeopardy es un juego que se muestra a manera de tablero, el cuál en la parte superior tiene los nombres de las categorías y en su columna correspondiente botones con puntajes que corresponden a una pregunta referente a esa categoría. Una vez que la pregunta se respondió el botón se bloquea y se puede responder otra pregunta.</h6>
                        </div>
                        <div class="carousel-item" >
                          <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="Second slide">¿Cómo genero el tablero de juego?</h5>
                          <hr style="background-color: #75163F; width: 50%;">
                          <h6 style="color: #75163F; font-family:sans-serif;">Para generar el tablero de juego es necesario crear categorías para eso basta con dar clic en el botón "Agrear nueva categoría", que mostrará una ventana que permite agregar los nombres de las categorías del juego. <br>Se debe tener en cuenta que se puede agregar un máximo de seis categorías.</h6>
                        </div>
                        <div class="carousel-item">
                          <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="Thirdh slide">¿Cómo genero el tablero de juego?</h5>
                          <hr style="background-color: #75163F; width: 50%;">
                          <h6 style="color: #75163F; font-family:sans-serif;">Al darle clic al botón "Agregar" se muestra una ventana para agregar las preguntas de opción múltiple respetando los campos para la pregunta, las posibles respuestas, la categoría a la que pertenece y un puntaje para cada pregunta. En caso de algún error estos datos pueden ser editados o eliminados<br>Al darle clic en "Guardar cambios y mostrar" podrás visualizar la vista previa del juego.</h6>
                        </div>
                        <div class="carousel-item">
                          <h5 class="d-block w-100" style="color: #75163F; font-family: fantasy;" alt="Fourth slide">¿Cómo genero el tablero de juego?</h5>
                          <hr style="background-color: #75163F; width: 50%;">
                          <h6 style="color: #75163F; font-family:sans-serif;">El tablero máximo engloba seis categorías por lo que se recomuenda agregar seis preguntas por categoría, lo que daría como resultado <b>36 preguntas</b> (si el juego no es tan extenso basta con agregar una pregunta por categoría).</h6>
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

            <br>
              <div class="col-md-12 col-sm-12">
                <br>
              </div>
              <br>
              <div class="col-md-12"></div>
              <div class="col-md-12 col-sm-12">
                <br>
              </div>
              <div class="col-md-12 col-sm-12">
                <br>
              </div>
              <br>
              <div>
                <a class="btn btn-danger" style="width: 30%;" href="nom_clase.php?idGrupo=<?php echo $_GET['idGrupo'];?>">Guardar cambios y volver al inicio</a>
                
                <a class="btn btn-secondary" style="width: 30%;" href="mostrar_jeopardy.php?idGrupo=<?php echo $_GET['idGrupo'];?>&idHistoria=<?php echo $_GET['idHistoria']?>&idActividad=<?php echo $_GET['idActividad'];?>">Guardar cambios y mostrar</a> 
                <input type="hidden" name="idTipo" id="idTipo" value="<?php echo $_GET['idTipo']?>">
            </div>  
          </div>

        </div>
        <!-- ------------------ -->
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
    <script src="../build/js/custom.js"></script>

	   <script src="../tables/crudJeopardy.js"></script>
     <script>
       $('#categoria1').on('change', function() {
         var algo = this.value;
         //alert(algo);
       });
       $('#categoria2').on('change', function() {
         var algo = this.value;
         //alert(algo);
       });
     </script>

     <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </body>
</html>
