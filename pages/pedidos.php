<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);

$db = conectarBD();

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($id !== null) {
    $queryPedido = "SELECT * FROM pedido WHERE id_mesa = :id";
    $stmtPedido = $db->prepare($queryPedido);
    $stmtPedido->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtPedido->execute();
    $pedido = $stmtPedido->fetchAll(PDO::FETCH_ASSOC);
} else {
    $pedido = null;
}
?>

<main class="pedidos">
    <button class="boton-verde" onclick="window.location.href = '/pages/nuevo-pedido.php'" >+ Agregar pedido</button>
    <?php if ($id !== null && !empty($pedido)): 
        foreach ($pedido as $pd ) {?>
    <section class="pedidos-seccion">
        <h1>Pedido <?php echo $pd['id_pedido']; ?></h1>
        <p>Cantidad - nombre ítem</p>
        <p>Área:  --> Mesa <?php echo $pd['id_mesa']; ?></p>
        <p>Mesero: <?php echo $pd['id_mesero']; ?></p>
    </section>
    <?php }else: ?>
    <p>No se encontró ningún pedido<?php echo $id; ?></p>
    <?php endif; ?>
</main>

<?php
incluirTemplate('footer');
?>
