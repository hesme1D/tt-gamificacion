<?php  
require 'conexion.php';
$Resultado = array();

if (isset($_POST['id']) && isset($_POST['accion']) && isset($_POST['idGrupo'])) {
	// code...
	if ($_POST['accion']=='eliminar') {
		// code...
		$id=$_POST['id'];
		$grupo = $_POST['idGrupo'];
		$QueryEliminar = "DELETE FROM grupo_usuarios WHERE id_usuario='$id' AND  id_grupo = '$grupo'";
		//echo $QueryEliminar;
		if (mysqli_query($Con,$QueryEliminar)) {
			// code...
			$Resultado['estado']=1;
			$Resultado['mensaje']="Usuario eliminado con éxito";
		}else{
			$Resultado['estado']=0;
			$Resultado['mensaje']="Ocurrió un error desconocido";
		}
		mysqli_close($Con);
	} else {
		$Resultado['estado']=0;
		$Resultado['mensaje']="Solo se permite eliminar";
	}
} else {
	$Resultado['estado']=0;
	$Resultado['mensaje']="Falta ID o accion";
}
echo json_encode($Resultado);
?>