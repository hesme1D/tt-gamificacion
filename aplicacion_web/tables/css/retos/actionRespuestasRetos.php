<?php  
require 'conexion.php';
$Res = array();

//echo("Hola no entra al if ");

if (isset($_POST['idActv']) && isset($_POST['accion'])) {
	// code...
	//echo("holaaaa primer if");
	if ($_POST['accion']=="mostrar"){
		$idRetos = $_POST['idActv'];

        $QueryResp = "SELECT * FROM retos_preguntas WHERE actividades_id=".$idRetos;
        $resultQuizz = mysqli_query($Con, $QueryResp);

        while ($campo = mysqli_fetch_array($resultQuizz)) {
        	// code...
        	$pregunta = array();
        	$pregunta['id']=$campo['id'];
        	$pregunta['pregunta']=$campo['pregunta'];
        	$pregunta['inc_uno']=$campo['inc_uno'];
        	$pregunta['respuesta']=$campo['respuesta'];
        	$pregunta['inc_dos']=$campo['inc_dos'];
        	$pregunta['inc_tres']=$campo['inc_tres'];
        	$pregunta['puntaje']=$campo['puntaje'];

        	array_push($Res, $pregunta);

        	//echo("Hola"+$Res);
        }

	}
}

echo json_encode($Res);
?>