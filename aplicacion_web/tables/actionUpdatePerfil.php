<?php
session_start();
	require "conexion.php";
	//$Resultado=array();
	//echo "hola";
	if(isset($_POST['actualizar']) && isset($_FILES['foto'])){

		$id = $_SESSION['id_usuario'];
		$tmp_name = $_FILES['foto']['tmp_name']; 
		$directorio = "../tables/avatars"; 
		$img_file = $_FILES['foto']['name'];
		$img_type = $_FILES['foto']['type'];
		$img_nombre = uniqid().$img_file;
		//echo $img_nombre;

		if (((strpos($img_type, "gif") || strpos($img_type, "jpeg") ||
	 		strpos($img_type, "jpg")) || strpos($img_type, "png"))){
			//guardar la imagen en el destino
			$destino = $directorio."/".$img_nombre;
			//echo $destino;
	
			
			if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
				mysqli_query($Con, "UPDATE usuarios SET foto = '$destino' WHERE id='$id';");	
			 	//return true; 	
			}
			//return false; 
		}
	}
	header("Location: index.php");
?>