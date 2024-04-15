<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);
$db = conectarBD();

function pgArrayToPhp($dbArray) {
    $dbArray = trim($dbArray, "{}");
    $elements = explode(",", $dbArray);
    $elements = array_map(function($value) {
        return trim($value, "\"");
    }, $elements);

    return $elements;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_inicio = $_POST["fecha_inicio"];
    $fecha_fin = $_POST["fecha_fin"];

    try {
        $stmt = $db->prepare("SELECT * FROM reporte_quejas_por_persona(:fecha_inicio, :fecha_fin)");
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);
        $stmt->execute();

        $reporte_quejas_por_persona = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<main class="form-reporte-platos">
    <div >
    <h2>Reporte de las quejas agrupadas por persona</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" required>
        <div> </div>
        <label for="fecha_fin">Fecha de Fin:</label>
        <input type="date" name="fecha_fin" id="fecha_fin" required>

        <input type="submit" value="Generar Reporte" class="boton-verde">
    </form>
     </div >

    <?php if (isset($reporte_quejas_por_persona) && count($reporte_quejas_por_persona) > 0): ?>
        <table style='border-collapse: collapse; width: 100%;'>
            <tr>
                <th style='border: 1px solid black; padding: 8px; background-color: darkgreen; color: white;'>ID del Cliente</th>
                <th style='border: 1px solid black; padding: 8px; background-color: darkgreen; color: white;'>Nombre del Cliente</th>
                <th style='border: 1px solid black; padding: 8px; background-color: darkgreen; color: white;'>Número de Quejas</th>
                <th style='border: 1px solid black; padding: 8px; background-color: darkgreen; color: white;'>Motivos</th>
            </tr>
            <?php foreach ($reporte_quejas_por_persona as $qpersona): ?>
                <tr>
                    <td style='border: 1px solid black; padding: 8px;'><?php echo $qpersona['id_cliente']; ?></td>
                    <td style='border: 1px solid black; padding: 8px;'><?php echo $qpersona['nombre_cliente']; ?></td>
                    <td style='border: 1px solid black; padding: 8px;'><?php echo $qpersona['numero_quejas']; ?></td>
                    <td style='border: 1px solid black; padding: 8px;'><?php 
                    $motivosArray = pgArrayToPhp($qpersona['motivos']);
                    echo implode(", ", $motivosArray); ?></td>
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