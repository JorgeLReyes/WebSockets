<?php
require_once 'database.php';

if(isset($_GET['content'])) {
    $content = $_GET['content'];

    $sql = "INSERT INTO chat (content) VALUES ('$content')";

    if ($conn->query($sql) === TRUE) {
        echo "Registro insertado correctamente";
    } else {
        echo "Error al insertar registro: " . $conn->error;
    }
} else {
    echo "No se recibió contenido";
}

?>
