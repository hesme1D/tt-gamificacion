<?php  
require 'conexion.php';
$Res = array();
//echo "hola";
if (isset($_POST['idActv']) && isset($_POST['accion']) ) {

	if ($_POST['accion']=="mostrar") {
		
		$idMemorama = $_POST['idActv'];
        $QueryResp = "SELECT * FROM imagenes WHERE memorama_id_actividades='$idMemorama'";
        $resultMemorama = mysqli_query($Con, $QueryResp);
        
        $num_row = mysqli_num_rows($resultMemorama);
        $Res['num_imagenes']=$num_row;

        $Res['imagenes']=array();
        while ($campo = mysqli_fetch_array($resultMemorama)) {
        	
        	$imagen['id']=$campo['id'];
        	$imagen['imagen'] =$campo['imagen'];
        	array_push($Res['imagenes'], $imagen);
        }


	}
}
echo json_encode($Res);
?>