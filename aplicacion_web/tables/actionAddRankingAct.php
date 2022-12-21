<?php 
require 'conexion.php';
$Resultado = array();
if (isset($_POST['puntajeTotal']) && isset($_POST['idActv']) && isset($_POST['idUsuario']) ) {
	// code...
	if ($_POST['accion']=='guardar') {
		// code...
		$id_ranking = $_POST['idActv'];
		$puntaje = $_POST['puntajeTotal'];
		$id_usuario = $_POST['idUsuario'];

		$QueryAgregar = "INSERT INTO ranking(id, puntaje, actividad_id, id_usuario) VALUES (NULL, '".$puntaje."', '".$id_ranking."', '".$id_usuario."')";

		//echo $QueryAgregar;
		if (mysqli_query($Con,$QueryAgregar)) {
			// code...
			$idNew = mysqli_insert_id($Con);
			$Resultado['estado']=1;
			//$Resultado['mensaje']="Pregunta agregada satisfactoriamente";
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