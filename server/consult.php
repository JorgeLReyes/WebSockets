<?php
require_once 'database.php';

$sql = "SELECT id FROM chat ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

$response = array(); 

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response['success'] = true;
    $response['message'] = "El ID del último registro insertado es: " . $row["id"];
    $response['id'] = $row["id"];
} else {
    $response['success'] = false;
    $response['message'] = "No se encontraron registros";
}

header('Content-Type: application/json');
echo json_encode($response);

?>
