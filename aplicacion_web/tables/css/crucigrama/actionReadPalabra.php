<?php 
	include "conexion.php";
	//echo ("jola");
	$Res=array();
	//print_r($_POST);
	if(isset($_POST['idActv']) && isset($_POST['accion'])){
		
		if($_POST['accion']=='mostrar'){
			//echo ("hola");
			$Res['estado']=1;

			$idCruci = $_POST['idActv'];
			$QueryCruc = "SELECT id, palabra, descripcion FROM crucigrama_preguntas WHERE crucigrama_id_actividades=".$idCruci;
			//echo $QueryCruc;
			$Resultado = mysqli_query($Con, $QueryCruc);
			$Res['palabras']=array();
		  	while ($renglon=mysqli_fetch_array($Resultado)) {
		    // code...
		    //$quiz = array();
		    $Cruci['id']=$renglon['id'];
		    $Cruci['palabra']=$renglon['palabra'];
		    $Cruci['descripcion']=$renglon['descripcion'];
		    array_push($Res['palabras'], $Cruci);
		    }
		}else{
			$Res['estado']=0;
		}
		
	}else{
		$Res['estado']=0;
	}
	echo json_encode($Res);
?>