<?php

require 'config.php';

if (isset($_POST['btnreg'])) {
    // Función para validar la contraseña
    function validar_contraseña($contraseña) {
        return (
            strlen($contraseña) >= 5 &&
            preg_match('/[A-Z]/', $contraseña) &&
            preg_match('/[^a-zA-Z0-9]/', $contraseña)
        );
    }

    // Obtener y sanitizar entradas del formulario
    $nombre = trim($_POST["inputREGnombres"]);
    $apellidos = trim($_POST["inputREGapellidos"]);
    $email = trim($_POST["inputcorreo"]);
    $username = trim($_POST["inputREGnomusu"]);
    $nuevaContra = trim($_POST["inputREGncontra"]);
    $fechaNacimiento = $_POST["inputREGfecha"];
    $genero = $_POST["opciones"];

    // Verificar si los campos están vacíos
    if (empty($nombre) || empty($apellidos) || empty($email) || empty($username) || empty($nuevaContra) || empty($fechaNacimiento) || empty($genero)) {
        echo "<script>alert('Todos los campos son obligatorios. Por favor, completa todos los campos.'); window.history.back();</script>";
        exit();
    }

    // Validar que la fecha de nacimiento sea mayor a 18 años
    $fechaActual = new DateTime(); // Fecha actual
    $fechaUsuario = new DateTime($fechaNacimiento); // Fecha de nacimiento ingresada
    $diferencia = $fechaActual->diff($fechaUsuario);

    if ($diferencia->y < 18) {
        echo "<script>alert('Debes ser mayor de 18 años para registrarte.'); window.history.back();</script>";
        exit();
    }

    // Validar la contraseña
    if (validar_contraseña($nuevaContra)) {
        $contra = password_hash($nuevaContra, PASSWORD_BCRYPT); // Encriptar la contraseña

        $stmt = $conn->prepare("CALL SP_Master(?, NULL, ?, ?, ?, ?, ?, NULL, NULL, ?, ?, NULL, NULL, NULL, NULL)");
        $accion = 'R';
        $stmt->bind_param("ssssssss", $accion, $nombre, $apellidos, $username, $contra, $email, $fechaNacimiento, $genero);

        if ($stmt->execute()) {
            header("Location: index.php?registro=exitoso");
            exit();
        } else {
            echo "<script>alert('Error al registrar el usuario.');</script>";
        }

        $stmt->close();
    } else {
        $mensajeError = "La contraseña debe tener al menos 5 caracteres, una mayúscula y un carácter especial.";
        echo "<script>alert('$mensajeError'); window.history.back();</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="red social landing page" content="width=device-width, initial-scale=1.0">
    <title>Fakebook</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="ContLP" id="ContLPreg">

        <section class="headertitulo" id="header">
            <div class="titulo" id="titulo">
                <a href="index.php">Fakebook</a>
            </div>
    
        </section>
    
         <section class="formREGcont">
            <form action="" method="post" class="formISyREG" id="formIS">    

                <div class="continput">
                    <div class="descinput">Nombres:</div>
                    <input type="text" class="inputgen" id="inputREGnombres" name="inputREGnombres" placeholder="Ingrese sus nombres">

                </div>
                <div class="continput">
                    <div class="descinput">Apellidos:</div>
                    <input type="text" class="inputgen" id="inputREGapellidos" name="inputREGapellidos" placeholder="Ingrese sus apellidos">
                </div>
                <div class="continput">
                    <div class="descinput">
                        Ingrese su correo:
                    </div>
                    <input type="email" class="inputgen" id="inputcorreo" name="inputcorreo" placeholder="Correo">
                </div>
                <div class="continput">
                    <div class="descinput">Nombre de usuario:</div>
                    <input type="text" class="inputgen" id="inputREGnomusu" name="inputREGnomusu" placeholder="Ingrese sus nombre de usuario">
                </div>

                <div class="continput">
                    <div class="descinput">
                        Ingrese su contraseña:
                    </div>
                    <input type="password" class="inputgen" id="inputREGncontra" name="inputREGncontra" placeholder="Contraseña">
                    <div id="mostrarcontracont" class="custom-checkbox">
                        <img src="checkboxoff.png" alt="CheckMostrarContraseña" id="CheckMostrarContra" class="checked">
                        <img src="checkbox.png" alt="CheckMostrarContraseña" id="CheckOcultarContra" class="unchecked"> 
                        <div id="cambiartexto">
                            Mostrar contraseña
                        </div>
                         
                    </div>
                </div>
                <div class="continput">
                    <div class="descinput">Fecha de nacimiento:</div>
                    <input type="date" class="inputgen" id="inputREGfecha" name="inputREGfecha" placeholder="Ingrese sus apellidos">
                </div>

                <div class="continput"> 
                    <div class="descinput">Selecciona una opción:</div>
                    <select class="selectgen"  id="opcionesCombo" name="opciones" >
                        <option value="Hombre">Hombre</option>
                        <option value="Mujer">Mujer</option>
                        <option value="No especificar">No especificar</option>
                    </select>

                </div>

                
                <div class="continput">
                    <button type="submit" value="Registrarse" id="btnreg" name="btnreg" class="botones">Registrarse</button>
                    <a href="" id="btnregcancel" name="btnregcancel">                    
                        <button type="reset" value="Cancelar"  class="botones">Cancelar</button>
                    </a>
                </div>
    
            </form>
        </section>
    
    
    </div>
    <script src="reganim.js"></script>

</body>
</html>