<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);
?>

<main class="Cocina">
<center> 
<h1>Lista de Platos a Cocinar</h1>
</center> 
<section class="cocina">
        <p>Comida</p>
    </section>
</main>

<?php
incluirTemplate('footer');
?>