<?php
require "../includes/database.php";
require '../includes/funciones.php';

$db = conectarBD();
incluirTemplate('header', $inicio = true);
?>

<main class="Bar">
    <center>
        <h1>Lista de Bebidas a Preparar</h1>
    </center>
    <section class="bar">
        <?php
        // Consulta para obtener los ítems pendientes en la tabla Detalle_Pedido
        $query = "SELECT dp.id_detalle_pedido, i.nombre, dp.cantidad, p.hora
                  FROM Detalle_Pedido dp
                  JOIN Item i ON dp.id_item = i.id_item
                  JOIN Pedido p ON dp.id_pedido = p.id_pedido
                  WHERE i.tipo_item = 'Bebida'
                  ORDER BY dp.id_detalle_pedido";

        try {
            $resultado = $db->query($query);
            if ($resultado->rowCount() > 0) {
                // Mostrar los ítems pendientes en la sección de Bebida
                while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class='fila'>";
                    echo "<p>ID: " . $fila['id_detalle_pedido'] . " - Nombre: " . $fila['nombre'] . " - Cantidad: " . $fila['cantidad'] ." - Hora: " . $fila['hora'] . "</p>";
                    echo "<input type='checkbox' class='check'>";
                    echo "</div>";
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
