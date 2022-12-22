<?php  
require 'conexion.php';
$Resultado = array();

if (isset($_POST['id']) && isset($_POST['accion']) && isset($_POST['id_Activ'])) {
	// code...
	if ($_POST['accion']=='eliminar') {
		// code...
		$id=$_POST['id'];
		$QueryEliminar = "DELETE FROM serpyesc_preguntas WHERE id=".$id;
		if (mysqli_query($Con,$QueryEliminar)) {
			// code...
			$Resultado['estado']=1;
			$Resultado['mensaje']="Pregunta eliminada con éxito";
			$actividad = $_POST['id_Activ'];
  			$QueryRetos = "SELECT * FROM serpyesc_preguntas WHERE serpYesc_id_actividades = '$actividad'";
  			$ResultadoRetos = mysqli_query($Con, $QueryRetos);

  			$num_filas = mysqli_num_rows($ResultadoRetos);
  			$Resultado['num_retos']=$num_filas;
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