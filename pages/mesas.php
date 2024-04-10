<?php
require "../includes/database.php";
require '../includes/funciones.php';

$db = conectarBD();

incluirTemplate('header', $inicio = true);
?>

<main>
    <h1>mesas</h1>
</main>

<?php
incluirTemplate('footer')
?>

