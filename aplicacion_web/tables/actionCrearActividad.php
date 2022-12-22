<?php  
require 'conexion.php';
$Resultado = array();

//echo "Hola 1";
//print_r($_POST);	

if (isset($_POST['puntaje']) && isset($_POST['premio']) && isset($_POST['entrega']) && isset($_POST['accion']) && isset($_POST['idGrupo']) && isset($_POST['nivel']) && isset($_POST['idActv'])) {
	// code...

	if ($_POST['accion']=="crear") {
		// code...
		//echo Grupo
		$idActv = $_POST['idActv'];
		$conAct = "SELECT * FROM actividades WHERE id= '$idActv'";
		$result = $Con->query($conAct);
		$row = $result->fetch_assoc();

		$idGrupo = $_POST['idGrupo'];
		$conGrupo = "SELECT * FROM grupo_usuarios WHERE id_grupo='$idGrupo'";
		$resG = $Con->query($conGrupo);
		$roww = $resG->fetch_assoc();

		$nivel = $_POST['nivel'];
		$puntaje = $_POST['puntaje'];
		$premio = $_POST['premio'];
		$fecha = $_POST['entrega'];


		$queryAct = "SELECT id_grupo_usuarios, idActividad FROM crear_act WHERE id_grupo_usuarios='$idGrupo' AND idActividad='$idActv'";
		$ResQuery= mysqli_query($Con, $queryAct);
		$renglones = mysqli_num_rows($ResQuery);

		if ($renglones==0) {
			// code...
			$Resultado['estado']=1;
		$QueryCrear= "INSERT INTO crear_act(id, puntajeT, id_premios, fecha, id_grupo_usuarios, idActividad, id_nivel) VALUES (NULL, '".$puntaje."','".$premio."','".$fecha."','".$roww['id_grupo']."','".$row['id']."', '".$nivel."')";
		//echo $QueryCrear;

		if (mysqli_query($Con, $QueryCrear)) {
			// code...
			$idNew = mysqli_insert_id($Con);
			//$Resultado['estado']=1;
			$Resultado['mensaje']="Actividad creada con éxito";
			$Resultado['id']=$idNew;
		}}else{
			$Resultado['estado']=0;
			$Resultado['mensaje']="Ocurrió un error desconocido";
		}
		mysqli_close($Con);
	}else{
		$Resultado['estado']=0;
		$Resultado['mensaje']="Acción no válida";
	}
}else{
	$Resultado['estado']=0;
	$Resultado['mensaje']="Faltan parámetros";
}
echo json_encode($Resultado);
?>