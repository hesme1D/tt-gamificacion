<?php 
  //Si bandRegistros = 0 NO HAY REGISTRO
  //Si bandRegistros = 1 SÍ HAY REGISTRO

  //Por default se indica que no hay registros.
  $bandRegistros=0;

  //1. Conexión Database.
  $Con = mysqli_connect("localhost","root","","gamificacion");
  //Verificar la conexión.
  if (mysqli_connect_errno()) {
    # code...
    echo "Error: ".mysqli_connect_errno();
    
  }
	//$server = 'localhost';
	//$username = 'root';
	//$password = '';
	//$database = 'gamificacion';

	//try {
	//	$Con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
	//} catch (PDOException $e) {
	//	die('Falló la Conexión: ' . $e->getMessage());
	//}
?>