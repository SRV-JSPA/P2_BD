<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);

$db = conectarBD();

$exito = $_GET['success'] ?? NULL;

if (!isset($_SESSION)) {
    session_start();
}
$bandera_pdf = $_SESSION['descarga_exitosa'] ?? null;


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
$pedidos = $stmtPedido->fetchAll(PDO::FETCH_ASSOC);

?>

<?php if ($exito == '1') { ?>
    <div class="alerta exito">
        <p>Se ha creado correctamente</p>
    </div>
<?php } elseif ($exito == '2') { ?>
    <div class="alerta exito">
        <p>Se agregó el ítem correctamente</p>
    </div>
<?php } elseif ($exito == '3') { ?>
    <div class="alerta exito">
        <p>Se cerró la cuenta correctamente</p>
    </div>
<?php } ?>

<main class="pedidos">
    <button class="boton-verde" onclick="window.location.href = '/pages/nuevo-pedido.php'">+ Agregar pedido</button>
    <?php if (!empty($pedidos)) : ?>
        <?php foreach ($pedidos as $pd) : ?>
            <section class="pedidos-seccion">
                <h1>Pedido <?php echo $pd['id_pedido']; ?></h1>
                <?php 
                $query_detalle_pedido = "SELECT * FROM detalle_pedido WHERE id_pedido = :id_pedido;";
                $stmt_detalle_pedido = $db->prepare($query_detalle_pedido);
                $stmt_detalle_pedido->bindParam(':id_pedido', $pd['id_pedido']);
                $stmt_detalle_pedido->execute();
                $detalle_pedidos = $stmt_detalle_pedido->fetchAll(PDO::FETCH_ASSOC);
                
               
                $total_general = 0;
                ?>

                <?php foreach($detalle_pedidos as $dpd) : ?>
                    <?php 
                    $query_item = "SELECT * FROM item WHERE id_item = :id_item";
                    $stmt_query_item = $db->prepare($query_item);
                    $stmt_query_item->bindParam(':id_item', $dpd['id_item']);
                    $stmt_query_item->execute();
                    $item_info = $stmt_query_item->fetch(PDO::FETCH_ASSOC);
                    
                    
                    if (isset($dpd['cantidad']) && is_numeric($dpd['cantidad']) && isset($item_info['precio']) && is_numeric($item_info['precio'])) {
                        $total_detalle = $dpd['cantidad'] * floatval($item_info['precio']);
                    } else {
                        $total_detalle = 0; 
                    }
                    $total_general += $total_detalle; 

                    $query_cantidad = "UPDATE pedido SET subtotal = $total_general WHERE id_pedido = :id_pedido";
                    $stmt_query_cantidad = $db->prepare($query_cantidad);
                    $stmt_query_cantidad->bindParam(':id_pedido', $pd['id_pedido']);
                    $stmt_query_cantidad->execute();

                    $query_pedido_info = "SELECT * FROM pedido WHERE id_pedido = :id_pedido";
                    $stmt_pedido_info = $db->prepare($query_pedido_info);
                    $stmt_pedido_info->bindParam(':id_pedido', $pd['id_pedido']);
                    $stmt_pedido_info->execute();
                    $pedido_info = $stmt_pedido_info->fetch(PDO::FETCH_ASSOC);
                    $total_propina = floatval($pedido_info['total']);
                    
                    ?>
                    
                    <?php if (is_array($dpd) && isset($dpd['cantidad']) && is_array($item_info) && isset($item_info['nombre'])) : ?>
                    <p><?php echo $dpd['cantidad']; ?> - <?php echo $item_info['nombre']; ?> - Total: <?php echo $total_detalle; ?></p>
                    <?php endif; ?>

                    

                <?php endforeach; ?>
                
                


                <p>-------------- TOTAL GENERAL --------------</p>
                <p>Total general: <?php echo $total_general; ?></p>
                <p>Área: Mesa <?php echo $pd['id_mesa']; ?></p>
                <p>Mesero: <?php echo $pd['id_mesero']; ?></p>
                <form method="POST">
                    <input type="hidden" name="id_pedido" value="<?php echo $pd['id_pedido']; ?>">
                    <button type="submit" name="agregar_insumo" class="boton-verde">Agregar insumo</button>
                </form>
                <button onclick="window.location.href = '/pages/pdf-pedido.php?id=<?php echo $pd['id_pedido']; ?>'" class="boton-verde">Generar vista previa de Pedido</button>
                <button onclick="window.location.href = '/pages/cerrar-cuenta.php?id=<?php echo $pd['id_pedido'];  ?>'"   class="boton-verde">Cerrar la cuenta</button>
                <button onclick="window.location.href = '/pages/pago.php?id=<?php echo $pd['id_pedido']; ?>&total=<?php echo $total_propina  ?>'"  class="boton-verde">Ingresar pago</button>
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
