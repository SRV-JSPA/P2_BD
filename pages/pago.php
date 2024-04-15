<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);

$errores = [];

$id_pago = $_GET['id'] ?? null;
$total = $_GET['total'] ?? null;


$db = conectarBD();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $query_pago = "INSERT INTO pago (id_pedido, monto_total) VALUES ($id_pago, $total);";
    $stmt_pago = $db->prepare($query_pago);
    $stmt_pago->execute();
    $id_pago_insertado = $db->lastInsertId();

    $query_cliente = "SELECT id_cliente FROM pedido WHERE id_pedido = $id_pago";
    $stmt_cliente = $db->prepare($query_cliente);
    $stmt_cliente->execute();
    $cliente = $stmt_cliente->fetch(PDO::FETCH_ASSOC);
    $id_cliente = $cliente['id_cliente'];

    $cantidad_personas = intval($_POST['cantidadPartes']);
    $metodo = $_POST['metodo'];
    

    if ($cantidad_personas > 0) {
        $total_personas = $total / $cantidad_personas;
        $query_contribución = "INSERT INTO contribucionpago (id_pago, id_cliente, monto_contribucion) VALUES ($id_pago_insertado, $id_cliente, $total_personas);";
        $stmt_contribución = $db->prepare($query_contribución);
        $stmt_contribución->execute();
        $id_contribucion_insertado = $db->lastInsertId();

        $query_metodo_pago = "INSERT INTO MetodoPago (id_contribucion, metodo_pago, monto) VALUES ($id_contribucion_insertado, '$metodo', $total );";
        $stmt_metodo_pago = $db->prepare($query_metodo_pago);
        $stmt_metodo_pago->execute();
        if ($stmt_metodo_pago->rowCount() > 0) {
            header("Location: /pages/factura.php?idPedido={$id_pago}");
        }

    } else {
        $query_metodo_pago = "INSERT INTO MetodoPago (id_contribucion, metodo_pago, monto) VALUES (1, '$metodo', $total );";
        $stmt_metodo_pago = $db->prepare($query_metodo_pago);
        $stmt_metodo_pago->execute();
        if ($stmt_metodo_pago->rowCount() > 0) {
            header("Location: /pages/factura.php?idPedido={$id_pago}");
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
    <h1>Pago</h1>

    <form class="formulario" method="POST">
        <fieldset>
            <legend>Información del Pago</legend>

            <label for="rol">Pago:</label>
            <select name="rol" id="rol" onchange="mostrarOcultarCampoPago()" required>
                <option value="">Selecciona una opción</option>
                <option value="Pago único">Pago Único</option>
                <option value="Por partes">Por Partes</option>
            </select>

            <div id="campoExtra" class="campoPagoPartes">
                <label for="cantidadPartes">Cantidad de Personas:</label>
                <input type="number" id="cantidadPartes" name="cantidadPartes" min="0" value="0" required>
            </div>

            <label for="metodo">Método:</label>
            <select name="metodo" id="metodo" required>
                <option value="">Selecciona un método de pago</option>
                <option value="efectivo">Efectivo</option>
                <option value="tarjeta">Tarjeta</option>
            </select>
        </fieldset>

        <input type="submit" value="Registro" class="boton-verde">
    </form>
</main>

<script src="../app.js"></script>

<?php
incluirTemplate('footer');
?>