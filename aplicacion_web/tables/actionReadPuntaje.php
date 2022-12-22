<?php  
require 'conexion.php';
$Res = array();
//print_r($_POST);
if(isset($_POST['idActv']) && isset($_POST['accion'])){
	if($_POST['accion']=='mostrar'){
		$idActv = $_POST['idActv'];
		//echo $idQuiz;
		$QueryRan = "SELECT * FROM ranking_actividad WHERE actividad_id= '$idActv' ORDER BY puntaje DESC";
		//echo $QueryQuiz;
		$Resultado = mysqli_query($Con, $QueryRan);
	  	
	  	$Res['puntajes']=array();

	  	while ($renglon=mysqli_fetch_array($Resultado)) {
	    // code...
		    $usuario = array();
		    //$Res['id']=$renglon['id'];
		    $usuario['puntaje'] = $renglon['puntaje'];
		    $usuario['nombre'] = $renglon['nombre'];
		    array_push($Res['puntajes'], $usuario);
		    //$Res['estado']=1;
	    }
	}else{
		$Res['estado']=0;
	}
	
}else{
	$Res['estado']=0;
}
echo json_encode($Res);
?>