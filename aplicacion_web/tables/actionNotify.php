<?php  
require 'conexion.php';
$Resultado = array();
if (isset($_POST['id_usuario']) && isset($_POST['idGrupo']) && isset($_POST['accion'])) {
  if($_POST['accion']=='agregar'){
    $id = $_POST['id_usuario'];
    $idGrupo = $_POST['idGrupo'];
  
 
    $QueryAdd ="INSERT INTO notificacion (id, nom_noti, mensaje, id_usuario, id_grupo) VALUES (NULL, 'Grupos:', 'Se te ha agregado a un nuevo grupo.', '".$id."', '".$idGrupo."')";
    $ResultadoAdd=mysqli_query($Con,$QueryAdd);

    if(mysqli_query($Con, $ResultadoAdd)){
      $idNew = mysqli_insert_id($Con);
      $Resultado['estado']=1;
      $Resultado['mensaje']="Agregado con éxito";
      $Resultado['id']=$idNew;
    }else{  
      $Resultado['estado']=0;
      $Resultado['mensaje']="Ocurrió un error desconocido";
    }
      mysqli_close($Con);    
  }else{
    $Resultado['estado']=0;
      $Resultado['mensaje']="Acción no válida";
  }

}else{
   $Resultado['estado']=0;
    $Resultado['mensaje']="Faltan parámetros";
}
echo json_encode($Resultado);
?>