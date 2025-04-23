<?php
// buscarUsuarios.php

require 'config.php'; // Incluir tu conexión a la base de datos
session_start();

// Verifica que se haya enviado el término de búsqueda
if (isset($_GET['searchAmigosInput'])) {
    $busqueda = trim($_GET['searchAmigosInput']);
    
    // Puedes usar el ID del usuario que está buscando, o un valor por defecto (por ejemplo, 0)
    $usuario_actual = isset($_SESSION['usuarios_id']) ? $_SESSION['usuarios_id'] : 0;

    // Llamada al SP_Master para la acción de búsqueda (S)
    $sql = "CALL SP_Master(?, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ?, NULL, NULL, NULL)";
    $stmt = $conn->prepare($sql);
    $accion = 'S';
    // Se espera que SP_Master reciba: p_accion (s), p_usuario_actual (i) y p_busqueda (s)
    $stmt->bind_param("sis", $accion, $usuario_actual, $busqueda);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        // Recorre los resultados y muéstralos
        $resultados = array();

        while ($row = $result->fetch_assoc()) {

            $resultados[] =array(

                "usuarios_id" => $row['usuarios_id'],
                "username" => $row['username'],
                "imagen_perfil" => $row['imagen_perfil']

            );
        };

        $_SESSION['resultados_busqueda'] = $resultados;

    } else {
        // Manejo de errores
        $_SESSION['error'] = "Error en la consulta: " . $stmt->error;
    }
    $stmt->close();
} else {
    $_SESSION['error'] = "No se proporcionó término de búsqueda.";
}

// Redirigir a amigos.php
header("Location: amigos.php");
exit;
?>
