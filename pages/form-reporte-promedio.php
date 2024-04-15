<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);
$db = conectarBD();

function formatTime($minutes) {
    $hours = intdiv($minutes, 60);
    $remainingMinutes = $minutes % 60;
    return sprintf("%d hora(s) %d minutos", $hours, $remainingMinutes);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_inicio = $_POST["fecha_inicio"];
    $fecha_fin = $_POST["fecha_fin"];

    try {
        $stmt = $db->prepare("SELECT * FROM reporte_tiempo_comida(:fecha_inicio, :fecha_fin)");
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);
        $stmt->execute();

        $reporte_tiempo_comida = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<main class="form-reporte-platos">
    <h2>Reporte de Promedio de tiempo en que se tardan los clientes en comer</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" required>
        <div> </div>
        <label for="fecha_fin">Fecha de Fin:</label>
        <input type="date" name="fecha_fin" id="fecha_fin" required>

        <input type="submit" value="Generar Reporte" class="boton-verde">
    </form>

    <?php if (isset($reporte_tiempo_comida) && count($reporte_tiempo_comida) > 0): ?>
        <table style='border-collapse: collapse; width: 100%;'>
            <tr>
                <th style='border: 1px solid black; padding: 8px; background-color: darkgreen; color: white;'>Capacidad Mesa</th>
                <th style='border: 1px solid black; padding: 8px; background-color: darkgreen; color: white;'>Promedio Tiempo</th>
            </tr>
            <?php foreach ($reporte_tiempo_comida as $tiempo): ?>
                <tr>
                    <td style='border: 1px solid black; padding: 8px;'><?php echo $tiempo['cantidad_personas']; ?></td>
                    <td style='border: 1px solid black; padding: 8px;'><?php echo formatTime($tiempo['promedio_minutos']); ?></td>
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