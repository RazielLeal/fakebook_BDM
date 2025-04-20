<?php
require 'config.php';
session_start();

if (!isset($_SESSION['usuarios_id'])) {
    header("Location: index.php");
    exit();
}

$usuarios_id = $_SESSION['usuarios_id'];
$errorPasswordMsg = "";

// Cargar datos actuales del usuario
$query = "CALL SP_DatosPerfil(?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $usuarios_id);
$stmt->execute();
$result = $stmt->get_result();
$DatosUsuario = $result->fetch_assoc();

$result->free();
while ($conn->more_results() && $conn->next_result()) { ; }
$stmt->close();

$nombres_actual = $DatosUsuario['nombres'];
$apellidos_actual = $DatosUsuario['apellidos'];
$username_actual = $DatosUsuario['username'];
$email_actual = $DatosUsuario['email'];

if (isset($_POST['guardarPPchange'])) {
    $nombres = ($_POST['cambiarnombres'] != $nombres_actual) ? $_POST['cambiarnombres'] : null;
    $apellidos = ($_POST['cambiarapellidos'] != $apellidos_actual) ? $_POST['cambiarapellidos'] : null;
    $username = ($_POST['cambiarusuario'] != $username_actual) ? $_POST['cambiarusuario'] : null;
    $email = ($_POST['cambiarcorreo'] != $email_actual) ? $_POST['cambiarcorreo'] : null;

    function validar_contraseña($contraseña) {
        return (
            strlen($contraseña) >= 5 &&
            preg_match('/[A-Z]/', $contraseña) &&
            preg_match('/[^a-zA-Z0-9]/', $contraseña)
        );
    }

    if (!empty($_POST['cambiarcontraseña'])) {
        $nuevaContra = $_POST['cambiarcontraseña'];
        if (validar_contraseña($nuevaContra)) {
            $contra = password_hash($nuevaContra, PASSWORD_DEFAULT);
        } else {
            $errorPasswordMsg = "La contraseña debe tener al menos 5 caracteres, una mayúscula y un carácter especial.";
        }
    } else {
        $contra = null;
    }

    if ($errorPasswordMsg === "") {
        $imagen_perfil = ($_FILES['mediapp']['name']) ? file_get_contents($_FILES['mediapp']['tmp_name']) : null;
    
        $query = "CALL SP_ActualizarUsuario(?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issssss", $usuarios_id, $nombres, $apellidos, $username, $contra, $email, $imagen_perfil);
        $stmt->execute();
    
        header("Location: perfil.php?success=1");
        exit();
    } else {
        // Redirect back to perfil.php with the error message
        $errorPasswordMsg = htmlspecialchars($errorPasswordMsg, ENT_QUOTES, 'UTF-8');
        header("Location: perfil.php?error=" . urlencode($errorPasswordMsg));
        exit();    
    }
}
?>
