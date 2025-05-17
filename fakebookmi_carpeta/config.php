<?php
    $db_server = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "fakebook_bdm";
    $port = "3307";

    $conn = mysqli_connect($db_server, $db_username, $db_password, $db_name, $port); //CONEXION CON LA COMPU DE URIEL
    
    //$conn = mysqli_connect($db_server, $db_username, $db_password, $db_name); //CONEXION CON LA COMPU DE RAZIEL

    if ($conn) {
        //echo "Conexión exitosa a la base de datos";
    } else {
        //echo "Error al conectar a la base de datos: " . mysqli_connect_error();
    }
?>