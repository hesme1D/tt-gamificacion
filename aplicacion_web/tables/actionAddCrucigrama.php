<?php
  include 'conexion.php';
  //Definir nombre de actividad y la historiaPart
  $errores = array();
  $Resultado = array();
if (isset($_POST['nom_act']) && isset($_POST['contenido']) && isset($_POST['accion'])) {
  if ($_POST['accion'] == 'guardarCruci') {
    $conAct = "SELECT * FROM actividades WHERE id = (select max(id) from actividades)";//traer el último id creado
    $result = $Con->query($conAct);
    $row = $result->fetch_assoc();
    $nom = $_POST['nom_act'];
    $contenido = $_POST['contenido'];

    $QueryAddCrucigrama = "INSERT INTO crucigrama(nom_act, historia_part, id_actividades) VALUES('".$nom."', '".$contenido."', '".$row['id']."')";
    //echo $QueryAddCrucigrama;

    if (mysqli_query($Con,$QueryAddCrucigrama)) {
      // code...
      $Resultado['estado']=1;
      $Resultado['mensaje']="Historia guardada";
      
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
