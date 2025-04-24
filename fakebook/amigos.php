<?php
    session_start();
    require 'config.php'; 

    if (!isset($_SESSION['usuarios_id'])) {
        header("Location: index.php");
        exit;
    }
    

    if (isset($_SESSION['resultados_busqueda'])) {
        $resultados = $_SESSION['resultados_busqueda'];
        // Limpia la variable para que no se muestren en recargas posteriores
        unset($_SESSION['resultados_busqueda']);
    } else {
        $resultados = array(); // o puedes mostrar contenido por defecto
    }
    
    
    $p_usuarios_id = $_SESSION['usuarios_id']; // ID del usuario logueado


    $accion = "E";
    $sql = "CALL SP_Master(?, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $accion, $p_usuarios_id);

    if ($stmt->execute()) {
        $resultPendientes = $stmt->get_result();
        
        $pendientes = array();
        while ($row = $resultPendientes->fetch_assoc()) {
            $pendientes[] = $row;
        }
    } else {
        echo "Error en la consulta: " . $stmt->error;
    }
    $stmt->close();
    
    $sql="CALL SP_Master(?,?,NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
    $stmt = $conn->prepare($sql);
    $accion = "Q";// Acción para obtener amigos ACEPTADOS
    $stmt->bind_param("si", $accion, $p_usuarios_id);

    if ($stmt->execute()) {
        $resultAmigos = $stmt->get_result();
        
        $amigos = array();
        while ($row = $resultAmigos->fetch_assoc()) {
            $amigos[] = $row;
        }
    } else {
        echo "Error en la consulta: " . $stmt->error;
    }
    $stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="red social landing page" content="width=device-width, initial-scale=1.0">
    <title>Fakebook - Amigos</title>
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

                <!-- <div class="headerbtn" id="btnnotis">
                    <a href="">
                        <img src="IMG/notis.png" alt="Notificaciones">    
                    </a>  
                    <a href="">
                        <span class="tooltip-text">Notificaciones</span>
                    </a>  
                </div> -->

                <div class="headerbtn" id="btnperfil">
                    <a href="perfil.php" target="_self">
                        <img src="IMG/perfil.png" alt="Perfil">
                    </a>
                    <a href="perfil.php" target="_self">
                        <span class="tooltip-text">Perfil</span>
                    </a>


                </div>

                <!-- <div class="headerbtn" id="btnconfig">
                    <a href="configuracion.html" target="_self">
                        <img src="IMG/config.png" alt="amigos">
                    </a>
                    <a href="configuracion.html" target="_self">
                        <span class="tooltip-text">Configuracion</span>
                    </a>


                </div> -->
            </section>
        </section>    

        <section class="ContenidoGeneral" id="ContenidoGeneral">
            
            <section class="containerSearchAmigos" id="containerSearchAmigos">
                <form class="searchAmigos" id="searchAmigos" method="get" action="buscarUsuarios.php">
                    <input class="inputgen" name="searchAmigosInput"type="text" id="searchAmigosInput" placeholder="Buscar personas">
                    <button class="botones" id="searchAmigosBtn">
                        <img src="IMG/lupa.png" alt="buscar">
                    </button>
                </form>                

                <div class="conatinerSearchResult" id="conatinerSearchResult">

                    <?php
                    // Recorremos los resultados y mostramos cada uno
                    if (!empty($resultados)) {
                        foreach ($resultados as $usuario_encontrado) {
                            $usuario_buscado = $usuario_encontrado['usuarios_id'];
                            $username_buscado = $usuario_encontrado['username'];
                            $imagen_buscado   = $usuario_encontrado['imagen_perfil'];
                            ?>
                            <div class="searchResult">
                                <div class="ppsearch">
                                    <?php

                                    if (!empty($imagen_buscado)) {
                                        echo '<img src="data:image/png;base64,' . base64_encode($imagen_buscado).'">';
                                    } else {
                                        echo '<img src="IMG/pp.png" alt="Perfil por defecto">';
                                    }
                                    ?>
                                </div>
                                <div class="nombresamigos">
                                    <div><?php echo htmlspecialchars($username_buscado); ?></div>
                                </div>

                                <div class="botones">
                                    <form method="POST" action="enviarSolicitud.php">
                                        <!-- Se envía el id del usuario a quien se le manda solicitud -->
                                        <input type="hidden" name="amigo_id" value="<?php echo $usuario_buscado; ?>">
                                        <!-- Puedes utilizar la imagen del icono de agregar amigo dentro del botón -->
                                        <button type="submit" class="btnAgregar" style="border: none; background: none;">
                                            <img src="IMG/addfriend.png" alt="Agregar amigo">
                                        </button>
                                    </form>
                                </div>
                                
                            </div>
                            <?php
                        }
                    } else {
                        echo "<div>Empieza a buscar amigos.</div>";
                    }
                    ?>


                </div>         



            </section>

            <section class="amigosContainer" id="amigosContainer">
                <div class="headerAmigosContainer">
                    <h2>Amigos</h2>
                </div>

                <div class="selectAmigosContainer">
                    <?php
                        // Recorremos los amigos y mostramos cada uno
                        if (!empty($resultAmigos)) {
                            foreach ($resultAmigos as $amigo) {
                                $id_amigos = $amigo['id_amigos']; // ID de la relación
                                $amigo_id = $amigo['amigo_id']; // ID del amigo en la relación
                                $username_amigo = $amigo['username']; // Nombre del amigo
                                $imagen_amigo   = $amigo['imagen_perfil']; // Imagen del amigo
                                
                                ?>
                                <div class="selectAmigo">
                                    <div class="selectAmigoPP">
                                        <?php
                                        if (!empty($imagen_amigo)) {
                                            echo '<img src="data:image/png;base64,' . base64_encode($imagen_amigo) . '">';
                                        } else {
                                            echo '<img src="IMG/pp.png" alt="Imagen de perfil por defecto">';
                                        }
                                        ?>
                                    </div>

                                    <div class="selectAmigoNombre">
                                        <?php echo htmlspecialchars($username_amigo); ?>
                                    </div>

                                    <form method="POST" action="procesarSolicitud.php" class="selectAmigoBotones">
                                        <!-- ID de la relación -->
                                        <input type="hidden" name="id_amigos" value="<?php echo $id_amigos; ?>">
                                        <!-- ID del amigo (solicitante) -->
                                        <input type="hidden" name="solicitante" value="<?php echo $amigo_id; ?>">
                                        <!-- Botón para eliminar -->
                                        <button type="submit" name="opcion" value="ELIMINAR" style="border: none; background:none;">
                                            <img src="IMG/deluser.png" alt="Eliminar">
                                        </button>
                                        <!-- Botón para bloquear -->
                                        <button type="submit" name="opcion" value="BLOQUEAR" style="border: none; background:none;">
                                            <img src="IMG/blockuser.png" alt="Bloquear">
                                        </button>
                                    </form>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<div>No tienes amigos registrados.</div>';
                        }
                    ?>
                </div>

            </section>

            <section class="amigosPendContainer" id="amigosPendContainer">
                <div id="headerpendientes">
                    <h1>Solicitudes pendientes</h1>
                </div>
                <div id="Solicitudescontainer">
                    <?php
                        // Se asume que $pendientes es el arreglo obtenido al ejecutar SP_Master con 'PENDIENTES'
                        if (!empty($pendientes)) {
                            foreach ($pendientes as $solicitud) {
                                // Extraer datos
                                $id_amigos         = $solicitud['id_amigos'];
                                $usuarioSolicitante  = $solicitud['usuario_id'];
                                $usernameSolicitante = $solicitud['username'];
                                $imagenSolicitante   = $solicitud['imagen_perfil'];

                                // Imprimir en la consola los datos de id_amigos, usuario_id y usernameSolicitante
                                ?>
                                <div class="solicitud">
                                    <div class="selectAmigoPP">
                                        <a href="">
                                            <?php 
                                            if (!empty($imagenSolicitante)) {
                                                echo '<img src="data:image/png;base64,' . base64_encode($imagenSolicitante) . '" alt="Perfil de ' . htmlspecialchars($usernameSolicitante) . '">';
                                            } else {
                                                echo '<img src="IMG/pp.png" alt="Perfil por defecto">';
                                            }
                                            ?>
                                        </a>
                                    </div>
                                    <div class="selectAmigoNombre">
                                        <a href=""><?php echo htmlspecialchars($usernameSolicitante); ?></a>
                                    </div>
                                    <form class="selectAmigoBotones" method="POST" action="procesarSolicitud.php">
                                        
                                        <input type="hidden" name="id_amigos" value="<?php echo $id_amigos; ?>">
                                        <input type="hidden" name="solicitante" value="<?php echo $usuarioSolicitante; ?>">

                                        <button type="submit" name="opcion" value="RECHAZAR" style="border: none; background: none;">
                                            <img src="IMG/rechazarfriend.png" alt="Rechazar" name="rechazar" >
                                        </button>

                                        <button type="submit" name="opcion" value="ACEPTAR" style="border: none; background: none;">
                                            <img src="IMG/aceptarfriend.png" alt="Aceptar" name="Aceptar" >
                                        </button>
                                    </form>
                                </div>
                                <?php //

                            }
                        } 
                        else {
                            echo '<div>No tienes solicitudes pendientes.</div>';
                        }

                    ?>
                </div>

            </section>            

        </section>

    </div>



</body>
</html>