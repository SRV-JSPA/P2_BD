<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);
$db = conectarBD();
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

    <?php
    
    $db->exec("
        CREATE OR REPLACE FUNCTION plato_mas_pedido_prueba13(fecha_i DATE, fecha_f DATE)
        RETURNS TABLE (id_item INT, cantidad_pedida BIGINT) AS $$
        DECLARE
            v_fecha_inicio DATE := fecha_i;
            v_fecha_fin DATE := fecha_f;
        BEGIN
            RETURN QUERY
            SELECT dpd.id_item, SUM(dpd.cantidad) AS cantidad_pedida
            FROM detalle_pedido dpd
            INNER JOIN pedido pd ON pd.id_pedido = dpd.id_pedido
            WHERE pd.fecha BETWEEN v_fecha_inicio AND v_fecha_fin
            GROUP BY dpd.id_item
            ORDER BY cantidad_pedida DESC;
        END;
        $$ LANGUAGE plpgsql;
    ");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fecha_inicio = $_POST["fecha_inicio"];
        $fecha_fin = $_POST["fecha_fin"];

        try {
            $stmt = $db->prepare("SELECT * FROM plato_mas_pedido_prueba13(:fecha_i, :fecha_f)");
            $stmt->bindParam(':fecha_i', $fecha_inicio);
            $stmt->bindParam(':fecha_f', $fecha_fin);
            $stmt->execute();

            $platos_mas_pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($platos_mas_pedidos) > 0) {
                echo "<table style='border-collapse: collapse; width: 100%;'>";
                echo "<tr><th style='border: 1px solid black; padding: 8px; background-color: darkgreen; color: white;'>ID del Plato</th><th style='border: 1px solid black; padding: 8px; background-color: darkgreen; color: white;'>Cantidad Pedida</th></tr>";
                foreach ($platos_mas_pedidos as $plato) {
                    echo "<tr><td style='border: 1px solid black; padding: 8px;'>" . $plato['id_item'] . "</td><td style='border: 1px solid black; padding: 8px;'>" . $plato['cantidad_pedida'] . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "No se encontraron datos.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    ?>
</main>

<?php incluirTemplate('footer'); ?>

