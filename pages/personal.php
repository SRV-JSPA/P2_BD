<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);

if (!isset($_SESSION)) {
    session_start();
}


$exito = $_GET['success'] ?? null;


if ($exito !== false) {
    $_SESSION['exito_mostrado'] = true;
}

$db = conectarBD();


$query = "SELECT * FROM personal;";
$stmt = $db->prepare($query);
$stmt->execute();
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);





?>
<?php if ($exito == '1') { ?>
    <div class="alerta exito">
        <p>Se ha agregado correctamente</p>
    </div>
<?php } elseif ($exito == '2') { ?>
    <div class="alerta exito">
        <p>Se actualizó correctamente</p>
    </div>
<?php } elseif ($exito == '3') { ?>
    <div class="alerta exito">
        <p>Se eliminó correctamente</p>
    </div>
<?php } ?>
<main class="personal">
    <button class="personal-agregar" onclick="window.location.href = 'form-personal.php';">Agregar persona</button>

    <?php foreach ($datos as $dato) { ?>
        <section class="personal-seccion">
            <img src='../img/usuario.png' alt="Icono" class="img-mesa" />
            <p>Nombre y apellido: <?php echo $dato['nombre'] ?></p>
            <p>Puesto: <?php echo $dato['rol'] ?> </p>
            <button class="personal-borrar" data-id="<?php echo $dato['id_personal']; ?>">X</button>
            <button class="personal-editar" data-id="<?php echo $dato['id_personal']; ?>">...</button>
        </section>
    <?php } ?>
</main>

<script src="../app.js"></script>
<?php
incluirTemplate('footer');
?>