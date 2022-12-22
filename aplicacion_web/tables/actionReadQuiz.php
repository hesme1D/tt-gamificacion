<?php 
	include "conexion.php";

	if(isset($_POST['idActv']) && isset($_POST['accion'])){
		if($_POST['accion']=='mostrar'){
			$idQuiz = $_POST['idActv'];
			//echo $idQuiz;
			$QueryQuiz = "SELECT * FROM quiz_preguntas WHERE id= '$idQuiz' ";
			//echo $QueryQuiz;
			$Resultado = mysqli_query($Con, $QueryQuiz);
		  	$Res=array();

		  	while ($renglon=mysqli_fetch_array($Resultado)) {
		    // code...
		    //$quiz = array();
		    $Res['id']=$renglon['id'];
		    $Res['pregunta'] = $renglon['pregunta'];
		    $Res['inc_uno'] = $renglon['inc_uno'];
		    $Res['respuesta'] = $renglon['respuesta'];
		    $Res['inc_dos'] = $renglon['inc_dos'];
		    $Res['inc_tres'] = $renglon['inc_tres'];
		    $Res['puntaje'] = $renglon['puntaje'];
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