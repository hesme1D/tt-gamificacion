<?php
  require "conexion.php";
  //Definir nombre de actividad y la historiaPart
  $Resultado = array();
  //echo "hola";
  if (isset($_POST['idGrupo']) && isset($_POST['contenido']) && isset($_POST['idPaisaje']) && isset($_POST['idPersonaje']) && isset($_POST['accion'])) {
  if ($_POST['accion'] == 'guardar') { 
    $idGrupo = $_POST['idGrupo']; //guardar id de grupo
    $conGru = "SELECT * FROM grupo WHERE id = '$idGrupo'";
    $result = $Con->query($conGru);
    $row = $result->fetch_assoc();
    //guardar el texto WYSIWYG
    $contenido = $_POST['contenido'];
    $personaje = $_POST['idPersonaje'];
    $paisaje = $_POST['idPaisaje'];

    $QueryDH= "SELECT * FROM historia where grupo_id_grupo = '$idGrupo'";
    $ResultadoCon = mysqli_query($Con, $QueryDH);
    $renglon=mysqli_num_rows($ResultadoCon);
    //echo $renglon;

    if($renglon == '1'){
        $Resultado['mensaje'] = "Ya haz creado una Historia";
    }else{
      $sqlDH = "INSERT INTO historia(historia, personaje, paisaje, grupo_id_grupo)  VALUES ('".$contenido."', '".$personaje."', '".$paisaje."', '".$row['id']."')";
      //echo $sqlDH;

      if (mysqli_query($Con,$sqlDH)) {
        $Resultado['mensaje'] = "Historia creada";
        $Resultado['id']= mysqli_insert_id($Con);
        
      }else{
        $Resultado['estado']=0;
        $Resultado['mensaje']="Ocurrió un error desconocido";
      }
      mysqli_close($Con);
    }
    
  }else{
    $Resultado['estado']=0;
    $Resultado['mensaje']="Acción no válida";
  }
}else{
  //$redirect = "../tables/index.php";
  $Resultado['estado']=0;
  $Resultado['mensaje']="Faltan parámetros";
  //header('Location: '.$redirect);
}
echo json_encode($Resultado);

?>
