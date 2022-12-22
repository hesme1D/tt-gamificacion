<?php
	include 'conexion.php';
	if(isset($_POST['pregunta1']) && isset($_POST['respuesta']) && isset($_POST['incorrecta1']) && isset($_POST['incorrecta2']) && isset($_POST['incorrecta3']) && isset($_POST['puntaje']) && isset($_POST['categoria']) && isset($_POST['accion']) && isset($_POST['idActv'])){

		if($_POST['accion'] == 'guardarPregunta') {
			$pre = $_POST['pregunta1'];
		    $res = $_POST['respuesta'];
		    $inc_1 = $_POST['incorrecta1'];
		    $inc_2 = $_POST['incorrecta2'];  
		    $inc_3 = $_POST['incorrecta3'];
		    $cat = $_POST['categoria'];
		    $puntaje = $_POST['puntaje'];
		   	
		$conPregunta = "INSERT INTO jeopardy_preguntas(id, categoria_id, pregunta, resp_uno, resp_dos, resp_tres, resp_cuatro, puntaje) VALUES(NULL, '".$cat."', '".$pre."', '".$res."','".$inc_1."', '".$inc_2."', '".$inc_3."', '".$puntaje."')";
				
		    if(mysqli_query($Con, $conPregunta)){
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

	}else{
		$Resultado['estado']=0;
		$Resultado['mensaje']="Faltan parámetros";
	}
	
	echo json_encode($Resultado);

?>