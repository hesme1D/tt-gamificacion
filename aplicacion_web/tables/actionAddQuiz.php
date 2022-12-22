<?php 
require 'conexion.php';
$Resultado = array();
if (isset($_POST['pregunta']) && isset($_POST['inc1']) && isset($_POST['respuesta']) && isset($_POST['inc2']) && isset($_POST['inc3']) && isset($_POST['puntaje']) && isset($_POST['accion']) && isset($_POST['idActv'])) {
	// code...
	if ($_POST['accion']=='agregar') {
		// code...
		$id_Quiz = $_POST['idActv'];
		$conAct = "SELECT * FROM quiz WHERE id_actividades = '$id_Quiz'";
	    $result = $Con->query($conAct);
	    $row = $result->fetch_assoc();
		$pregunta = $_POST['pregunta'];
		$inc_uno = $_POST['inc1'];
		$respuesta = $_POST['respuesta'];
		$inc_dos = $_POST['inc2'];
		$inc_tres = $_POST['inc3'];
		$puntaje = $_POST['puntaje'];

		$QueryAgregar = "INSERT INTO quiz_preguntas(id, pregunta, inc_uno, respuesta, inc_dos, inc_tres, puntaje, quiz_id_actividades) VALUES (NULL,'".$pregunta."','".$inc_uno."','".$respuesta."','".$inc_dos."','".$inc_tres."','".$puntaje."', '".$row['id_actividades']."')";

		//echo $QueryAgregar;
		if (mysqli_query($Con,$QueryAgregar)) {
			// code...
			$idNew = mysqli_insert_id($Con);
			$Resultado['estado']=1;
			$Resultado['mensaje']="Pregunta agregada";
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
} else{
	$Resultado['estado']=0;
	$Resultado['mensaje']="Faltan parámetros";
}
echo json_encode($Resultado);
?>