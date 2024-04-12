<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);
?>

<main class="personal">
<button class="personal-agregar">Agregar persona</button>
    <section class="personal-seccion" >
        <img src='../img/usuario.png' alt="Icono" class="img-mesa" />
        <p>Nombre y apellido</p>
        <p>Puesto </p>
        <button class="personal-borrar">X</button>
        <button class="personal-editar">...</button>
    </section>
</main>

<?php
incluirTemplate('footer');
?>