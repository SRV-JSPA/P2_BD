<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);
?>

<main class="Bar">
<center> 
<h1>Lista de bebidas a preparar</h1>
</center> 
<section class="bar">
        <p>Bebida</p>
    </section>
</main>

<?php
incluirTemplate('footer');
?>