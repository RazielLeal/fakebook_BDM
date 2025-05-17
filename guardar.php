<?php
require 'config.php';
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuarios_id'])) {
    echo json_encode(['success' => false, 'message' => 'No has iniciado sesión']);
    exit;
}

// Verificar si la solicitud es POST y si se enviaron los datos necesarios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['publicacion_id'])) {
    $usuarios_id = $_SESSION['usuarios_id'];
    $publicacion_id = $_POST['publicacion_id'];
    
    // Preparar y ejecutar el stored procedure para guardar la publicación
    $sql = "CALL SP_Master(?, ?, NULL, NULL, NULL, NULL, NULL, NULL, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
    $stmt = $conn->prepare($sql);
    $accion = 'K'; // 'K' para Guardar según el procedimiento
    $stmt->bind_param("sii", $accion, $usuarios_id, $publicacion_id);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $mensaje = $row['mensaje'] ?? 'Operación completada';
        
        echo json_encode(['success' => true, 'message' => $mensaje]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al guardar la publicación: ' . $stmt->error]);
    }
    
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos o método incorrecto']);
}

$conn->close();
?>