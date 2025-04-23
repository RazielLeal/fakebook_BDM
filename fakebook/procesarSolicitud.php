<?php
// procesarSolicitud.php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['id_amigos'], $_POST['solicitante'], $_POST['opcion'])) {
    
    $accion = "J";
    $p_id_amigos   = $_POST['id_amigos'];
    $p_solicitante = $_POST['solicitante'];
    $p_opcion      = $_POST['opcion']; // 'ACEPTAR' o 'RECHAZAR'
    $p_usuarios_id = $_SESSION['usuarios_id']; // El receptor
    
   
    // Llama a SP_Master pasando todos los parámetros necesarios.
    // Ajusta el número y orden de parámetros según la definición de tu SP_Master.
    $sql = "CALL SP_Master(?, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Aquí se utiliza, por ejemplo, "siiis..." donde definimos:
    // Param1: accion (string)
    // Param2: p_usuarios_id (int)
    // Param16: p_solicitante (int)
    // Param17: p_opcion (string)
    // Param18: p_id_amigos (int)
    // Los demás como NULL
    $stmt->bind_param("siisi", $accion, $p_usuarios_id, $p_solicitante, $p_opcion, $p_id_amigos);
    
    if ($stmt->execute()) {
        header("Location: amigos.php");
        exit;
    } else {
        echo "Error en la ejecución: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Parámetros no válidos.";
}
?>