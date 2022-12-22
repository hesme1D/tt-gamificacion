<?php  
require 'conexion.php';
$Res = array();

if (isset($_POST['idActv']) && isset($_POST['accion']) ) {

	if ($_POST['accion']=="mostrar") {
		
		$idJeop = $_POST['idActv'];
        $QueryResp = "SELECT j.id_actividades, jc.Jeopardy_id_actividades, jc.nom_cat, jp.pregunta, jp.resp_uno, jp.resp_dos, jp.resp_tres, jp.resp_cuatro, jp.puntaje, jp.id FROM jeopardy as j JOIN jeopardy_categoria as jc ON(j.id_actividades=jc.Jeopardy_id_actividades) JOIN jeopardy_preguntas as jp ON(jc.id=jp.categoria_id) WHERE jp.id='$idJeop'";
        //SELECT  FROM jeopardy_preguntas WHERE id= '$idJeop'
        //echo $QueryResp;
        $resultJeo = mysqli_query($Con, $QueryResp);

        while ($campo = mysqli_fetch_array($resultJeo)) {
        	
        	$Res['id']=$campo['id'];
        	$Res['nom_cat'] = $campo['nom_cat'];
        	$Res['pregunta']=$campo['pregunta'];
        	$Res['respuesta']=$campo['resp_uno'];
        	$Res['inc_uno']=$campo['resp_dos'];
        	$Res['inc_dos']=$campo['resp_tres'];
        	$Res['inc_tres']=$campo['resp_cuatro'];
            $Res['puntaje']=$campo['puntaje'];
        	//array_push($Res, $pregunta);
        }

	}
}

echo json_encode($Res);
?>