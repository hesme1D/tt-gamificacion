<?php
  include 'conexion.php';
  //Definir nombre de actividad y la historiaPart
  $errores = array();
  $Resultado = array();
  //echo "hola mundo"; 
if (isset($_POST['idHistoria']) && isset($_POST['idTipo']) && isset($_POST['accion'])) {
  if ($_POST['accion'] == 'guardar') {
    //obtener id de la hsitoria
    $id_historia = $_POST['idHistoria'];

    //obtener id del tipo de actividad
    $id_tipo = $_POST['idTipo'];
    
    $QueryActividad = "INSERT INTO actividades(id, id_historia, tipo_id) VALUES(NULL, '".$id_historia."', '".$id_tipo."')";

    if (mysqli_query($Con,$QueryActividad)) {
      // code...
      $idNew = mysqli_insert_id($Con);
      $Resultado['estado']=1;
      $Resultado['mensaje']="Actividad creada";
      $Resultado['id']=$idNew;
    }else{
      //Manda directamente a este error
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
