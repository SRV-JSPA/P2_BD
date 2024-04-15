<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);

$errores = [];

$db = conectarBD();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $tipo = $_POST['tipo'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    
    $precio = floatval($_POST['precio']);

    $query = "INSERT INTO item (tipo_item, nombre, descripcion, precio) VALUES ('$tipo', '$nombre', '$descripcion', $precio); ";
    $stmt = $db->prepare($query);
    $stmt->execute();
    if($stmt->rowCount() > 0){
        header('Location: /pages/insumos.php?success=1');
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
            <input type="text" name="tipo" placeholder="Tipo" id="tipo" required>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" placeholder="Nombre" id="nombre" required>

            <label for="descripcion">Descripción:</label>
            <input type="text" name="descripcion" placeholder="Descripción" id="descripcion" required>

            <label for="precio">Precio:</label>
            <input type="number" name="precio" placeholder="Precio" id="precio" step="0.01" min="0"  required>

        </fieldset>

        <input type="submit" value="Registro" class="boton-verde">
    </form>
</main>

<?php
incluirTemplate('footer')
?>