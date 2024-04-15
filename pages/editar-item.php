<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);

$errores = [];
$db = conectarBD();

$id = $_GET['id'] ?? null;

if(isset($id)){
    $query = "SELECT * FROM item WHERE id_item = $id";
    $stmt = $db->prepare($query);
    $stmt->execute();

    $item = $stmt->fetch(PDO::FETCH_ASSOC);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $tipo = $_POST['tipo'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    
    $precio = floatval($_POST['precio']);

    $query = "UPDATE item SET descripcion = '$descripcion', tipo_item = '$tipo', nombre = '$nombre', precio = $precio WHERE id_item = $id";
    $stmt = $db->prepare($query);
    $stmt->execute();
    if($stmt->rowCount() > 0){
        header('Location: /pages/insumos.php?success=3');
    }
}

?>

<main class="contenedor seccion contenido-centrado">
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endforeach; ?>
    <h1>Pedido</h1>

    <form class="formulario" method="POST">
        <fieldset>
            <legend>Información Item</legend>

            <label for="tipo">Tipo:</label>
            <input type="text" name="tipo" placeholder="Tipo" id="tipo" required value="<?php echo $item['tipo_item'] ?>" >

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" placeholder="Nombre" id="nombre"  value="<?php echo $item['nombre'] ?>" required>

            <label for="descripcion">Descripción:</label>
            <input type="text" name="descripcion" placeholder="Descripción" id="descripcion"  value="<?php echo $item['descripcion'] ?>" required>

            <label for="precio">Precio:</label>
            <input type="number" name="precio" placeholder="Precio" id="precio" step="0.01" min="0"  value="<?php echo $item['precio'] ?>" required>

        </fieldset>

        <input type="submit" value="Actualizar" class="boton-verde">
    </form>
</main>

<?php 
incluirTemplate('footer');
?>