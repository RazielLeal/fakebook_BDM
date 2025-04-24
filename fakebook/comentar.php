<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usuarios_id'], $_POST['publicacion_id'], $_POST['contenido'])) {
    $accion = "C"; // Acción correspondiente en el SP_Master
    $p_usuarios_id   = $_POST['usuarios_id'];
    $p_publicacion_id = $_POST['publicacion_id'];
    $p_contenido = trim($_POST['contenido']); // Limpiar el contenido del comentario

    // Valida que el comentario no esté vacío
    if (empty($p_contenido)) {
        echo "El comentario no puede estar vacío: " . $p_contenido;
        exit;
    }

    // Llama al SP_Master para registrar el comentario
    $sql = "CALL SP_Master(?, ?, NULL, NULL, NULL, NULL, NULL, NULL, ?, NULL, NULL, ?, NULL, NULL, NULL, NULL, NULL, NULL)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $accion, $p_usuarios_id, $p_publicacion_id, $p_contenido);

    if ($stmt->execute()) {
        header("Location: home.php?id=" . $p_publicacion_id); // Redirige de vuelta a la publicación
        exit;
    } else {
        echo "Error en la ejecución: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Parámetros inválidos.";
}
?>