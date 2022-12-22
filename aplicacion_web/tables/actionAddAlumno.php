<?php
  require 'conexion.php';
  //require 'funcs.php';  
  //resolver dudas del buscador para el lunes.
  if ($_POST['addAlumno']) {
    //$nombre = $_POST['nomalumno'];

    $QueryAdd ="INSERT INTO grupo_usuarios(idgrupo_usuarios, id_grupo, id_usuario, nombre, apaterno, amaterno) SELECT id, nombre, apaterno, amaterno FROM usuarios";

    $ResultadoAdd=mysqli_query($Con,$QueryAdd);
    $Res=array();

    while ($renglon=mysqli_fetch_array($ResultadoAdd)) {
    // code...
    $usuario = array();
    $usuario['nombre']=$renglon['nombre'];
    $usuario['apaterno']=$renglon['apaterno'];
    $usuario['amaterno']=$renglon['amaterno'];
    array_push($Res, $usuario);
  }
}
echo json_encode($ResultadoAdd);
?>