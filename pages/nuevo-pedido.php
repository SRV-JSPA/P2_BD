<?php
require "../includes/database.php";
require '../includes/funciones.php';

$errores = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){

}

incluirTemplate('header', $inicio = true);

?>

<main class="contenedor seccion contenido-centrado" >
<?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endforeach; ?>
    <h1>Registro</h1>

    <form class="formulario" method="POST"> 
        <fieldset>
            <legend>Información del cliente y pedido</legend>

            <label for="nit">Nit:</label>
            <input type="text" name="nit" placeholder="Nit" id="nit" required>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" placeholder="Nombre completo" id="nombre" required>

            
            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" placeholder="Dirección" id="direccion" required>

            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" placeholder="Fecha" id="fecha" required>
        </fieldset>

        <input type="submit" value="Registro" class="boton-verde">
    </form>
</main>



<?php 
    incluirTemplate('footer');
?>