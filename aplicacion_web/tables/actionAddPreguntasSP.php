<?php
	include 'conexion.php';
	$Resultado = array();
	if(isset($_POST['pregunta']) && isset($_POST['respuesta']) && isset($_POST['inc_uno']) && isset($_POST['inc_dos']) && isset($_POST['inc_tres']) && isset($_POST['puntaje']) && isset($_POST['accion']) && isset($_POST['idActv']) ){

		if($_POST['accion'] == 'agregar') {

			$id_SP = $_POST['idActv'];
			$conAct = "SELECT * FROM serpyesc WHERE id_actividades = '$id_SP'";
		    $result = $Con->query($conAct);
		    $row = $result->fetch_assoc();

			$pre = $_POST['pregunta'];
		    $res = $_POST['respuesta'];
		    $inc_uno = $_POST['inc_uno'];
		    $inc_dos = $_POST['inc_dos'];  
		    $inc_tres = $_POST['inc_tres'];
		    $puntaje = $_POST['puntaje'];
		   	
		$conPregunta = "INSERT INTO serpyesc_preguntas(id, pregunta, respuesta, inc_uno, inc_dos, inc_tres, puntaje, serpYesc_id_actividades) VALUES(NULL, '".$pre."', '".$res."','".$inc_uno."', '".$inc_dos."', '".$inc_tres."', '".$puntaje."', '".$row['id_actividades']."')";
		//echo $conPregunta;
		    if(mysqli_query($Con, $conPregunta)){
		    	$idNew = mysqli_insert_id($Con);
				$Resultado['estado']=1;
				$Resultado['mensaje']="Pregunta agregada";
				$Resultado['id']=$idNew;

				//$actividad = $id_activ;
	  			$QueryPreguntas = "SELECT * FROM serpyesc_preguntas WHERE serpYesc_id_actividades = '$id_SP'";
				//echo $QueryPreguntas;
				$ResultadoPregunta = mysqli_query($Con, $QueryPreguntas);

	  			$num_filas = mysqli_num_rows($ResultadoPregunta);
	  			$Resultado['num_preguntas']=$num_filas;
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