<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);
?>

<main class="pedidos">
<button class="boton-verde">+ Agregar pedido</button>
    <section class="pedidos-seccion">
        <h1>Pedido id_pedido</h1>
        <p>Cantidad - nombre ítem</p>
        <p>Mesa id_mesa</p>
        <p>Mesero: id_mesero</p>
    </section>
</main>

<?php
incluirTemplate('footer');
?>