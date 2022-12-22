<?php
	require "conexion.php";
	$Resultado=array();
	//print_r($_POST);
	//print_r($_FILES);
	if(isset($_POST['accion']) && isset($_FILES['seleccionImagen']) && isset($_POST['idActv'])){
		if($_POST['accion']=='guardar'){
			$id_memorama = $_POST['idActv'];
			$conAct = "SELECT * FROM memorama WHERE id_actividades = '$id_memorama'";
		    $result = $Con->query($conAct);
		    $row = $result->fetch_assoc();
		 	$name_array = $_FILES['seleccionImagen']['name'];
			$tmp_name_array = $_FILES['seleccionImagen']['tmp_name'];
			$directorio = "../tables/css/memorama/image"; 
			$img_file = $_FILES['seleccionImagen']['name'];
			
			$img_type = $_FILES['seleccionImagen']['type'];

			$newName = uniqid().$name_array;
			//echo $newName;	

			$destino = $directorio."/".$newName;
			

			if((strpos($img_type, "png"))){
		        if(move_uploaded_file($tmp_name_array, $destino)){

		            //guardamos en la base de datos el nombre
		            $QueryAddImagen = "INSERT INTO imagenes(id, imagen, memorama_id_actividades) values (NULL,'".$destino."', '".$row['id_actividades']."')";
		            	//echo $QueryAddImagen;
		            if (mysqli_query($Con, $QueryAddImagen)) {
				      // code...
				      $idNew = mysqli_insert_id($Con);
				      $Resultado['estado']=1;
				      $Resultado['mensaje']="Imágenes guardadas";

		  			  $actividad = $id_memorama;
		  			  $QueryRetos = "SELECT * FROM imagenes WHERE memorama_id_actividades = '$actividad'";
		  			  $ResultadoRetos = mysqli_query($Con, $QueryRetos);

		  			  $num_filas = mysqli_num_rows($ResultadoRetos);
		  			  $Resultado['num_imagen']=$num_filas;
				    }else{
				      $Resultado['estado']=0;
				      $Resultado['mensaje']="Ocurrió un error desconocido";
				    }
				    mysqli_close($Con);
		        }
		        else
		        {
		            //si ocurrio algun problema entonces
		            echo "Ocurrió un error con: ".$name_array;
		        }
    		
		    }else{
		    	$Resultado['mensaje']="Formato no soportado ".$name_array;
		    }
		}else{
			$Resultado['estado']=0;
		    $Resultado['mensaje']="Acción no válida";
		}


		
	}else{
		$Resultado['estado']=0;
		$Resultado['mensaje']="No se ha seleccionado una imagen";
	}
	//header("Location: modificar_perfil.php");
	echo json_encode($Resultado);
?>