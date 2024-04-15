<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);

$db = conectarBD();

$exito = $_GET['success'] ?? NULL;

if (!isset($_SESSION)) {
    session_start();
}

$primer_click = !isset($_SESSION['agregar_insumo_click']);


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_insumo'])) {

    $id_pedido = $_POST['id_pedido'] ?? null;


    if (!empty($id_pedido)) {
        if ($primer_click) {
            $_SESSION['agregar_insumo_click'] = true;
        } else {
            $_SESSION['agregar_insumo_click'] = false;
        }

        header("Location: /pages/agregar-insumo.php?id=" . $id_pedido);
        exit;
    }
}

$queryPedido = "SELECT * FROM pedido";
$stmtPedido = $db->prepare($queryPedido);
$stmtPedido->execute();
$pedido = $stmtPedido->fetchAll(PDO::FETCH_ASSOC);

?>

<?php if ($exito == '1') { ?>
    <div class="alerta exito">
        <p>Se ha creado correctamente</p>
    </div>
<?php } elseif ($exito == '2') { ?>
    <div class="alerta exito">
        <p>Se agregó el ítem correctamente</p>
    </div>
<?php } ?>

<main class="pedidos">
    <button class="boton-verde" onclick="window.location.href = '/pages/nuevo-pedido.php'">+ Agregar pedido</button>
    <?php if (!empty($pedido)) : ?>
        <?php foreach ($pedido as $pd) : ?>
            <section class="pedidos-seccion">
                <h1>Pedido <?php echo $pd['id_pedido']; ?></h1>
                <p>Cantidad - nombre ítem</p>
                <p>Área: Mesa <?php echo $pd['id_mesa']; ?></p>
                <p>Mesero: <?php echo $pd['id_mesero']; ?></p>
                <form method="POST">
                    <input type="hidden" name="id_pedido" value="<?php echo $pd['id_pedido']; ?>">
                    <button type="submit" name="agregar_insumo" class="boton-verde">Agregar insumo</button>
                </form>
            </section>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No se encontró ningún pedido</p>
    <?php endif; ?>
</main>

<script src="../app.js"></script>

<?php
incluirTemplate('footer');
?>