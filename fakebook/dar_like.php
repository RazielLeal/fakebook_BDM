<?php
require 'config.php';

// Habilitar errores de PHP para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['usuarios_id']) && isset($_POST['publicacion_id'])) {
    $usuarios_id = $_POST['usuarios_id'];
    $publicacion_id = $_POST['publicacion_id'];

    // Llamamos al stored procedure para dar el like
    $sql = "CALL SP_DarLike(?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $usuarios_id, $publicacion_id);

    if ($stmt->execute()) {
        // Verificamos si el like ya existía
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);  // Ya le dio like a esta publicación
        }
    } else {
        // Si ocurre un error al ejecutar el stored procedure
        echo json_encode(['success' => false, 'error' => 'Error en la ejecución del procedimiento']);
    }
} else {
    // Si no se reciben los parámetros esperados
    echo json_encode(['success' => false, 'error' => 'Faltan parámetros']);
}

// header('Content-Type: application/json');  // Asegura que la respuesta sea JSON

$stmt->close();
?>
