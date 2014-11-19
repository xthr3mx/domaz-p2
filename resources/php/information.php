<?php 

	$db_host = "127.0.0.1";
	$db_username = "d3m0";
	$db_password = 'd3_m05$eR.';
	$db_name = "";
	$connection = null;
	$table_name = "";
	$data = array();

	if(!empty($_GET)){
		$name = $_GET['name'];
		$id = $_GET['id'];

		switch($name){
			case "persona":
				$db_name = "agenda";
				$table_name = $name;
				break;
			case "comentarios":
				$db_name = "demo";
				$table_name = $name;
				break;
		}

		try{
			$connection = new mysqli($db_host,$db_username,$db_password,$db_name);

			// check connection
			if($connection->connect_error){
				//$data["error_status"] = true;
				//$data["error_description"] = "Error en la base de datos";	
				trigger_error('Database connection failed: '+$connection->connect_error, E_USER_ERROR);
			}

			$sql_select = "SELECT * FROM $table_name";
			$resultset=$connection->query($sql_select);

			if($resultset===false){
				trigger_error('Wrong SQL: '.$sql_select.' Error: '.$connection->error, E_USER_ERROR);		
			}else{

				if($resultset->num_rows >= 1){
					while($row = $resultset->fetch_assoc()){
						$temp = array();

						switch($name){
							case "persona":
								$temp["id"]=$row['id'];
								$temp["nombre"]=$row['nombre'];
								$temp["email"]=$row['email'];
								$temp["direccion"]=$row['direccion'];
								$temp["fecha_ingreso"]=$row['fecha_ingreso'];
								break;
							case "comentarios":
								$temp["id"]=$row['id'];
								$temp["nombre"]=$row['nombre'];
								$temp["email"]=$row['email'];
								$temp["comentario"]=$row['comentario'];
								$temp["fecha"]=$row['fecha'];
								break;
						}

						array_push($data, $temp);
					}
				}

			}


		}catch(Exception $exception){
			echo $exception;
		}

		$connection = null;

		echo json_encode($data);

	}

?>