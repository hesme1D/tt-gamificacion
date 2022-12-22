<?php 
require 'conexion.php';
$Resultado = array();

if (isset($_POST['pregunta']) && isset($_POST['inc1']) && isset($_POST['respuesta']) && isset($_POST['inc2']) && isset($_POST['inc3']) && isset($_POST['puntaje']) && isset($_POST['accion']) && isset($_POST['idActv'])) {
	// code...
	if ($_POST['accion']=='actualizar') {
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

		$QueryActualizar = "UPDATE quiz_preguntas SET pregunta='".$pregunta."',inc_uno='".$inc_uno."',respuesta='".$respuesta."',inc_dos='".$inc_dos."',inc_tres='".$inc_tres."',puntaje='".$puntaje."' WHERE id=".$id_Quiz;

		//echo $QueryActualizar;

		if (mysqli_query($Con,$QueryActualizar)) {
			// code...
			$Resultado['estado']=1;
			$Resultado['mensaje']="Pregunta actualizada con éxito";
		}
		else{
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