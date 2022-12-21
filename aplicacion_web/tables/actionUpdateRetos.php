<?php 
require 'conexion.php';
$Resultado = array();

if(isset($_POST['pregunta']) && isset($_POST['respuesta']) && isset($_POST['inc1']) && isset($_POST['inc2']) && isset($_POST['inc3']) && isset($_POST['puntaje']) && isset($_POST['idActv']) && isset($_POST['accion'])){
		if ($_POST['accion'] == 'actualizarRetos'){
			$pregunta = $_POST['pregunta'];
			$respuesta = $_POST['respuesta'];
			$inc_uno = $_POST['inc1'];
			$inc_dos = $_POST['inc2'];
			$inc_tres = $_POST['inc3'];
			$puntaje = $_POST['puntaje'];
			$idRetos = $_POST['idActv'];
			
		$QueryRetos = "UPDATE retos_preguntas SET pregunta = '".$pregunta."', respuesta = '".$respuesta."', inc_uno = '".$inc_uno."', inc_dos='".$inc_dos."', inc_tres='".$inc_tres."', puntaje='".$puntaje."' WHERE id=".$idRetos;
		//echo $QueryRetos;
			
		if (mysqli_query($Con,$QueryRetos)) {
			// code...
			$idNew = mysqli_insert_id($Con);
			$Resultado['estado']=1;
			$Resultado['mensaje']="Pregunta actualizada con éxito";
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