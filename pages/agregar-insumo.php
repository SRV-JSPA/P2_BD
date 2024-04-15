<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);

$db = conectarBD();

$id_pedido = $_GET['id'] ?? null;



$query = "SELECT * FROM item;";
$stmt = $db->prepare($query);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<main class="contenedor-item seccion-item">
        <h1>Menú del restaurante</h1>
        
        <a href="/pages/nuevo-item.php" class="boton boton-verde">Nuevo Item</a>

        <table class="items">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
            <?php foreach($items as $row): ?>
                <tr>
                    <td><?php echo $row['id_item']; ?></td>
                    <td><?php echo $row['tipo_item']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td> <?php echo $row['descripcion']; ?></td>
                    <td>$ <?php echo $row['precio']; ?></td>
                    <td>
                    <button class="boton-celeste-block" onclick="window.location.href = '/pages/agregar-insumo-pedido.php?idItem=<?php echo $row['id_item']; ?>&idPedido=<?php echo $id_pedido; ?>'">Agregar al pedido</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

<?php 
incluirTemplate('footer')
?>