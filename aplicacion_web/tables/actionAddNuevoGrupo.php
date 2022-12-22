<?php
	session_start();
	$Resultado = array();
	include 'conexion.php';
	$idUsuario = $_SESSION['id_usuario'];
	if(isset($_POST['nom_grupo']) && isset($_POST['descripcion']) && isset($_POST['accion'])){
		if ($_POST['accion'] == 'guardarGrupo'){
			$nom = $_POST['nom_grupo'];
			$desc = $_POST['descripcion'];
			$QueryAddGrupo ="INSERT INTO grupo(id, id_user, nomGrupo, descripcion) VALUES (NULL,'".$idUsuario."','".$nom."','".$desc."')";
			
			if (mysqli_query($Con,$QueryAddGrupo)) {
				$Resultado['mensaje'] = "Grupo agregado";
				$Resultado['id']= mysqli_insert_id($Con);
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