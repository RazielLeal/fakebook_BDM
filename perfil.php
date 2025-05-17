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
    <style>
        /* Incluir aquí el CSS modificado */
        .ContenidoGeneral {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Divide en dos columnas de igual tamaño */
            gap: 20px;
            padding: 20px;
        }

        .perfilContainer {
            grid-column: 1/2; /* Ahora ocupa solo la primera columna */
            background-color: var(--secundario);
            width: 100%;
            height: 650px; /* Reducido de 750px */
            border-radius: 15px;
            padding: 10px;
        }

        .perfil {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            grid-template-rows: repeat(7, 1fr);
            width: 100%;
            height: 100%;
            font: inherit;
        }

        .cambiarPPpreview {
            width: 200px; /* Reducido de 300px */
            height: 200px; /* Reducido de 300px */
            object-fit: cover;
            border-radius: 70%;
            box-shadow: 0 5px 10px 3px var(--sombra2);
            grid-column: 1/4;
            grid-row: 1/4;
            align-self: center;
            justify-self: center;
        }

        .perfil #camposPerfilContainer {
            grid-column: 4/8;
            grid-row: 1/8;
            background-color: var(--terciario);
            border-radius: 15px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .reporteLikesContainer {
            grid-column: 2/3; /* Ahora ocupa la segunda columna */
            grid-row: 1/2; /* Ajustado para estar al lado del perfil */
            background-color: var(--secundario);
            border-radius: 15px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            height: auto;
        }

        .likesrecibidosContainer h1 {
            margin: 0;
            font-size: 1.2em; /* Reducido el tamaño de la fuente para mejor adaptación */
        }

        .misPublicacionesContainer {
    grid-column: 2/3; /* Ocupa la segunda columna */
    grid-row: 2/3; /* Debajo del reporteLikesContainer */
    background-color: var(--secundario);
    border-radius: 15px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-top: 20px;
}

.misPublicacionesContainer h2 {
    margin: 0 0 15px 0;
    font-size: 1.4em;
    color: var(--texto);
}

.misPublicacionesContainer .Publicacion {
    background-color: var(--terciario);
    border-radius: 10px;
    padding: 15px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 15px;
}

.misPublicacionesContainer .PublicacionBody {
    font-size: 1.1em;
}

.misPublicacionesContainer .PublicacionHeaderImg img,
.misPublicacionesContainer .PublicacionHeaderImg video {
    max-width: 100%;
    border-radius: 8px;
    margin-top: 10px;
}

