<?php  
require 'conexion.php';
$Resultado = array();
if (isset($_POST['id']) && isset($_POST['accion'])) {
	// code...
	if ($_POST['accion']=="eliminar") {
		// code...
		$id=$_POST['id'];
		$QueryEliminar = "DELETE FROM imagenes WHERE id=".$id;
		if (mysqli_query($Con,$QueryEliminar)) {
			// code...
			$Resultado['estado']=1;
			$Resultado['mensaje']="Imagen eliminada";
		} else {
			$Resultado['estado']=0;
			$Resultado['mensaje']="Ocurrió un error desconocido";
		}
		mysqli_close($Con);
	} else {
		$Resultado['estado']=0;
		$Resultado['mensaje']="Sólo se permite eliminar";
	}
} else {
	$Resultado['estado']=0;
	$Resultado['mensaje']="Falta ID o acción";
}
echo json_encode($Resultado);
?>