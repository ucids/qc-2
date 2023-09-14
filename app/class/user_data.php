<?php
	require 'data.php';
	// Realizar la conexión a la base de datos
	// Obtener el ID del usuario de la sesión
	$userID = $_SESSION['user_id'];
	// Ejecutar la consulta SQL
	$query_data = "SELECT fk_user, COUNT(*) as carros_count
    FROM carros
    WHERE fk_user = '$userID'
    GROUP BY fk_user";
	$result_data = $conexion->query($query_data);
	
	// Verificar si se encontraron result_dataados
	if (mysqli_num_rows($result_data) > 0) {
		// Obtener los datos del usuario
		$row = mysqli_fetch_assoc($result_data);
        $total_user = $row['carros_count'];

		// Acceder a los campos de la tabla

	} else {
		$total_user = 0;
	
	}
	
?>