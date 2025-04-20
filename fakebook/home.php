<?php

    require 'config.php';
    session_start(); 

    $usuarios_id = $_SESSION['usuarios_id']; 

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    

    $sql = "CALL SP_ObtenerPublicacionesDeAmigos(?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuarios_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Llamar al Stored Procedure
    
    // while ($row = $result->fetch_assoc()) {
    //     $publicacion_id = $row['publicacion_id'];
    //     $usuarios_id = $row['usuarios_id'];
    //     $username = $row['username'];
    //     $imagen_perfil = $row['imagen_perfil'];
    //     $contenido = $row['contenido'];
    // }
    
   
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
                <form action="" method="POST" data-url="">

                    <textarea type="text" class="DescripcionPubli" id="publicacion" cols="30" rows="10" placeholder="Comparte lo que piensas!"></textarea>

                    <div class="imgContainer" id="imgContainer">
                        <div class="imgoptions">
                            <img src="IMG/meme.jpg" alt="preview">
                            <span class="borrarfotobtn">&times</span>
                        </div>
                    </div>

                    <button class="botones" id="btnpublicar" type="submit" value="Publicar">Publicar</button>
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
                
                        // Convertir imagen de perfil si no es NULL
                        if (!empty($row['imagen_perfil'])) {
                            $imagen_perfil = 'data:image/jpeg;base64,' . base64_encode($row['imagen_perfil']);
                        } else {
                            $imagen_perfil = 'IMG/pp.png';
                        }
                
                        echo '<div class="Publicacion" id="Publicacion_'. $publicacion_id . '">';

                        // <!-- CONTAINER DE LA IMAGEN DE LA PUBLICACION -->
                        echo '<div class="PublicacionHeaderImg" id="PublicacionHeaderImg">';

                            //echo '<img src="IMG/meme.jpg" alt="">';

                        echo '</div>';

                        //<!-- CONTAINER DEL NOMBRE DE USUARIO DE LA PUBLICACION -->
                        echo '<div class="PublicacionHeaderNombre" id="PublicacionHeaderNombre">';

                            echo '<img class="pppublis" src="' . $imagen_perfil . '" alt="">';
                            echo '<a class="nombresamigos" href="">' . htmlspecialchars($username) . '</a>';

                        echo '</div>';

                        //<!-- CONTAINER DEL TEXTO DE LA PUBLICACION -->
                        echo '<div class="PublicacionBody" id="PublicacionBody">';

                            echo '<p>' . htmlspecialchars($contenido) . '</p>';

                        echo '</div>';

                        //<!-- CONTAINER DE LA INTERACCION DE LA PUBLICACION -->
                        echo '<div class="PublicacionInteracciones">'; 

                            echo '<textarea placeholder="Escribe un comentario..." class="comentarioTextbox" rows="2" maxlength="100"></textarea>'; 
                            echo '<button class="btnComentar">📝 Publicar comentario</button>'; 

                        echo '</div>'; 

                        echo '<div class="botonesInteraccion">';

                            echo '<button class="btnLike" data-publicacion_id="'.$publicacion_id.'">👍 Me gusta</button>';
                            echo '<button class="btnGuardar">💾 Guardar</button>';

                        echo '</div>';

                        //<!-- CONTAINER DE LOS COMENTARIOS DE LA PUBLICACION -->
                        echo '<div class="comentariosList"></div>';

                        echo '</div>';

                    }
                
                ?>
            </section>

        </section>

    </div>


    <script>
    // Esperamos a que todo el DOM esté cargado
    document.addEventListener('DOMContentLoaded', () => {

        const publicaciones = document.querySelectorAll('.Publicacion');

        publicaciones.forEach(publi => {
            const btnComentar = publi.querySelector('.btnComentar');
            const textarea = publi.querySelector('.comentarioTextbox');
            const comentariosList = publi.querySelector('.comentariosList');

            btnComentar.addEventListener('click', () => {
                const texto = textarea.value.trim();
                if (texto !== '') {
                    const nuevoComentario = document.createElement('p');
                    nuevoComentario.textContent = texto;
                    nuevoComentario.classList.add('comentario');
                    comentariosList.appendChild(nuevoComentario);
                    textarea.value = '';
                }
            });
        });

        const btnLikes = document.querySelectorAll('.btnLike');

        btnLikes.forEach(btn => {
            btn.addEventListener('click', function() {
                const publicacion_id = this.closest('.Publicacion').querySelector('.btnLike').dataset.publicacion_id;
                const usuarios_id = <?php echo $usuarios_id; ?>;  // Obtener el ID del usuario desde PHP

                // Realizamos la llamada AJAX
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'dar_like.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    console.log(xhr.responseText);  // Verifica lo que estás recibiendo del servidor
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                // alert('¡Me gusta agregado!');
                            } else {
                                // alert('¡Ya le diste like a esta publicación!');
                                console.log("ID de publicación:" + publicacion_id);
                            }
                        } catch (e) {
                            console.error("Error al parsear JSON", e);
                            //alert('Respuesta no es un JSON válido');
                        }
                    } else {
                        //alert('Error al procesar la solicitud.');
                    }
                };
                xhr.send('usuarios_id=' + usuarios_id + '&publicacion_id=' + publicacion_id);
            });
        });        

    });
</script>
</body>
</html>