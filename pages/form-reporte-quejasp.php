<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);
?>

<main class="form-reporte-quejasp">
    <h2>Reporte de las quejas agrupadas por persona</h2>

    <form method="post">
        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" required>
        <div> </div>
        <label for="fecha_fin">Fecha de Fin:</label>
        <input type="date" name="fecha_fin" id="fecha_fin" required>

        <input type="submit" value="Generar Reporte" class="boton-verde">
    </form>
</main>

<?php
incluirTemplate('footer');
?>