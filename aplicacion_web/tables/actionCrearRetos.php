<?php  
require 'conexion.php';
$Resultado = array();

//echo "Hola 1";
//print_r($_POST);	

if (isset($_POST['alumnos']) && isset($_POST['puntaje']) && isset($_POST['premio']) && isset($_POST['entrega']) && isset($_POST['accion']) && isset($_POST['idActv'])) {
	// code...

	if ($_POST['accion']=="crear") {
		$idActv = $_POST['idActv'];
		//echo $idActv;
		$conAct = "SELECT * FROM retos_preguntas WHERE actividades_id= '$idActv'";
		$result = $Con->query($conAct);
		$row = $result->fetch_assoc();
		$alumnos = $_POST['alumnos'];
		$aux = implode(",", $alumnos);
		$puntaje = $_POST['puntaje'];
		$premio = $_POST['premio'];
		$fecha = $_POST['entrega'];


		$queryReto = "SELECT id_retos FROM crear_retos WHERE id_retos='$idActv'";
		$ResQuery= mysqli_query($Con, $queryReto);
		$renglones = mysqli_num_rows($ResQuery);

		if ($renglones==0) {
			// code...
			//echo $renglones;
			$Resultado['estado']=1;

		$QueryCrear= "INSERT INTO crear_retos(id, puntajeT, id_premios, fecha, id_users, id_retos) VALUES (NULL, '".$puntaje."','".$premio."','".$fecha."','".$aux."','".$row['actividades_id']."')";
		//echo $QueryCrear;

		if (mysqli_query($Con, $QueryCrear)) {
			// code...
			$idNew = mysqli_insert_id($Con);
			//$Resultado['estado']=1;
			$Resultado['mensaje']="Reto creado con éxito";
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