<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);

if (!isset($_SESSION)) {
    session_start();
}


$exitoMostrado = isset($_SESSION['exito_mostrado']) ? $_SESSION['exito_mostrado'] : false;


$exito = $exitoMostrado ? false : (isset($_GET["success"]) ? $_GET["success"] : false);


if ($exito !== false) {
    $_SESSION['exito_mostrado'] = true;
}

$db = conectarBD();


$query = "SELECT * FROM personal;";
$stmt = $db->prepare($query);
$stmt->execute();
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>
<?php if ($exito = 1) { ?>
        <div class="alerta exito">
            <p>Se ha agregado correctamente</p>
        </div>
    <?php }else { ?>
        <div class="alerta exito">
            <p>No se pudo agregar de forma exitosa</p>
        </div>
     <?php } ?>   
<main class="personal">
    <button class="personal-agregar" onclick="window.location.href = 'form-personal.php';">Agregar persona</button>

    <?php foreach ($datos as $dato) { ?>
        <section class="personal-seccion">
            <img src='../img/usuario.png' alt="Icono" class="img-mesa" />
            <p>Nombre y apellido: <?php echo $dato['nombre'] ?></p>
            <p>Puesto: <?php echo $dato['rol'] ?> </p>
            <button class="personal-borrar">X</button>
            <button class="personal-editar" onclick="window.location.href = 'editar-personal.php';">...</button>
        </section>
    <?php } ?>
</main>

<script src="../app.js" ></script>
<?php
incluirTemplate('footer');
?>