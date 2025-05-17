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
                <a href="">Fakebook</a>
            </div>
        
            <section class="headerNav" id="headerNav">

                <div class="headerbtn" id="btnhome">
                    <a href="home.html" target="_self">
                        <img src="IMG/Home.png" alt="Home">
                    </a>
                    <a href="home.html" target="_self">
                        <span class="tooltip-text">Inicio</span>
                    </a>

                </div>
        
                <div class="headerbtn" id="btnamigos">                    
                    <a href="amigos.html" target="_self">
                        <img src="IMG/amigos.png" alt="Amigos">
                    </a>     
                    <a href="amigos.html" target="_self">
                        <span class="tooltip-text">Amigos</span>           
                    </a>     

                </div>    

                <div class="headerbtn" id="btnnotis">
                    <a href="">
                        <img src="IMG/notis.png" alt="Notificaciones">    
                    </a>  
                    <a href="">
                        <span class="tooltip-text">Notificaciones</span>
                    </a>  
                </div>

                <div class="headerbtn" id="btnperfil">
                    <a href="perfil.html" target="_self">
                        <img src="IMG/perfil.png" alt="Perfil">
                    </a>
                    <a href="perfil.html" target="_self">
                        <span class="tooltip-text">Perfil</span>
                    </a>


                </div>

                <div class="headerbtn" id="btnconfig">
                    <a href="configuracion.html" target="_self">
                        <img src="IMG/config.png" alt="amigos">
                    </a>
                    <a href="configuracion.html" target="_self">
                        <span class="tooltip-text">Configuracion</span>
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
                        <div class="imgoptions">
                            <img src="IMG/meme.jpg" alt="preview">
                            <span class="borrarfotobtn">&times</span>
                        </div>
                        <div class="imgoptions">
                            <img src="IMG/meme.jpg" alt="preview">
                            <span class="borrarfotobtn">&times</span>
                        </div>
                        <div class="imgoptions">
                            <img src="IMG/meme.jpg" alt="preview">
                            <span class="borrarfotobtn">&times</span>
                        </div>
                        <div class="imgoptions">
                            <img src="IMG/meme.jpg" alt="preview">
                            <span class="borrarfotobtn">&times</span>
                        </div>
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
                
                <div class="Publicacion" id="Publicacion">
                    <div class="PublicacionHeaderImg" id="PublicacionHeaderImg">
                        <img src="IMG/meme.jpg" alt="Foto de perfil">
                    </div>
                    <div class="PublicacionHeaderNombre" id="PublicacionHeaderNombre">
                        <img class="pppublis" src="IMG/pp.png" alt="">
                        <a class="nombresamigos" href="">Nombre de usuario</a>
                    </div>

                    <div class="PublicacionBody" id="PublicacionBody">
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quam et ratione
                             ipsam optio iure distinctio eaque? Vero numquam natus sit autem eius quas mollitia quia minima!
                              Fugiat neque voluptatum possimus!

                              Lorem ipsum dolor sit amet consectetur, adipisicing elit. Qui consectetur animi quasi consequatur iure aperiam maxime illum.
                               Exercitationem nemo eum soluta reiciendis, voluptas debitis ad! Vero quia impedit nulla? Odio.
                        </p>
                    </div>

                </div>
                
            </section>

        </section>

    </div>


    <script src="homeanim.js"></script>

</body>
</html>