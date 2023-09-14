<?php
require('class/connection.php');  // I'm assuming you have a connection file
header('Content-Type: application/json'); // Important for returning JSON

$output = array("tracking" => "", "empaque" => "", "parts" => "");
if (isset($_POST['tracking'])) {
    $tracking = $_POST['tracking'];
    $query = "SELECT tracking, empaque, parts FROM carros WHERE tracking = ?";  // Assuming columns are named this way
    
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $tracking);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $output["tracking"] = $row['tracking'];
        $output["empaque"] = $row['empaque'];
        $output["parts"] = $row['parts'];
    }
    $stmt->close();
}

echo json_encode($output);
?>