.misPublicacionesContainer .PublicacionHeaderNombre {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.misPublicacionesContainer .pppublis {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.misPublicacionesContainer .botonesInteraccion {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.misPublicacionesContainer .btnLike,
.misPublicacionesContainer .btnGuardar {
    padding: 8px 12px;
    border: none;
    border-radius: 5px;
    background-color: var(--primario);
    color: var(--texto);
    cursor: pointer;
    font-size: 0.9em;
}

.misPublicacionesContainer .btnLike:hover,
.misPublicacionesContainer .btnGuardar:hover {
    background-color: var(--acento);
}





/* Contenedor de la galería de fotos */
.galeriaFotosContainer {
    min-width: 300px;
    width: 350px;
    flex: 0 0 auto; /* No permite que se estire */
    background-color: var(--secundario);
    border-radius: 15px;
    padding: 20px;
    height: 650px;
    overflow-y: auto; /* Permite desplazamiento vertical */
}

.galeriaFotosContainer h2 {
    margin: 0 0 15px 0;
    font-size: 1.4em;
    color: var(--texto);
    position: sticky;
    top: 0;
    background-color: var(--secundario);
    padding: 10px 0;
    z-index: 2;
}

/* Cuadrícula de la galería */
.galeriaGrid {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* 2 columnas */
    gap: 10px;
    width: 100%;
}

/* Cada item de la galería */
.itemGaleria {
    position: relative;
    width: 100%;
    padding-bottom: 100%; /* Relación de aspecto cuadrada */
    overflow: hidden;
    border-radius: 8px;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.itemGaleria:hover {
    transform: scale(1.03);
}

.itemGaleria img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover; /* Mantiene la proporción y cubre el contenedor */
}

.mensajeNoFotos {
    grid-column: 1 / -1;
    text-align: center;
    padding: 20px;
    color: var(--texto);
    font-style: italic;
}

/* Modal para ver imagen ampliada */
.modalFoto {
    display: none;
    position: fixed;
    z-index: 1000;
    padding-top: 50px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.9);
}

.contenidoModal {
    margin: auto;
    display: block;
    max-width: 80%;
    max-height: 80%;
    object-fit: contain;
}

.descripcionModal {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: white;
    padding: 10px 0;
    height: 150px;
}

.cerrarModal {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
    cursor: pointer;
}

.cerrarModal:hover,
.cerrarModal:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

/* Animación para el modal */
.contenidoModal, .descripcionModal {
    animation-name: zoom;
    animation-duration: 0.6s;
}

@keyframes zoom {
    from {transform: scale(0)}
    to {transform: scale(1)}
}

/* Responsividad */
@media (max-width: 1200px) {
    .galeriaFotosContainer {
        width: 100%;
        height: auto;
        max-height: 500px;
    }
    
    .galeriaGrid {
        grid-template-columns: repeat(3, 1fr); /* 3 columnas en pantallas más pequeñas */
    }
}

@media (max-width: 600px) {
    .galeriaGrid {
        grid-template-columns: repeat(2, 1fr); /* 2 columnas en pantallas muy pequeñas */
    }
    
    .contenidoModal {
        max-width: 95%;
    }
    
    .descripcionModal {
        width: 95%;
    }
}
    </style>
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
                        <button type="button" class="botones" id="cerrarsesionbtn" name="cerrarsesionbtn">
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
                                $sql = "SELECT * FROM vista_amigo_favorito WHERE usuario_que_da_like = ? ORDER BY total_likes DESC LIMIT 1";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $usuarios_id);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    // Mostrar los resultados
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<h1>Al parecer tu persona favorita es " . $row['dueno_publicacion'];
                                        echo "<br>Le has dado " . $row['total_likes'] . " 👍 me gusta!!!</h1>";
                                    }
                                } else {
                                    echo "<h1>Para saber quien es tu amigo favorito, interactúa con ellos.</h1>";
                                }

                                // Cerrar la conexión
                                $stmt->close();
                            ?>                           

                    </div>
                </div>
            
            </section>
            <?php
// Añade este código a perfil.php después de la sección "reporteLikesContainer"

// Verificar si tenemos una conexión válida
if (!isset($conn) || $conn->connect_error) {
    // Reconectar si es necesario
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
}

