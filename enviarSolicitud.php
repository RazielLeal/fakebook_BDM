<?php
// enviarSolicitud.php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['amigo_id'])) {
    // ID del usuario al que se le envía la solicitud, pasado por el formulario
    $p_amigo_id = $_POST['amigo_id'];
    // ID del usuario que inició sesión
    $p_usuarios_id = isset($_SESSION['usuarios_id']) ? $_SESSION['usuarios_id'] : 0;
    $accion = 'N';

    // Prepara la llamada a SP_Master.
    // Ajusta la lista de parámetros según la definición de tu procedimiento.
    // Aquí se asume que solo se requieren estos tres parámetros para la acción AGREGAR.
    $sql = "CALL SP_Master(?, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ?, NULL, NULL)";
    $stmt = $conn->prepare($sql);
    // Se utiliza bind_param para: 
    // 1: acción (s), 2: p_usuarios_id (i) y 3: p_amigo_id (s o i según su tipo)
    // Aquí asumo "sis" para (string, integer, string), pero si ambos IDs son enteros, puedes usar "iis".
    $stmt->bind_param("sii", $accion, $p_usuarios_id, $p_amigo_id);

    if ($stmt->execute()) {
        // Opcionalmente procesas los resultados o rediriges
        header("Location: amigos.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "No se ha enviado un ID de amigo válido.";
}
?>