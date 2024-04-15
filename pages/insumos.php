<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);

$exito = $_GET['success'] ?? null;


$db = conectarBD();

$query = "SELECT * FROM item;";
$stmt = $db->prepare($query);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php if ($exito == '1') { ?>
    <div class="alerta exito">
        <p>Se ha creado correctamente</p>
    </div>
<?php } elseif ($exito == '2') { ?>
    <div class="alerta exito">
        <p>Se ha eliminado correctamente</p>
    </div>
<?php }elseif ($exito == '3') { ?>
    <div class="alerta exito">
        <p>Se ha actualizado correctamente</p>
    </div>
<?php }?>

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
            <?php foreach ($items as $row) : ?>
                <tr>
                    <td><?php echo $row['id_item']; ?></td>
                    <td><?php echo $row['tipo_item']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td> <?php echo $row['descripcion']; ?></td>
                    <td>$ <?php echo $row['precio']; ?></td>
                    <td>
                        <button class="boton-rojo-block" onclick="window.location.href = '/pages/eliminar-item.php?id=<?php echo $row['id_item']; ?>'">Eliminar</button>
                        <button class="boton-purpura-block" onclick="window.location.href = '/pages/editar-item.php?id=<?php echo $row['id_item']; ?>'">Actualizar</button>
                        
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php
incluirTemplate('footer');
?>