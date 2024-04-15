<?php
require "../includes/database.php";
require '../includes/funciones.php';

$id = $_GET['id'] ?? null;


$db = conectarBD();

$query = "DELETE FROM item WHERE id_item = $id";
$stmt = $db->prepare($query);

$stmt->execute();

if ($stmt->rowCount() > 0) {
    header("Location: /pages/insumos.php?success=2");
}

