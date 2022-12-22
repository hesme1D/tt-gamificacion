<?php
  include 'conexion.php';
  //echo "hola mundo";
  $Resultado = array();
  if (isset($_POST['palabra']) && isset($_POST['descripcion']) && isset($_POST['idActv']) && isset($_POST['accion'])) {
  # code...
  if ($_POST['accion']=='actualizar') {
    # code...
    $idCrucigrama = $_POST['idActv'];
    $conAct = "SELECT * FROM crucigrama WHERE id_actividades = '$idCrucigrama'";
    $result = $Con->query($conAct);
    $row = $result->fetch_assoc();
    $palabraC = $_POST['palabra'];
    $descripcion = $_POST['descripcion'];
   
    $QueryUpdateP ="UPDATE crucigrama_preguntas SET palabra = '".$palabraC."', descripcion = '".$descripcion."' WHERE id=".$idCrucigrama;
    //echo $QueryUpdateP;
      if (mysqli_query($Con,$QueryUpdateP)) {
        $idNew = mysqli_insert_id($Con);
        $Resultado['estado']=1;
        $Resultado['mensaje']="Palabra actualizada con éxito";
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