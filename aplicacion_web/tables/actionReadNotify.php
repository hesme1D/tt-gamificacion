<?php 
    include "conexion.php";
	//echo ("jola");
	$Res=array();
	if(isset($_POST['accion']) && isset($_POST['idUsuario'])){
		
		if($_POST['accion']=='mostrar'){
			//echo ("hola");
			$idUsuario = $_POST['idUsuario'];
			$queryCon = "SELECT * FROM notificacion WHERE id_usuario = '$idUsuario' AND id_usuario = (SELECT max(id_usuario) from notificacion)";
			$resQuery = mysqli_query($Con, $queryCon);
		  	
		  	//if($idUsuario){}
		  	while ($campo = mysqli_fetch_array($resQuery)) {
		        // code...
		        //$pregunta = array();
		        $pregunta['id']=$campo['id'];
		        $pregunta['nom_noti']=$campo['nom_noti'];
		        $pregunta['mensaje']=$campo['mensaje'];
		        array_push($Res, $pregunta);
		    }
		}else{
			$Res['estado']=0;
		}
		
	}else{
		$Res['estado']=0;
	}
	echo json_encode($Res);

?>