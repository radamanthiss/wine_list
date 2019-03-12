<?php

function db_connect() {
    
    $dbhost = "localhost"; // El host
    $dbuser = "root"; // El usuario
    $dbpass = "1234"; // El Pass
    $db = "data_wine"; // Nombre de la base
    $mysqli = new mysqli($dbhost, $dbuser,$dbpass, $db);
    if ($mysqli -> connect_errno) {
        die( "Fallo la conexión a MySQL: (" . $mysqli -> mysqli_connect_errno(). ") " . $mysqli -> mysqli_connect_error());
    }
    
    return $mysqli;
}

function db_connect_initial() {
    
    $dbhost = "localhost"; // El host
    $dbuser = "root"; // El usuario
    $dbpass = "1234"; // El Pass
    
    $mysqli = new mysqli($dbhost, $dbuser,$dbpass);
    if ($mysqli -> connect_errno) {
        die( "Fallo la conexión a MySQL: (" . $mysqli -> mysqli_connect_errno(). ") " . $mysqli -> mysqli_connect_error());
    }
    
    return $mysqli;
}
?>