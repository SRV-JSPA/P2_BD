<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);

$id_pago = $_GET['id'] ?? null;
$total = $_GET['total'] ?? null;

$db = conectarBD();



?>

<main>
    <h1>pago</h1>
</main>



<?php 
incluirTemplate('footer');
?>