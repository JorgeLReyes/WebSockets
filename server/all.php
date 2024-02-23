<?php
require_once 'database.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM chat WHERE id > $id";
    $result = $conn->query($sql);

    $response = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $response[] = array(
                'id' => $row["id"],
                'content' => $row["content"]
            );
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    $response = array(
        'success' => false,
        'message' => 'No se recibió el parámetro "id"'
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>
