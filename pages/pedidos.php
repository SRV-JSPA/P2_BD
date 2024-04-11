<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);
?>

<main class="pedidos">
<button class="boton-verde">+</button>
    <section class="pedidos-seccion" >
        <h1>pedido</h1>
    </section>
</main>

<?php
incluirTemplate('footer');
?>