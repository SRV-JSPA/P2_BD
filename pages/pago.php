<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);

$errores = [];

$id_pago = $_GET['id'] ?? null;
$total = $_GET['total'] ?? null;

$db = conectarBD();

$query_pago = "INSERT INTO pago (id_pedido, monto_total) VALUES ($id_pago, $total);";
$stmt_pago = $db->prepare($query_pago);
$stmt_pago->execute();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $cantidad_personas = $_POST['cantidadPartes'];

    if(isset($cantidad_personas)){

    } else {
        
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

        <label for="rol">Rol:</label>
        <select name="rol" id="rol"  onchange="mostrarOcultarCampoPago()" required>
            <option value="">Selecciona un rol</option>
            <option value="Pago único">Pago Único</option>
            <option value="Por partes">Por Partes</option>
        </select>

        <div id="campoExtra" class="campoPagoPartes">
            <label for="cantidadPartes">Cantidad de Personas:</label>
            <input type="number" id="cantidadPartes" name="cantidadPartes" min="1" value="1" required>
        </div>
    </fieldset>

    <input type="submit" value="Registro" class="boton-verde">
</form>
</main>

<script src="../app.js" ></script>

<?php 
incluirTemplate('footer');
?>