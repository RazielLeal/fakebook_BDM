<?php
require 'config.php';
session_start();

if (!isset($_SESSION['usuarios_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['btnpublicar'])) {
    $usuarios_id = $_SESSION['usuarios_id']; 
    $contenido = trim($_POST['contenido']); 

    if (empty($contenido)) {
        echo "<script>alert('El contenido de la publicación no puede estar vacío.'); window.history.back();</script>";
        exit();
    }

    // 1️⃣ Primero, crear la publicación con SP_Master ('B')
    $stmt = $conn->prepare("CALL SP_Master(?, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ?, NULL, NULL, NULL)");
    $accion = 'B';
    $stmt->bind_param("sis", $accion, $usuarios_id, $contenido);

    if ($stmt->execute()) {
        // Procesar el resultado del SP_Master (B) para obtener el ID de la publicación
        $result = $stmt->get_result();
        if ($result) {
            $row = $result->fetch_assoc();
            $publicacion_id = $row['pub_id'];
            $result->free(); // Liberar el resultado
        }
        $stmt->close(); // Cerrar el statement para 'B'

        // 2️⃣ Luego, insertar imágenes y videos con SP_Master ('M')
        if (!empty($_FILES['media']['tmp_name'][0])) {
            
            $media_data = file_get_contents($_FILES['media']['tmp_name']);
            $tipo_media = strpos($_FILES['media']['type'], 'image') !== false ? 'imagen' : 'video';

            // Preparar y ejecutar SP_Master ('M')
            $stmt = $conn->prepare("CALL SP_Master(?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ?, NULL, NULL, NULL, ?,?, NULL)");
            $accion_media = 'M';
            $stmt->bind_param("sibs", $accion_media, $publicacion_id, $media_data, $tipo_media);
            $stmt->send_long_data(2, $media_data); // Enviar el contenido del archivo
            $stmt->execute();
            $stmt->close();
            
        }

        echo "<script>alert('Publicación creada exitosamente.');</script>";
        header("Location: home.php");
        exit();
    } else {
        echo "<script>alert('Error al publicar. Inténtalo de nuevo.');</script>";
    }

    $stmt->close();
}
?>