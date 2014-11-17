<?php 

	$db_host = "127.0.0.1";
	$db_username = "d3m0";
	$db_password = 'd3_m05$eR.';
	$db_name = "agenda";
	$connection = null;
	$data = array();

	try{
		$connection = new mysqli($db_host,$db_username,$db_password,$db_name);

		// check connection
		if($connection->connect_error){
			$data["error_status"] = true;
			$data["error_description"] = "Ocurrio un problema al intentar registrar. Por favor intentarlo mas tarde o contacte al administrador.";	
			trigger_error('Database connection failed: '+$connection->connect_error, E_USER_ERROR);
		}

		if(!empty($_POST)){
			$nombre = $_POST['nombre'];
			$email = $_POST['email'];
			$direccion = $_POST['direccion'];
			$sql_command = "INSERT INTO persona(nombre,email,direccion) VALUES ('$nombre', '$email', '$direccion')";

			if ($connection->query($sql_command)===false){
				$data["error_status"] = true;
				$data["error_description"] = "Problemas al intentar consultar en la base de datos.";
				trigger_error('Wrong SQL: '.$sql_command.' Error: '.$connection->error,E_USER_ERROR);
			}else{
				//$last_inserted_id = $connection->insert_id;
				$affected_rows = $connection->affected_rows;
				if($affected_rows==1){
					$data["error_status"] = false;
					$data["error_description"] = "";
					$data["message"] = "La persona ha sido registrada. Muchas gracias por registrase.";
				}else{
					$data["error_status"] = false;
					$data["error_description"] = "";
					$data["message"] = "Ocurrio un problema al intentar registrar. Por favor intentarlo mas tarde o contacte al administrador.";
				}
			}

		}

		$connection = null;

	}catch(Exception $exception){
		echo $exception;
	}
	
echo json_encode($data);

?>