try {
    // Consulta directa para obtener las publicaciones del usuario actual
    $query = "SELECT p.publicacion_id, p.usuarios_id, u.username, p.contenido, 
                   p.fecha_publicacion, mp.url_media, mp.tipo, u.imagen_perfil
              FROM publicaciones p
              INNER JOIN usuarios u ON p.usuarios_id = u.usuarios_id
              LEFT JOIN media_publicaciones mp ON mp.publicacion_id = p.publicacion_id
              WHERE p.usuarios_id = ?
              ORDER BY p.fecha_publicacion DESC";
    
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        echo "Error en la preparación de la consulta: " . $conn->error;
        exit;
    }
    
    $stmt->bind_param("i", $usuarios_id);
    
    if (!$stmt->execute()) {
        echo "Error al ejecutar la consulta: " . $stmt->error;
        exit;
    }
    
    $result_publicaciones = $stmt->get_result();
    $stmt->close();
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<section class="misPublicacionesContainer" id="misPublicacionesContainer">
    <h2>Mis Publicaciones</h2>
    
    <?php
    // Verificar si result_publicaciones está definido y tiene filas
    if (isset($result_publicaciones) && $result_publicaciones !== false && $result_publicaciones->num_rows > 0) {
        while ($row = $result_publicaciones->fetch_assoc()) {
            $publicacion_id = $row['publicacion_id'];
            $contenido = $row['contenido'];
            $url_media = $row['url_media'] ?? null;
            $tipo = $row['tipo'] ?? null;
            
            echo '<div class="Publicacion" id="Publicacion_'. $publicacion_id . '">';
            
            // Container del texto de la publicación
            echo '<div class="PublicacionBody" id="PublicacionBody">';
            echo '<p>' . htmlspecialchars($contenido) . '</p>';
            echo '</div>';
            
            // Container de la imagen de la publicación
            echo '<div class="PublicacionHeaderImg" id="PublicacionHeaderImg">';
            if (!empty($url_media)) {
                if ($tipo === "imagen") {
                    echo '<img src="data:image/png;base64,' . base64_encode($url_media) . '" alt="">';
                } elseif ($tipo === "video") {
                    echo '<video controls>';
                    echo '<source src="data:video/mp4;base64,' . base64_encode($url_media) . '" type="video/mp4">';
                    echo 'Tu navegador no soporta la etiqueta de video.';
                    echo '</video>';
                }
            }
            echo '</div>';
            
            // Nombre del usuario y foto de perfil
            echo '<div class="PublicacionHeaderNombre" id="PublicacionHeaderNombre">';
            echo '<img class="pppublis" src="' . ($row['imagen_perfil'] ? 'data:image/jpeg;base64,' . base64_encode($row['imagen_perfil']) : 'IMG/pp.png') . '" alt="">';
            echo '<a class="nombresamigos" href="">' . htmlspecialchars($row['username']) . '</a>';
            echo '</div>';
            
            
            
            echo '</div>'; // Cierre de la publicación
        }
    } else {
        echo '<p>Aún no has realizado ninguna publicación.</p>';
    }
    ?>
</section>

<div class="seccionesHorizontales">
    
    <!-- Sección de galería de fotos (NUEVA) -->
    <section class="galeriaFotosContainer" id="galeriaFotosContainer">
        <h2>Mis Fotos</h2>
        <div class="galeriaGrid" id="galeriaGrid">
            <?php
            // Verificar conexión
            if (!isset($conn) || $conn->connect_error) {
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }
            }

            try {
                // Consulta para obtener solo las publicaciones con imágenes del usuario
                $query = "SELECT p.publicacion_id, p.contenido, mp.url_media 
                         FROM publicaciones p 
                         LEFT JOIN media_publicaciones mp ON p.publicacion_id = mp.publicacion_id 
                         WHERE p.usuarios_id = ? AND mp.tipo = 'imagen' AND mp.url_media IS NOT NULL 
                         ORDER BY p.fecha_publicacion DESC";
                
                $stmt = $conn->prepare($query);
                
                if (!$stmt) {
                    echo "Error en la preparación de la consulta: " . $conn->error;
                } else {
                    $stmt->bind_param("i", $usuarios_id);
                    
                    if (!$stmt->execute()) {
                        echo "Error al ejecutar la consulta: " . $stmt->error;
                    } else {
                        $result_fotos = $stmt->get_result();
                        
                        if ($result_fotos->num_rows > 0) {
                            while ($row = $result_fotos->fetch_assoc()) {
                                $publicacion_id = $row['publicacion_id'];
                                $contenido = $row['contenido'];
                                $url_media = $row['url_media'];
                                
                                echo '<div class="itemGaleria" data-id="'.$publicacion_id.'" onclick="abrirModal(this)">';
                                echo '<img src="data:image/png;base64,'.base64_encode($url_media).'" alt="Foto de publicación" loading="lazy">';
                                echo '</div>';
                            }
                        } else {
                            echo '<p class="mensajeNoFotos">Aún no has publicado fotos</p>';
                        }
                        
                        $stmt->close();
                    }
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
        </div>
    </section>
    
    <!-- Las otras secciones (perfil, likes, publicaciones) que ya tenías -->
    <!-- ... -->
    
</div>

<!-- Modal para ver imagen ampliada -->
<div id="modalFoto" class="modalFoto">
    <span class="cerrarModal" onclick="cerrarModal()">&times;</span>
    <img class="contenidoModal" id="imgAmpliada">
    <div class="descripcionModal" id="descripcionModal"></div>
</div>
        </section>

    </div>

    <script src="perfil.js"></script>
    
</body>
</html>