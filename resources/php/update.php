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
			$data["error_description"] = "Error en la base de datos";	
			trigger_error('Database connection failed: '+$connection->connect_error, E_USER_ERROR);
		}

		if(!empty($_POST)){
			$id = $_POST['id'];
			$name = $_POST['name'];
			$email = $_POST['email'];
			$direction = $_POST['direction'];
			$sql_command = "UPDATE persona SET nombre = '$name', email = '$email', direccion = '$direction' WHERE id = $id ";

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
					$data["message"] = "Los datos se han actualizado de forma exitosa. Muchas gracias.";
				}else{
					$data["error_status"] = false;
					$data["error_description"] = "";
					$data["message"] = "Ocurrio un problema al intentar actualizar los datos. Por favor intentarlo mas tarde o contacte al administrador.";
				}
			}

		}

		$connection = null;

	}catch(Exception $exception){
		echo $exception;
	}
	
echo json_encode($data);

?>