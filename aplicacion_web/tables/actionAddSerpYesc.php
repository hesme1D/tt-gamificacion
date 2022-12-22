<?php
  include 'conexion.php';
  //Definir nombre de actividad y la historiaPart
  $Resultado = array();
if (isset($_POST['nom_act']) && isset($_POST['contenido']) && isset($_POST['accion'])) {
  if ($_POST['accion'] == 'guardarSerpientes') {
    $conAct = "SELECT * FROM actividades WHERE id = (select max(id) from actividades)";//traer el último id creado
    $result = $Con->query($conAct);
    $row = $result->fetch_assoc();
    $nom = $_POST['nom_act'];
    $contenido = $_POST['contenido'];

    $QueryAddSYP = "INSERT INTO serpyesc(nom_act, historia_part, id_actividades) VALUES('".$nom."', '".$contenido."', '".$row['id']."') ";
      //echo $QueryAddSYP;
    if (mysqli_query($Con,$QueryAddSYP)) {
      // code...
      $Resultado['estado']=1;
      $Resultado['mensaje']="Historia agregada satisfactoriamente";
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
