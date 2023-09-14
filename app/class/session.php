<?php
	require 'class/data.php';
	// Realizar la conexión a la base de datos
	$fecha_actual = date('M-d-Y H:i'); // Formato: Año-Mes-Día Hora:Minuto:Segundo
	// Obtener el ID del usuario de la sesión
	$userID = $_SESSION['user_id'];
	// Ejecutar la consulta SQL
	$query_user = "SELECT users.*, roles.*
	FROM users
	INNER JOIN roles ON users.fk_rol = roles.id_rol
	WHERE users.id_user = '$userID'";
	$result_user = mysqli_query($conexion, $query_user);
	
	// Verificar si se encontraron result_userados
	if (mysqli_num_rows($result_user) > 0) {
		// Obtener los datos del usuario
		$row = mysqli_fetch_assoc($result_user);
		// Acceder a los campos de la tabla
        $user_id = intval($row['id_user']);

		$username = $row['username'];
		$email = $row['email'];
		$name = $row['nombre'];
        $fullname = $row['nombre'] . " " . $row['apellidos'];
		$descripcion = $row['descripcion'];

	} else {
		echo "No se encontraron resultados para el ID de usuario: " . $userID;
	}
	
?>