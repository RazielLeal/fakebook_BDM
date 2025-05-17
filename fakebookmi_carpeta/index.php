<?php

require 'config.php'; // Archivo de configuración para la conexión a la base de datos.

session_start(); // Iniciar sesión.

if (isset($_POST['btnformis'])) {
    $email = trim($_POST['email']);
    $contra = $_POST['contra'];

    // Verificar si los campos están vacíos
    if (!empty($email) && !empty($contra)) {
        // Llamar al stored procedure
        $query = "CALL SP_Master(?, NULL, NULL, NULL, NULL, NULL, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
        $stmt = $conn->prepare($query); // Preparar la consulta
        if (!$stmt) {
            die("Error en la consulta preparada: " . $conn->error);
        }
        
        $accion = 'V';
        $stmt->bind_param("ss", $accion, $email); // Vincular parámetros
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Verificar la contraseña
            if (password_verify($contra, $row['contra'])) {
                // Guardar información del usuario en la sesión
                $_SESSION['email'] = $row['email'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['nombres'] = $row['nombres'];
                $_SESSION['apellidos'] = $row['apellidos'];
                $_SESSION['imagen_perfil'] = $row['imagen_perfil'];
                $_SESSION['usuarios_id'] = $row['usuarios_id'];

                // Redirigir al usuario a la página de inicio
                header("Location: home.php");
                exit;
            } else {
                echo "<script>alert('Contraseña incorrecta.');</script>";
            }
        } else {
            echo "<script>alert('El correo no está registrado o hubo un error.');</script>";
        }

        $stmt->close(); // Cerrar el statement
    } else {
        echo "<script>alert('Por favor, completa todos los campos.');</script>";
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
    <div class="ContLP" id="ContLPindex">

        <section class="headertitulo" id="header">
            <div class="titulo" id="titulo">
                <a href="index.php">Fakebook</a>
            </div>
    
            <div class="headerbtn" id="btnis">
                <a>Iniciar sesión</a>
            </div>
    
            <div class="headerbtn" id="btnreg">
                <a href="reg.php">Registrarse</a>
            </div>
        </section>
    
        <section class="contimglp" id="contimglp">
        <img src="IMG/peolpe_2.png" alt="Descripción de la imagen" width="40px" height="100px">
        <div class="container">
          <div class="world"></div>
          <div class="user">
            <img src="IMG/pp.png" alt="User 1"> <!-- Imagen de perfil -->
          </div>
          <div class="user">
            <img src="IMG/pp.png" alt="User 2"> <!-- Imagen de perfil -->
          </div>
          <div class="user">
            <img src="IMG/pp.png" alt="User 3"> <!-- Imagen de perfil -->
          </div>
          <div class="user">
            <img src="IMG/pp.png" alt="User 4"> <!-- Imagen de perfil -->
          </div>
          <div class="user">
            <img src="IMG/pp.png" alt="User 5"> <!-- Imagen de perfil -->
          </div>
          <div class="user">
            <img src="IMG/pp.png" alt="User 6"> <!-- Imagen de perfil -->
          </div>
        </div>
        </section>
        
    
    </div>

    <div class="overlay"></div> 

    <section class="popupIScont">
        <form action="" method="POST" class="formISyREG" id="formIS">    
            
            <div class="continput">
                <div class="descinput">
                    Ingrese su correo:
                </div>
                <input type="email" name="email" class="inputgen" id="inputcorreo" placeholder="Correo">
            </div>

            <div class="continput">
                <div class="descinput">
                    Ingrese su contraseña:
                </div>
                <input type="password" name="contra" class="inputgen" id="inputcontra" placeholder="Contraseña">
                <div id="mostrarcontracont" class="custom-checkbox">
                    <img src="checkboxoff.png" alt="CheckMostrarContraseña" id="CheckMostrarContra" class="checked">
                    <img src="checkbox.png" alt="CheckMostrarContraseña" id="CheckOcultarContra" class="unchecked"> 
                    <div id="cambiartexto">
                        Mostrar contraseña
                    </div>
                     
                </div>
            </div>

            <div class="continput">
                <button type="submit" value="Iniciar sesión" id="btnformis" class="botones" name="btnformis">Iniciar sesión</button>
                <button type="submit" value="Cancelar" id="btnformsalir" class="botones" name="btnformsalir">Cancelar </button>
            </div>

        </form>
    </section>

    <script src="animaciones.js"></script>

</body>
</html>