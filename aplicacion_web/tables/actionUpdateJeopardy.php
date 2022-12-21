	<?php
	include 'conexion.php';
	if(isset($_POST['pregunta']) && isset($_POST['respuesta']) && isset($_POST['inc_uno']) && isset($_POST['inc_dos']) && isset($_POST['inc_tres']) && isset($_POST['puntaje']) && isset($_POST['categoria']) && isset($_POST['idActv']) && isset($_POST['accion']) ){

		if($_POST['accion'] == 'actualizar') {
			$pregunta = $_POST['pregunta']; 
		    $respuesta = $_POST['respuesta'];
		    $inc_1 = $_POST['inc_uno'];
		    $inc_2 = $_POST['inc_dos'];  
		    $inc_3 = $_POST['inc_tres'];
		    $cat = $_POST['categoria'];
		    $puntaje = $_POST['puntaje'];
		    $idJeopardy = $_POST['idActv'];

		   $conPregunta = "UPDATE jeopardy_preguntas SET categoria_id='".$cat."',pregunta='".$pregunta."',resp_uno='".$respuesta."',resp_dos='".$inc_1."',resp_tres='".$inc_2."',resp_cuatro='".$inc_3."',puntaje='".$puntaje."' WHERE id=".$idJeopardy;
		    if(mysqli_query($Con, $conPregunta)){
				$Resultado['estado']=1;
				$Resultado['mensaje']="Pregunta actualizada";
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