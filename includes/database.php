<?php

function conectarBD() {
    $host = "localhost"; 
    $port = "5432"; 
    $dbname = "dbphp";
    $user = "postgres";
    $password = "16022004";

    try {
        $db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    } catch (PDOException $e) {
        echo "No se pudo conectar a la base de datos: " . $e->getMessage();
    }

    return $db;
}
