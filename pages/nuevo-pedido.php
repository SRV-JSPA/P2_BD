<?php
require "../includes/database.php";
require '../includes/funciones.php';

$errores = [];
$db = conectarBD();

if (!isset($_SESSION)) {
    session_start();
}

$id = $_GET['id'] ?? null;
$id_persona = $_GET['idpersonal'] ?? null;
$id_personal = $_SESSION['id_personal'];



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($id_persona) && isset($id)) {
        $query = "SELECT rol FROM personal WHERE id_personal = $id_persona";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $rol = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($rol[0]['rol'] != 'Mesero') {
            $errores[] = 'Solo los meseros pueden crear un pedido';
        } else {
            $queryMesero = "SELECT id_mesero FROM mesero WHERE id_personal = $id_persona";
            $stmtMesero = $db->prepare($queryMesero);
            $stmtMesero->execute();
            $mesero = $stmtMesero->fetchAll(PDO::FETCH_ASSOC);
            $id_mesero = intval($mesero[0]['id_mesero']);
            
            $nit = $_POST['nit'];
            $nombre = $_POST['nombre'];
            $direccion = $_POST['direccion'];
            $fecha = $_POST['fecha'];

            if (!$nit) {
                $errores[] = "El nit es obligatorio o no es válido";
                error_log("Inicio de sesión: Se ha ingresado un usuario vacío o inválido.");
            }
        
            if (!$nombre) {
                $errores[] = "El nombre es obligatorio";
                error_log("Inicio de sesión: Se ha ingresado un password vacío.");
            }

            if (!$direccion) {
                $errores[] = "La direccion es obligatorio o no es válido";
                error_log("Inicio de sesión: Se ha ingresado un usuario vacío o inválido.");
            }
        
            if (!$fecha) {
                $errores[] = "La fecha es obligatorio";
                error_log("Inicio de sesión: Se ha ingresado un password vacío.");
            }

            $queryCliente = "INSERT INTO cliente (nit, nombre, direccion) VALUES ('$nit', '$nombre', '$direccion');";
            $stmtCliente = $db->prepare($queryCliente);
            $stmtCliente->execute();
            $cliente = $stmtCliente->fetchAll(PDO::FETCH_ASSOC);

            $query_id_cliente = "SELECT id_cliente FROM cliente WHERE nombre = '$nombre'";
            $stmt_id_cliente = $db->prepare($query_id_cliente);
            $stmt_id_cliente->execute();
            $id_cliente = $stmt_id_cliente->fetchAll(PDO::FETCH_ASSOC);
            $id_cliente = intval($id_cliente[0]['id_cliente']);

            $queryPedido = "INSERT INTO pedido (fecha, hora, id_mesa, id_mesero, id_cliente, subtotal) VALUES ('$fecha', CURRENT_TIME, $id, $id_mesero, $id_cliente, 0);";
            $stmt_query_pedido = $db->prepare($queryPedido);
            $stmt_query_pedido->execute();
            $pedido = $stmt_query_pedido->fetchAll(PDO::FETCH_ASSOC);

            $query_id_pedido = "SELECT id_pedido FROM pedido WHERE id_cliente = $id_cliente";
            $stmt_id_pedido = $db->prepare($query_id_pedido);
            $stmt_id_pedido->execute();
            $id_pedido = $stmt_id_pedido->fetchAll(PDO::FETCH_ASSOC);
            $id_pedido = intval($id_pedido[0]['id_pedido']);

            $query_detalle_pedido = "INSERT INTO detalle_pedido (id_pedido, id_item, cantidad) VALUES ($id_pedido, NULL, 0);";
            $stmt_query_detalle_pedido = $db->prepare($query_detalle_pedido);
            $stmt_query_detalle_pedido->execute();

            if ($stmt_query_detalle_pedido->rowCount() > 0) {
                header("Location: /pages/pedidos.php?success=1");
            }
        }
    } else {
        $query = "SELECT rol FROM personal WHERE id_personal = $id_personal";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $rol = $stmt->fetchAll(PDO::FETCH_ASSOC);


        if ($rol[0]['rol'] !== 'Mesero') {
            $errores[] = 'Solo los meseros pueden crear un pedido';
        } else {
            $queryMesero = "SELECT id_mesero FROM mesero WHERE id_personal = $id_personal";
            $stmtMesero = $db->prepare($queryMesero);
            $stmtMesero->execute();
            $mesero = $stmtMesero->fetchAll(PDO::FETCH_ASSOC);
            $id_mesero = intval($mesero[0]['id_mesero']);



            $nit = $_POST['nit'];
            $nombre = $_POST['nombre'];
            $direccion = $_POST['direccion'];
            $fecha = $_POST['fecha'];
            $id_mesa = $_POST['mesa'];

            if (!$nit) {
                $errores[] = "El nit es obligatorio o no es válido";
                error_log("Inicio de sesión: Se ha ingresado un usuario vacío o inválido.");
            }
        
            if (!$nombre) {
                $errores[] = "El nombre es obligatorio";
                error_log("Inicio de sesión: Se ha ingresado un password vacío.");
            }

            if (!$direccion) {
                $errores[] = "La direccion es obligatorio o no es válido";
                error_log("Inicio de sesión: Se ha ingresado un usuario vacío o inválido.");
            }
        
            if (!$fecha) {
                $errores[] = "La fecha es obligatorio";
                error_log("Inicio de sesión: Se ha ingresado un password vacío.");
            }

            if (!$id_mesa) {
                $errores[] = "El ID de la mesa es obligatorio";
                error_log("Inicio de sesión: Se ha ingresado un password vacío.");
            }


            $queryCliente = "INSERT INTO cliente (nit, nombre, direccion) VALUES ('$nit', '$nombre', '$direccion');";
            $stmtCliente = $db->prepare($queryCliente);
            $stmtCliente->execute();
            $cliente = $stmtCliente->fetchAll(PDO::FETCH_ASSOC);

            $query_id_cliente = "SELECT id_cliente FROM cliente WHERE nombre = '$nombre'";
            $stmt_id_cliente = $db->prepare($query_id_cliente);
            $stmt_id_cliente->execute();
            $id_cliente = $stmt_id_cliente->fetchAll(PDO::FETCH_ASSOC);
            $id_cliente = intval($id_cliente[0]['id_cliente']);

            $queryPedido = "INSERT INTO pedido (fecha, hora, id_mesa, id_mesero, id_cliente, subtotal) VALUES ('$fecha', CURRENT_TIME, $id_mesa, $id_mesero, $id_cliente, 0);";
            $stmt_query_pedido = $db->prepare($queryPedido);
            $stmt_query_pedido->execute();
            $pedido = $stmt_query_pedido->fetchAll(PDO::FETCH_ASSOC);

            $query_id_pedido = "SELECT id_pedido FROM pedido WHERE id_cliente = $id_cliente";
            $stmt_id_pedido = $db->prepare($query_id_pedido);
            $stmt_id_pedido->execute();
            $id_pedido = $stmt_id_pedido->fetchAll(PDO::FETCH_ASSOC);
            $id_pedido = intval($id_pedido[0]['id_pedido']);

            $query_detalle_pedido = "INSERT INTO detalle_pedido (id_pedido, id_item, cantidad) VALUES ($id_pedido, NULL, 0);";
            $stmt_query_detalle_pedido = $db->prepare($query_detalle_pedido);
            $stmt_query_detalle_pedido->execute();

            if ($stmt_query_detalle_pedido->rowCount() > 0) {
                header("Location: /pages/pedidos.php?success=1");
            }
        }
    }
}

incluirTemplate('header', $inicio = true);

?>



<main class="contenedor seccion contenido-centrado">
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endforeach; ?>
    <h1>Pedido</h1>

    <form class="formulario" method="POST">
        <fieldset>
            <legend>Información del cliente y pedido</legend>

            <label for="nit">Nit:</label>
            <input type="text" name="nit" placeholder="Nit" id="nit" required>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" placeholder="Nombre completo" id="nombre" required>

            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" placeholder="Dirección" id="direccion" required>

            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" placeholder="Fecha" id="fecha" required>

            <?php if (!isset($_GET['id'])) : ?>
                <label for="mesa">ID mesa:</label>
                <input type="number" name="mesa" placeholder="ID mesa" id="mesa" required>
            <?php endif; ?>

        </fieldset>

        <input type="submit" value="Registro" class="boton-verde">
    </form>
</main>



<?php
incluirTemplate('footer');
?>