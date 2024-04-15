<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);
$db = conectarBD();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_inicio = $_POST["fecha_inicio"];
    $fecha_fin = $_POST["fecha_fin"];

    try {
        $stmt = $db->prepare("SELECT * FROM platos_mas_pedidos(:fecha_i, :fecha_f)");
        $stmt->bindParam(':fecha_i', $fecha_inicio);
        $stmt->bindParam(':fecha_f', $fecha_fin);
        $stmt->execute();

        $platos_mas_pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<main class="form-reporte-platos">
    <h2>Reporte de Platos Más Pedidos</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" required>
        <div> </div>
        <label for="fecha_fin">Fecha de Fin:</label>
        <input type="date" name="fecha_fin" id="fecha_fin" required>

        <input type="submit" value="Generar Reporte" class="boton-verde">
    </form>

    <?php if (isset($platos_mas_pedidos) && count($platos_mas_pedidos) > 0): ?>
        <table style='border-collapse: collapse; width: 100%;'>
            <tr>
                <th style='border: 1px solid black; padding: 8px; background-color: darkgreen; color: white;'>ID del Plato</th>
                <th style='border: 1px solid black; padding: 8px; background-color: darkgreen; color: white;'>Nombre del Item</th>
                <th style='border: 1px solid black; padding: 8px; background-color: darkgreen; color: white;'>Cantidad Pedida</th>
            </tr>
            <?php foreach ($platos_mas_pedidos as $plato): ?>
                <tr>
                    <td style='border: 1px solid black; padding: 8px;'><?php echo $plato['id_item']; ?></td>
                    <td style='border: 1px solid black; padding: 8px;'><?php echo $plato['nombre_item']; ?></td>
                    <td style='border: 1px solid black; padding: 8px;'><?php echo $plato['cantidad_pedida']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <?php if(isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php else: ?>
            <p>No se encontraron datos.</p>
        <?php endif; ?>
    <?php endif; ?>
</main>

<?php incluirTemplate('footer'); ?>