<?php 
	include "conexion.php";
	//echo ("jola");
	if(isset($_POST['idGrupo']) && isset($_POST['accion'])){
		
		if($_POST['accion']=='mostrar'){
			//echo ("hola");
			$idGrupo = $_POST['idGrupo'];
			$QueryJeop = "SELECT * FROM problematica where grupo_id_grupo = '$idGrupo'";
			//echo $QueryJeop;
			$Resultado = mysqli_query($Con, $QueryJeop);
		  	$Res=array();

		  	while ($renglon=mysqli_fetch_array($Resultado)) {
			    // code...
			    //$quiz = array();
			    $Res['id']=$renglon['id'];
			    $Res['imagen_paisaje'] = $renglon['imagen_paisaje'];
			    $Res['imagen_personaje'] = $renglon['imagen_personaje'];
			    $Res['historia'] = $renglon['historia'];
		    }
		}else{
			$Res['estado']=0;
		}
		
	}else{
		$Res['estado']=0;
	}
	echo json_encode($Res);
?>