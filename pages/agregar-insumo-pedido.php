<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);

$errores = [];

if (!isset($_SESSION)) {
    session_start();
}

$id_item = $_GET['idItem'] ?? null;
$id_pedido = $_GET['idPedido'] ?? null;
$boton_presionado = $_SESSION['agregar_insumo_click'];




$db = conectarBD();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cantidad = $_POST['cantidad'];

    if (!$cantidad) {
        $errores[] = "La cantidad es obligatoria";
    }

    if (empty($errores)) {

        if ($boton_presionado) {
            $query_detalle_pedido = "SELECT id_detalle_pedido FROM detalle_pedido WHERE id_pedido = $id_pedido";
            $stmt_query_detalle_pedido = $db->prepare($query_detalle_pedido);
            $stmt_query_detalle_pedido->execute();
            $detalle_pedido = $stmt_query_detalle_pedido->fetchAll(PDO::FETCH_ASSOC);
            $id_ultimo = end($detalle_pedido);
            $id_detalle_pedido = $id_ultimo['id_detalle_pedido'];


            $query = "UPDATE detalle_pedido SET id_item = $id_item, cantidad = $cantidad WHERE id_pedido = $id_pedido AND id_detalle_pedido = $id_detalle_pedido";
            $stmt = $db->prepare($query);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                header('Location: /pages/pedidos.php?success=2');
            }
        } else {
            $query = "INSERT INTO detalle_pedido (id_pedido, id_item, cantidad) VALUES ($id_pedido, NULL, 0);";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $id_detalle_pedido_final = intval($db->lastInsertId());

            $query = "UPDATE detalle_pedido SET id_item = $id_item, cantidad = $cantidad WHERE id_pedido = $id_pedido AND id_detalle_pedido = $id_detalle_pedido_final";
            $stmt = $db->prepare($query);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                header('Location: /pages/pedidos.php?success=2');
            }
        }
    }
}

?>

<main class="contenedor seccion contenido-centrado">
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endforeach; ?>
    <h1>Item</h1>

    <form class="formulario" method="POST">
        <fieldset>
            <legend>Información del Item para el pedido</legend>

            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" placeholder="Cantidad" id="cantidad" required>

        </fieldset>

        <input type="submit" value="Agregar" class="boton-verde">
    </form>
</main>

<?php
incluirTemplate('footer');
?>