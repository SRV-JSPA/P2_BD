<?php
require "../includes/database.php";
require '../includes/funciones.php';

$db = conectarBD();

$id = $_GET['id'] ?? null;

if(isset($id)){
    date_default_timezone_set('America/Mexico_City');
    $horaActual = date("H:i:s");
    $query = "UPDATE pedido SET horafin = '$horaActual' WHERE id_pedido = $id";
    $stmt = $db->prepare($query);
    $stmt->execute();
    if($stmt->rowCount() > 0){
        header('Location: /pages/pedidos.php?success=3');
        exit; 
    }
}