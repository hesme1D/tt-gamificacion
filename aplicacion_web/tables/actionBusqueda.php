<?php  
require 'conexion.php';

if (isset($_POST['palabra'])) {
  // code...
  $palabra = $_POST['palabra'];
  $QueryBusqueda= "SELECT id, nombre, apaterno, amaterno FROM usuarios WHERE nombre LIKE '%$palabra%' OR apaterno LIKE '%$palabra%' OR amaterno LIKE '%$palabra%'";
 
  $Resultado = mysqli_query($Con, $QueryBusqueda);
  $Res=array();

  while ($renglon=mysqli_fetch_array($Resultado)) {
    // code...
    $usuario = array();
    $usuario['id']=$renglon['id'];
    $usuario['nombre']=$renglon['nombre'];
    $usuario['apaterno']=$renglon['apaterno'];
    $usuario['amaterno']=$renglon['amaterno'];
    array_push($Res, $usuario);
  }

  echo json_encode($Res);
}
?>