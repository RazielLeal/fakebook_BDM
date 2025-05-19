<?php

    require 'config.php';
    session_start(); 

    if (!isset($_SESSION['usuarios_id'])) {
        header("Location: index.php");
        exit;
    }
    
    $usuarios_id = $_SESSION['usuarios_id']; 

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    

    
    $sql = "CALL SP_Master(?, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
    $stmt = $conn->prepare($sql);
    $accion = 'O';
    $stmt->bind_param("si", $accion, $usuarios_id);
    $stmt->execute();
    $result = $stmt->get_result();  
   
    $stmt->close();
    // Cerrar conexiones
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="red social landing page" content="width=device-width, initial-scale=1.0">
    <title>Fakebook - Home</title>
    <link rel="stylesheet" href="styles.css">
</head>


</head>

<body>
    <div class="ContLP" id="ContLPhome">

        <section class="headertitulo" id="header">
            <div class="titulo" id="titulo">
                <a href="">Fakebook</a>
            </div>
        
            <section class="headerNav" id="headerNav">

                <div class="headerbtn" id="btnhome">
                    <a href="" target="_self">
                        <img src="IMG/Home.png" alt="Home">
                    </a>
                    <a href="" target="_self">
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
            
            <section class="ContainerCrearPubli" id="ContainerCrearPubli" enctype="multipart/form-data">
                <form action="crearPubli.php" method="POST" enctype="multipart/form-data">

                    <textarea name="contenido" type="text" class="DescripcionPubli" id="publicacion" cols="30" rows="10" placeholder="Comparte lo que piensas!"></textarea>

                    <div class="imgContainer" id="imgContainer">
                    </div>

                    <button class="botones" id="btnpublicar" name="btnpublicar" type="submit" value="Publicar">Publicar</button>
                    <label class="botones" id="btnsubirimg" for="media">Subir imagen</label>
                    <input  type="file" id="media" name="media" accept="image/*,video/*" style="display: none;">
                </form>
            </section>
            


            <section class="ContainerPublicaciones" id="ContainerPublicaciones">

                <?php


                    while ($row = $result->fetch_assoc()) {
                        $publicacion_id = $row['publicacion_id'];
                        $amigo_id = $row['usuarios_id'];
                        $username = $row['username'];
                        $contenido = $row['contenido'];
                        $url_media = $row['url_media'];
                        $tipo = $row['tipo'];


                        // Convertir imagen de perfil si no es NULL
                        if (!empty($row['imagen_perfil'])) {
                            $imagen_perfil = 'data:image/jpeg;base64,' . base64_encode($row['imagen_perfil']);
                        } else {
                            $imagen_perfil = 'IMG/pp.png';
                        }
                
                        echo '<div class="Publicacion" id="Publicacion_'. $publicacion_id . '">';

                                //<!-- CONTAINER DEL TEXTO DE LA PUBLICACION -->
                                echo '<div class="PublicacionBody" id="PublicacionBody">';

                                    echo '<p>' . htmlspecialchars($contenido) . '</p>';

                                echo '</div>';


                                // <!-- CONTAINER DE LA IMAGEN DE LA PUBLICACION -->
                                echo '<div class="PublicacionHeaderImg" id="PublicacionHeaderImg">';

                                if ($row["tipo"] === "imagen") {
                                    // Muestra la imagen; si conoces el formato, ajusta "image/png"
                                    echo '<img src="data:image/png;base64,' . base64_encode($row["url_media"]) . '" alt="">';
                                } elseif ($row["tipo"] === "video") {
                                    // Muestra el video; ajusta el tipo MIME ("video/mp4") según corresponda
                                    echo '<video controls>';
                                    echo '<source src="data:video/mp4;base64,' . base64_encode($row["url_media"]) . '" type="video/mp4">';
                                    echo 'Tu navegador no soporta la etiqueta de video.';
                                    echo '</video>';
                                }
                            

                        echo '</div>';
                        
                        echo '<div class="PublicacionHeaderNombre" id="PublicacionHeaderNombre">';

                            echo '<img class="pppublis" src="' . $imagen_perfil . '" alt="">';
                            echo '<a class="nombresamigos" href="">' . htmlspecialchars($username) . '</a>';

                        echo '</div>';
                        
                        ?>


                        <!-- FUNCION DE COMENTAR -->
                        <form class="PublicacionInteracciones" method="POST" action="comentar.php">
                            <input type="hidden" name="usuarios_id" value="<?php echo htmlspecialchars($usuarios_id); ?>"> 
                            <input type="hidden" name="publicacion_id" value="<?php echo htmlspecialchars($publicacion_id); ?>"> 

                            <textarea name="contenido" placeholder="Escribe un comentario..." class="comentarioInput" rows="2" maxlength="100" required></textarea>
                            <button type="submit" class="btnComentar">Publicar</button>
                        </form>

                        <!-- LIKES Y GUARDAR -->
                        <div class="botonesInteraccion">

                            <?php echo '<button class="btnLike" data-publicacion_id="'.$publicacion_id.'">👍 Me gusta</button>';?>
                            <?php echo '<button class="btnGuardar" data-publicacion_id="'.$publicacion_id.'">🗂️ Guardar</button>';?>

                        </div>

                        <!-- CONTAINER DE LOS COMENTARIOS DE LA PUBLICACION -->
                        <div class="comentariosList">
                            
                        <?php
                        $accion_obtener_comentarios = "G";
                        $sql_select = "CALL SP_Master(?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
                        $stmt = $conn->prepare($sql_select);
                        $stmt->bind_param("si", $accion_obtener_comentarios, $publicacion_id);

                        if ($stmt->execute()) {
                            $result_comentarios = $stmt->get_result();
                            $comentarios = $result_comentarios->fetch_all(MYSQLI_ASSOC);

                            if (count($comentarios) > 0) {
                                foreach ($comentarios as $comentario) {
                                    echo '<div class="comentarioPublicado">';
                                    echo '<div class="comentario"><strong>' . htmlspecialchars($comentario['username']) . ':</strong> ' . htmlspecialchars($comentario['contenido']) . '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p>No hay comentarios aún</p>';
                            }
                        } else {
                            echo '<p>No se pudieron cargar los comentarios: ' . $stmt->error . '</p>';
                        }
                        $stmt->close();
                            ?>
                        </div>


                        
                        </div>

                        
                        
                    <?php } ?>


            </section>

        </section>

    </div>



    <script src="previewIMG.js"></script>

   
    <script>
        document.querySelectorAll('.comentarioTextbox').forEach(textarea => {
            textarea.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault(); // Prevenir salto de línea
                    const form = this.closest('form');
                    form.submit(); // Enviar el formulario
                }
            });
        });

    const botonesLike = document.querySelectorAll(".btnLike");

    botonesLike.forEach((btn) => {
        btn.addEventListener("click", () => {
            // Obtener el ID de la publicación desde el atributo data
            const publicacion_id = btn.getAttribute("data-publicacion_id");

            // Obtener el ID del usuario desde PHP (puedes modificar esto según cómo guardes la sesión)
            const usuarios_id = <?php echo json_encode($_SESSION['usuarios_id']); ?>;

            // Enviar la solicitud al servidor
            fetch("dar_like.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: new URLSearchParams({
                    usuarios_id: usuarios_id,
                    publicacion_id: publicacion_id,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        console.log("Like registrado correctamente.");
                    } else {
                        console.log("Ya le diste like a esta publicación.");
                    }
                })
                .catch((error) => {
                    console.error("Error en la solicitud:", error);
                });
        });
    });

    </script>
<script src="guardar.js"></script>
</body>
</html>