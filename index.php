<html>
<head>
  <title>Registro</title>
</head>
<body>

	<h2>Registro</h2>

	<form method="post" action="index.php">
		<label for="nombre">Nombe</label>
		<input type="text" name="nombre" id="nombre" />
		<br />
		<label for="email">Email</label>
		<input type="text" name="email" id="email" />
		<br />
		<label for="direccion">Direcci&oacute;n</label>
		<textarea rows="5" cols="20" id="direccion" name="direccion"></textarea>
		<br />
		<input type="submit" name="submit" value="Registrar" />
	</form>

<?php 
	$db_host = "127.0.0.1";
	$db_username = "d3m0";
	$db_password = 'd3_m05$eR.';
	$db_name = "agenda";
	$connection = null;
	
	try{
		$connection = new mysqli($db_host,$db_username,$db_password,$db_name);

		// check connection
		if($connection->connect_error){
			trigger_error('Database connection failed: '+$connection->connect_error, E_USER_ERROR);
		}

		if(!empty($_POST)){
			$nombre = $_POST['nombre'];
			$email = $_POST['email'];
			$direccion = $_POST['direccion'];
			$sql_command = "INSERT INTO persona (nombre,email,direccion) VALUES ('$nombre', '$email', '$direccion')";

			if ($connection->query($sql_command)===false){
				trigger_error('Wrong SQL: '.$sql_command.' Error: '.$connection->error,E_USER_ERROR);
			}else{
				$last_inserted_id = $connection->insert_id;
				$affected_rows = $connection->affected_rows;
				if($affected_rows==1){
					echo "<h4>La persona ha sido registrada. Muchas gracias por registrase.</h4>";
				}else{
					echo "<h4>Ocurrio un problema al intentar registrar. Por favor intentarlo mas tarde o contacte al administrador.</h4>";
				}
			}

		}

		$sql_select = "SELECT * FROM persona";
		$resultset=$connection->query($sql_select);

		if($resultset===false){
			trigger_error('Wrong SQL: '.$sql_select.' Error: '.$connection->error, E_USER_ERROR);		
		}else{

			if($resultset->num_rows >= 1){
				echo "<table>";
				echo "<tr>";
				echo "<td>Nombre</td>";
				echo "<td>Email</td>";
				echo "<td>Direccion</td>";
				echo "<td>Fecha</td>";
				echo "</tr>";
				while($row = $resultset->fetch_assoc()){
					echo "<tr>";
						echo "<td>".$row['nombre']."</td>";
						echo "<td>".$row['email']."</td>";
						echo "<td>".$row['direccion']."</td>";
						echo "<td>".$row['fecha']."</td>";
					echo "<tr>";
				}
				echo "</table>";
			}else{
				echo "<h4>No se han registrado personas en el sistema.</h4>";
			}

		}

		$connection = null;

	}catch(Exception $exception){
		echo $exception;
	}
	
	
?>

</body>
</html>