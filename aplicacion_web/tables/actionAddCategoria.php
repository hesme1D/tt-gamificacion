<?php
	require "conexion.php";
	//echo "hola";
	//Definir categorias jeopardy
	$Resultado = array();
	//echo "hola mundo";
	if(isset($_POST['categoria']) && isset($_POST['idActv']) && isset($_POST['accion'])){
		//echo "hola";	
		if($_POST['accion'] == 'guardarCat'){
			$id_jeopardy = $_POST['idActv'];
			$conAct = "SELECT * FROM jeopardy WHERE id_actividades = '$id_jeopardy'";
		    $result = $Con->query($conAct);
		    $row = $result->fetch_assoc();
		    $categoria = $_POST['categoria']; 	   
		    $QueryAddCat = "INSERT INTO jeopardy_categoria(id, nom_cat, Jeopardy_id_actividades) VALUES(NULL, '".$categoria."', '".$row['id_actividades']."')";
		   	//echo $QueryAddCat;
		    if (mysqli_query($Con, $QueryAddCat)) {
		      // code...
		      $idNew = mysqli_insert_id($Con);
		      $Resultado['estado']=1;
		      $Resultado['mensaje']="Categoría agregada";
		      $Resultado['id']=$idNew;

		      //$actividad = $id_activ;
	  		  $sqlCategoria ="SELECT * FROM jeopardy_categoria where Jeopardy_id_actividades = '$id_jeopardy'";
			  $categoria=mysqli_query($Con, $sqlCategoria);
			  $filas = mysqli_num_rows($categoria);
	  		  $Resultado['num_categoria']=$filas;
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