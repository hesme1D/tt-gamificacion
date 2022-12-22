<?php
	include 'conexion.php';
	$Resultado = array();
	if(isset($_POST['pregunta']) && isset($_POST['respuesta']) && isset($_POST['inc1']) && isset($_POST['inc2']) && isset($_POST['inc3']) && isset($_POST['puntaje']) && isset($_POST['idActv']) && isset($_POST['accion'])){
		if ($_POST['accion'] == 'guardarRetos'){
			$pregunta = $_POST['pregunta'];
			$inc_uno = $_POST['inc1'];
			$respuesta = $_POST['respuesta'];
			$inc_dos = $_POST['inc2'];
			$inc_tres = $_POST['inc3'];
			$puntaje = $_POST['puntaje'];
			$idActiv = $_POST['idActv'];			
			
		$QueryRetos = "INSERT INTO retos_preguntas(id, pregunta, respuesta, inc_uno,  inc_dos, inc_tres, puntaje, actividades_id) VALUES (NULL, '".$pregunta."', '".$respuesta."', '".$inc_uno."',  '".$inc_dos."', '".$inc_tres."', '".$puntaje."', '".$idActiv."')";
		//echo $QueryRetos;
			
		if (mysqli_query($Con,$QueryRetos)) {
			// code...
			$idNew = mysqli_insert_id($Con);
			$Resultado['estado']=1;
			$Resultado['mensaje']="Pregunta agregada satisfactoriamente";
			$Resultado['id']=$idNew;
			
  			$QueryRetos = "SELECT * FROM retos_preguntas WHERE actividades_id = '$idActiv'";
  			$ResultadoRetos = mysqli_query($Con, $QueryRetos);

  			$num_filas = mysqli_num_rows($ResultadoRetos);
  			$Resultado['num_retos']=$num_filas;
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