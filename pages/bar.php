<?php
require "../includes/database.php";
require '../includes/funciones.php';

$db = conectarBD();
incluirTemplate('header', $inicio = true);
?>


<main class="Bar">
    <center>
        <h1>Lista de bebidas a preparar</h1>
    </center>
    <section class="bar">
        <?php
        // Consulta para obtener los ítems pendientes en la tabla Detalle_Pedido
        $query = "SELECT dp.id_detalle_pedido, i.nombre, dp.cantidad
                  FROM Detalle_Pedido dp
                  JOIN Item i ON dp.id_item = i.id_item
                  WHERE dp.id_pedido IN (
                      SELECT id_pedido
                      FROM Pedido
                      WHERE id_pedido = (SELECT MAX(id_pedido) FROM Pedido)
                  )
                  AND i.tipo_item = 'Bebida'
                  ORDER BY dp.id_detalle_pedido";

        try {
            $resultado = $db->query($query);
            if ($resultado->rowCount() > 0) {
                // Mostrar los ítems pendientes en la sección de Bar
                while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                    echo "<p>ID: " . $fila['id_detalle_pedido'] . " - Nombre: " . $fila['nombre'] . " - Cantidad: " . $fila['cantidad'] . "</p>";
                }
            } else {
                echo "<p>No hay bebidas pendientes.</p>";
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