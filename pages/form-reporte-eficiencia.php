<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);
$db = conectarBD();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $stmt = $db->prepare("SELECT * FROM reporte_eficiencia_meseros()");
        $stmt->execute();

        $reporte_eficiencia_meseros = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<main class="form-reporte-platos">
    <h2>Reporte de eficiencia de meseros</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="submit" value="Generar Reporte" class="boton-verde">
    </form>

    <?php if (isset($reporte_eficiencia_meseros) && count($reporte_eficiencia_meseros) > 0): ?>
        <table style='border-collapse: collapse; width: 100%;'>
            <tr>
                <th style='border: 1px solid black; padding: 8px; background-color: darkgreen; color: white;'>Nombre del Mesero</th>
                <th style='border: 1px solid black; padding: 8px; background-color: darkgreen; color: white;'>Mes y Año de la Encuesta</th>
                <th style='border: 1px solid black; padding: 8px; background-color: darkgreen; color: white;'>Promedio de Amabilidad</th>
                <th style='border: 1px solid black; padding: 8px; background-color: darkgreen; color: white;'>Promedio de Exactitud</th>
            </tr>
            <?php foreach ($reporte_eficiencia_meseros as $eficiencia): ?>
                <tr>
                    <td style='border: 1px solid black; padding: 8px;'><?php echo $eficiencia['nombre_mesero']; ?></td>
                    <td style='border: 1px solid black; padding: 8px;'><?php echo $eficiencia['mes_encuesta']; ?></td>
                    <td style='border: 1px solid black; padding: 8px;'><?php echo $eficiencia['promedio_amabilidad']; ?></td>
                    <td style='border: 1px solid black; padding: 8px;'><?php echo $eficiencia['promedio_exactitud']; ?></td>
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