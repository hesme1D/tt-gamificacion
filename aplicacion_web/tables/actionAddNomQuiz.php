<?php
	include 'conexion.php';
	$Resultado = array();
	//echo "hola mundo";
	//agregar nombre de actividad e historia
	if (isset($_POST['nom_act']) && isset($_POST['contenido']) && isset($_POST['accion'])) {
	  if ($_POST['accion'] == 'guardarQuiz'){
	  	$conAct = "SELECT * FROM actividades WHERE id = (select max(id) from actividades)";//traer el último id creado
	    $result = $Con->query($conAct);
	    $row = $result->fetch_assoc();
	    $nom = $_POST['nom_act'];
	    $contenido = $_POST['contenido'];

	    $QueryAddQuiz = "INSERT INTO quiz(nom_act, historia_part, id_actividades) VALUES('".$nom."', '".$contenido."', '".$row['id']."') ";

	    if (mysqli_query($Con,$QueryAddQuiz)) {
	      $Resultado['estado']=1;
	      $Resultado['mensaje']="Historia agregada";
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