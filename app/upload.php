<?php
session_start();
require 'class/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tracking-number']) && isset($_POST['empaque-image-data']) && isset($_POST['small-parts-image-data'])) {
        $trackingNumber = $_POST['tracking-number'];
        $empaqueImageData = $_POST['empaque-image-data'];
        $smallPartsImageData = $_POST['small-parts-image-data'];
        $user_id = $_SESSION['user_id']; // Replace with the actual user value

        // Create a folder based on the current year and month
        $currentYear = date('Y');
        $currentMonth = date('m');
        $folderPath = "evidencia/$currentYear/$currentMonth/";

        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        // Paths to save the images
        $empaqueImagePath = $folderPath . $trackingNumber . '-em.png';
        $smallPartsImagePath = $folderPath . $trackingNumber . '-sm.png';

        $empaqueImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $empaqueImageData));
        $smallPartsImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $smallPartsImageData));

        // Save the images
        if (file_put_contents($empaqueImagePath, $empaqueImage) && file_put_contents($smallPartsImagePath, $smallPartsImage)) {
            // Insert data into MySQL database using PDO
            try {

                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Construct the SQL query with placeholders
                $sql = "INSERT INTO carros (tracking, creacion, empaque, parts, fk_user) 
                        VALUES (:tracking, NOW(), :empaque, :parts, :user_id)";

                $stmt = $conn->prepare($sql);

                // Bind values to placeholders
                $stmt->bindParam(':tracking', $trackingNumber, PDO::PARAM_STR);
                $stmt->bindParam(':empaque', $empaqueImagePath, PDO::PARAM_STR);
                $stmt->bindParam(':parts', $smallPartsImagePath, PDO::PARAM_STR);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

                // Execute the query
                if ($stmt->execute()) {
                    // Return a success response
                    http_response_code(200);
                    echo "Record added successfully.";
                } else {
                    // Return a server error response
                    http_response_code(500);
                    echo "Error adding record to the database: " . $stmt->error;
                }

                // $stmt->close();
                $conn = null; // Close the database connection
            } catch (PDOException $e) {
                // Return a server error response
                http_response_code(500);
                echo "Error adding record to the database: " . $e->getMessage();
            }
        } else {
            // Return an error response if there is a problem saving images
            http_response_code(500);
            echo "Error saving images.";
        }
    } else {
        // Return a bad request response if data is missing
        http_response_code(400);
        echo "Missing data.";
    }
}
?>
