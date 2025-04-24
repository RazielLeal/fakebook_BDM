<?php

    require 'config.php';
    session_start();

    if (!isset($_SESSION['usuarios_id'])) {
        header("Location: index.php");
        exit();
    }



    $usuarios_id = $_SESSION['usuarios_id']; // Obtener el user_id del usuario logueado


    //DATOS DE PERFIL
    $query = "CALL SP_Master(?, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
    $stmt = $conn->prepare($query);
    $accion='P';
    $stmt->bind_param("si", $accion, $usuarios_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $DatosUsuario = $result->fetch_assoc();

    $nombres = $DatosUsuario['nombres'];
    $apellidos = $DatosUsuario['apellidos'];
    $username = $DatosUsuario['username'];
    $contra = $DatosUsuario['contra'];
    $email = $DatosUsuario['email'];
    $contra = $DatosUsuario['contra'];
    $imagen_perfil = $DatosUsuario['imagen_perfil'] ?? null;

    $result->free();
    $stmt->close();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="red social landing page" content="width=device-width, initial-scale=1.0">
    <title>Fakebook - Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="ContLP" id="ContLPhome">

        <section class="headertitulo" id="header">
            <div class="titulo" id="titulo">
                <a href="home.php">Fakebook</a>
            </div>
        
            <section class="headerNav" id="headerNav">

                <div class="headerbtn" id="btnhome">
                    <a href="home.php" target="_self">
                        <img src="IMG/Home.png" alt="Home">
                    </a>
                    <a href="home.php" target="_self">
                        <span class="tooltip-text">Inicio</span>
                    </a>

                </div>
        
                <div class="headerbtn" id="btnamigos">                    
                    <a href="amigos.php" target="_self">
                        <img src="IMG/amigos.png" alt="Amigos">
                    </a>     
                    <a href="amigos.php" target="_self">
                        <span class="tooltip-text">Amigos</span>           
                    </a>     

                </div>    

                <div class="headerbtn" id="btnperfil">
                    <a href="perfil.php" target="_self">
                        <img src="IMG/perfil.png" alt="Perfil">
                    </a>
                    <a href="perfil.php" target="_self">
                        <span class="tooltip-text">Perfil</span>
                    </a>


                </div>

            </section>
        </section>    

        <section class="ContenidoGeneral" id="ContenidoGeneral">
            
            <section class="perfilContainer" id="perfilContainer">
                <form action="actualizarDatos.php" class="perfil" method="POST" enctype="multipart/form-data" id="perfil">

                    <img src="<?php echo $imagen_perfil ? 'data:image/jpeg;base64,' . base64_encode($imagen_perfil) : 'IMG/pp.png'; ?>" alt="foto de perfil" class="cambiarPPpreview" id="perfilImagen">                    <label for="mediapp" class="botones" id="subirimagenbtn">Subir imagen</label>
                    <input type="file" name="mediapp" id="mediapp" accept="image/*,video/" style="display: none;">
                    
                    
                    <script>
                        console.log("Información del usuario:");
                        console.log("ID: <?php echo $usuarios_id; ?>");
                        console.log("Nombres: <?php echo $nombres; ?>");
                        console.log("Apellidos: <?php echo $apellidos; ?>");
                        console.log("Usuario: <?php echo $username; ?>");
                        console.log("Correo: <?php echo $email; ?>");
                        console.log("Contraseña: <?php echo $contra; ?>");
                        console.log("Mensaje de error: <?php echo isset($errorPasswordMsg) ? $errorPasswordMsg : 'No hay error'; ?>");
                    </script>
                    
                    <div id="camposPerfilContainer">
                        <div>Nombre(s):</div>
                        <input type="text" name="cambiarnombres" id="cambiarnombres" value="<?php echo $nombres; ?>" placeholder="Ingrese su(s) nombre(s):" class="inputgen">
                        <div>Apellido(s):</div>
                        <input type="text" name="cambiarapellidos" id="cambiarapellidos" value="<?php echo $apellidos; ?>" placeholder="Ingrese sus(s) apellido(s):" class="inputgen">
                        <div>Usuario:</div>
                        <input type="text" name="cambiarusuario" id="cambiarusuario" value="<?php echo $username; ?>" placeholder="Nuevo usuario:" class="inputgen">
                        <div>Contraseña:</div>
                        <input type="password" name="cambiarcontraseña" id="cabmiarcontraseña" value="" placeholder="Nueva contraseña:" class="inputgen">
                        
                        <?php
                        if (isset($_GET['error'])) {
                            echo '<div style="color: red;">' . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8') . '</div>';
                        }

                        if (isset($_GET['success'])) {
                            echo '<div style="color: green; display:none;">Perfil actualizado con éxito.</div>';
                        }
                        ?>
                        
                        <div>Correo:</div>
                        <input type="text" name="cambiarcorreo" id="cambiarcorreo" value="<?php echo $email; ?>" placeholder="Ingrese su nuevo correo:" class="inputgen">
                    

                    </div>

                    <div id="acomodarbotones">
                        <button type="submit" class="botones" id="guardarPPchange" name="guardarPPchange">Guardar Cambios</button>
                        <button type="reset" class="botones" id="cancelarPPchange" name="cancelarPPchange" >Cancelar</button> 
                        <button type="submit" class="botones" id="cerrarsesionbtn" name="cerrarsesionbtn">
                             <a href="logout.php">Cerrar sesión</a>
                        </button>
                    </div>

                </form>

            </section>

            <section class="reporteLikesContainer" id="reporteLikesContainer">

                <div class="likesrecibidos" id="likesrecibidos">
                    <div class="likesrecibidosContainer" id="likesrecibidosContainer">

                            <?php
                                // Supón que $usuarios_id contiene el ID del usuario que está logueado (por ejemplo, 15)
                                // Llamada al stored procedure
                                $query = "CALL SP_Master(?, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
                                //$query = "CALL SP_TotalLikes(?)";
                                $stmt = $conn->prepare($query);
                                $accion ='T';
                                $stmt->bind_param("si", $accion, $usuarios_id);
                                //$stmt->bind_param("i", $usuarios_id);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                // Recuperamos el resultado y mostramos el total de likes
                                if ($row = $result->fetch_assoc()) {
                                    
                                    if ($row['total_likes'] > 0) {
                                        // Mostrar el total de likes
                                        echo "<h1>Has recibido ".$row['total_likes']." 👍 me gusta!!!</h1>";
                                    } else {
                                        echo "<h1>Aún no haz recibido ningun me gusta. Haz una publicación para recibir me gusta.</h1>";
                                    }
                                }

                                // Liberamos los recursos
                                
                                $result->free();
                                $stmt->close();

                                //$query = "CALL SP_LikesDados(?)";
                                $query = "CALL SP_Master(?, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
                                $stmt = $conn->prepare($query);
                                $accion ='D';
                                $stmt->bind_param("si", $accion, $usuarios_id);  // 'i' significa entero
                                $stmt->execute();
                                $result = $stmt->get_result();
                            
                                // Recuperamos el resultado y mostramos la cantidad de likes dados
                                if ($row = $result->fetch_assoc()) {
                                    echo "<h1>Has dado un total de " . $row['total_likes_dados'] . " 👍 me gusta!!!</h1>";
                                } 

                                $result->free();
                                $stmt->close();

                                //$query = "CALL SP_AmigoFavorito(?)";
                                $query = "CALL SP_Master(?, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
                                $stmt = $conn->prepare($query);
                                $accion ='F';
                                $stmt->bind_param("si", $accion, $usuarios_id);                                
                                $stmt->execute();

                                // Obtener los resultados
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    // Mostrar los resultados
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<h1>Al parecer tu persona favorita es " . $row['DueñodePublicacion'];
                                        echo "<br>Le has dado " . $row['TotalLikes'] . " 👍 me gusta!!!</h1>";
                                    }
                                } else {
                                    echo "<h1>Para saber quien es tu amigo favorito, interactúa con ellos.</h1>";
                                }

                                // Cerrar la conexión
                                $stmt->close();
                                $conn->close();
                            ?>                           

                    </div>
                </div>
            
            </section>
        </section>

    </div>

    <script src="perfil.js"></script>
    
</body>
</html>
