<?php  
	function isNullReg($nombre, $apaterno, $amaterno, $usuario, $password, $passconf)
	{
		// code...
		if (strlen(trim($nombre)) < 1 || strlen(trim($apaterno)) < 1 || strlen(trim($amaterno)) < 1 || strlen(trim($usuario)) < 1 || strlen(trim($password)) < 1 || strlen(trim($passconf)) < 1) {
			// code...
			return true;
		} else {
			return false;
		}
	}

	function validaPassword($pass1, $pass2)
	{
		// code...
		if (strcmp($pass1, $pass2) !== 0) {
			// code...
			return false;
		} else {
			return true;
		}
	}

	function usuarioExiste($usuario)
	{
		// code...
		global $Con;
		$stmt = $Con->prepare("SELECT id FROM usuarios WHERE user = ? LIMIT 1");
		$stmt->bind_param("s", $usuario);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		$stmt->close();

		if ($num >0) {
			// code...
			return true;
		}else{
			return false;
		}
	}

	function hashPassword($password)
	{
		// code...
		$hash = password_hash($password, PASSWORD_DEFAULT);
		return $hash;
	}

	function registraUsuario($nombre, $apaterno, $amaterno, $usuario, $password)
	{
		// code...
		global $Con;
		$stmt = $Con->prepare("INSERT INTO usuarios(nombre, apaterno, amaterno,user, password, foto) VALUES(?,?,?,?,?,'images/user.png')");
		$stmt->bind_param('sssss',$nombre,$apaterno,$amaterno,$usuario,$password);

		if ($stmt->execute()) {
			// code...
			return $Con->insert_id;
		}else{
			return 0;
		}


	}

	function resultBlock($errores)
	{
		// code...
		if (count($errores)>0) {
			# code...
			echo "<div class='alert alert-danger alert-dismissible' role='alert'><i class='icon fa fa-times-circle fa-2x fa-lg'></i>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
                    </button>";
            echo "<h7>   Error</h7><br>";
			foreach ($errores as $error) {
				# code...
				echo "<br>";
				echo "<li>".$error."</li>";
			}
			echo "</div>";
		}
	}

	function results($resultado)
	{
		// code...
		if (count($resultado)>0) {
			// code...
			echo "<div class='alert alert-success alert-dismissible' role='alert'><i class='icon fa fa-check-circle fa-2x fa-lg'></i>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
                    </button>";
            echo "<h7>   Datos correctos</h7><br>";
			foreach ($resultado as $result) {
				// code...
				echo "<br>";
				echo "<li>".$result."</li>";
			}
			echo "</div>";	
		}
	}

	function isNullLogin($usuario, $password)
	{
		// code...
		if (strlen(trim($usuario)) <1 || strlen(trim($password)) <1) {
			// code...
			return true;
		}else{
			return false;
		}
	}

	function Login($usuario, $password)
	{
		# code...
		global $Con;
		$stmt = $Con->prepare("SELECT id, password FROM usuarios WHERE user = ? LIMIT 1");
		$stmt ->bind_param("s", $usuario);
		$stmt->execute();
		$stmt->store_result();
		$rows = $stmt->num_rows;

		if ($rows >0) {
			# code...
			$stmt->bind_result($id, $pass);
			$stmt->fetch();

			$validaPassw = password_verify($password, $pass);
			if ($validaPassw) {
				# code...
				$_SESSION['id_usuario'] = $id;
				header("location: index.php");

			} else {
				# code...
				$errores = "Datos Incorrectos";
			}
		} else {
			# code...
			$errores = "Datos Incorrectos";
		}
		return $errores;
	}

	function isNullCambio($user, $password, $confpass)
	{
		// code...
		if (strlen(trim($user)) <1 || strlen(trim($password)) <1 || strlen(trim($confpass)) <1) {
			// code...
			return true;
		} else {
			return false;
		}
	}

	function getValor($campo, $campowhere, $valor)
	{
		// code...
		global $Con;
		$stmt = $Con->prepare("SELECT $campo FROM usuarios WHERE $campowhere = ? LIMIT 1");
		$stmt->bind_param('s', $valor);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;

		if ($num>0) {
			// code...
			$stmt->bind_result($_campo);
			$stmt->fetch();
			return $_campo;
		}
	}

	function cambio($password,$user_id)
	{
		// code...
		global $Con;
		$stmt = $Con->prepare("UPDATE usuarios SET password = ? WHERE id=?");
		$stmt->bind_param('si', $password,$user_id);

		if ($stmt->execute()) {
			// code...
			return true;
		} else {
			return false;
		}
	}

?>