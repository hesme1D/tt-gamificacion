<?php 
	include "conexion.php";
	//echo ("jola");
	if(isset($_POST['idActv']) && isset($_POST['accion'])){
		
		if($_POST['accion']=='mostrar'){
			//echo ("hola");
			$idCruci = $_POST['idActv'];
			$QueryJeop = "SELECT * FROM crucigrama_preguntas WHERE id= '$idCruci' ";
			//echo $QueryJeop;
			$Resultado = mysqli_query($Con, $QueryJeop);
		  	$Res=array();

		  	while ($renglon=mysqli_fetch_array($Resultado)) {
		    // code...
		    //$quiz = array();
		    $Res['id']=$renglon['id'];
		    $Res['palabra']=$renglon['palabra'];
		    $Res['descripcion']=$renglon['descripcion'];
		    //array_push($Res, $usuario);
		    }
		}else{
			$Res['estado']=0;
		}
		
	}else{
		$Res['estado']=0;
	}
	echo json_encode($Res);

?>