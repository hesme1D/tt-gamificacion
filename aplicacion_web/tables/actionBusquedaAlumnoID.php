<?php  
require 'conexion.php';

//$Res=array();
$usuario = array();
//print_r($_POST)
if (isset($_POST['addAlumno']) && isset($_POST['idGrupo']) && isset($_POST['accion'])) {
  // code...
  if($_POST['accion']=='agregar'){
    $id = $_POST['addAlumno'];
    $QueryBusqueda= "SELECT id, nombre, apaterno, amaterno FROM usuarios WHERE id=".$id;
 
    $Resultado = mysqli_query($Con, $QueryBusqueda);
    while ($renglon=mysqli_fetch_array($Resultado)) {
      // code...
      $usuario['id']=$renglon['id'];
      $usuario['nombre']=$renglon['nombre'];
      $usuario['apaterno']=$renglon['apaterno'];
      $usuario['amaterno']=$renglon['amaterno'];
      //array_push($Res, $usuario);
    }
    //echo json_encode($usuario);

    $idGrupo = $_POST['idGrupo'];
    $conGrupo = "SELECT * FROM grupo WHERE id = '$idGrupo'";
    $result = $Con->query($conGrupo);
    $row = $result->fetch_assoc();

    $queryCon = "SELECT id_grupo, id_usuario, idgrupo_usuarios FROM grupo_usuarios WHERE id_grupo='$idGrupo' and id_usuario='$id'";
    //echo $queryCon;
    $ResultCon = mysqli_query($Con, $queryCon);

    $renglones = mysqli_num_rows($ResultCon);
  
    if ($renglones==0) {
      // code...
      $usuario['estado']=1;
      $QueryAdd ="INSERT INTO grupo_usuarios(idgrupo_usuarios, id_grupo, id_usuario, nombre, apaterno, amaterno) VALUES(NULL,'".$row['id']."','".$usuario['id']."','".$usuario['nombre']."','".$usuario['apaterno']."','".$usuario['amaterno']."')";
      //echo $QueryAdd;
      $ResultadoAdd=mysqli_query($Con,$QueryAdd);
    } else {
      $usuario['estado']=0;
  }
  echo json_encode($usuario);
  }
}
?>