<?php
// Validar la contraseña
if (isset($_POST['cambiarcontraseña'])) {
    $contraseña = $_POST['cambiarcontraseña'];

    // Función para validar la contraseña
    function validar_contraseña($contraseña) {
        if (strlen($contraseña) >= 5 && 
            preg_match('/[A-Z]/', $contraseña) && 
            preg_match('/[^a-zA-Z0-9]/', $contraseña)) {
            return "true";
        } else {
            return "false";
        }
    }

    // Devolver el resultado de la validación
    echo validar_contraseña($contraseña);
}
?>
