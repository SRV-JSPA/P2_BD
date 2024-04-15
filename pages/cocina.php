<?php
require "../includes/database.php";
require '../includes/funciones.php';

$db = conectarBD();
incluirTemplate('header', $inicio = true);
?>

<main class="Cocina">
    <center>
        <h1>Lista de Comidas a Preparar</h1>
    </center>
    <section class="cocina">
        <?php
        // Consulta para obtener los ítems pendientes en la tabla Detalle_Pedido
        $query = "SELECT dp.id_detalle_pedido, i.nombre, dp.cantidad, p.hora
                  FROM Detalle_Pedido dp
                  JOIN Item i ON dp.id_item = i.id_item
                  JOIN Pedido p ON dp.id_pedido = p.id_pedido
                  WHERE i.tipo_item = 'Platillo'
                  ORDER BY dp.id_detalle_pedido";

        try {
            $resultado = $db->query($query);
            if ($resultado->rowCount() > 0) {
                // Mostrar los ítems pendientes en la sección de Cocina
                while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class='cocina-item'>";
                    echo "<p><strong>ID:</strong> " . $fila['id_detalle_pedido'] . "</p>";
                    echo "<p><strong>Nombre:</strong> " . $fila['nombre'] . "</p>";
                    echo "<p><strong>Cantidad:</strong> " . $fila['cantidad'] . "</p>";
                    echo "<p><strong>Hora:</strong> " . $fila['hora'] . "</p>";
                    ?>
                    <input type='checkbox' class='check'>";
                    <?php
                    echo "</div>";
                }
            } else {
                echo "<p>No hay comidas pendientes.</p>";
            }
        } catch (PDOException $e) {
            echo "Error al ejecutar la consulta: " . $e->getMessage();
            exit;
        }
        ?>
    </section>
</main>


<?php
incluirTemplate('footer');
?>
