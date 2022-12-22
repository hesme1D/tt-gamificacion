<?php  
require 'conexion.php';
$Res = array();
//echo("hola");
if (isset($_POST['idActv']) && isset($_POST['accion'])) {
    // code...
    if ($_POST['accion']=="mostrar") {
        // code...
        $idQuiz = $_POST['idActv'];

        $QueryResp = "SELECT * FROM serpyesc_preguntas WHERE serpYesc_id_actividades = '$idQuiz'";
        $resultQuizz = mysqli_query($Con, $QueryResp);

        while ($campo = mysqli_fetch_array($resultQuizz)) {
            // code...
            //$pregunta = array();
            $pregunta['id']=$campo['id'];
            $pregunta['pregunta']=$campo['pregunta'];
            $pregunta['inc_uno']=$campo['inc_uno'];
            $pregunta['respuesta']=$campo['respuesta'];
            $pregunta['inc_dos']=$campo['inc_dos'];
            $pregunta['inc_tres']=$campo['inc_tres'];
            $pregunta['puntaje']=$campo['puntaje'];
            array_push($Res, $pregunta);
        }

    }
}

echo json_encode($Res);
?>