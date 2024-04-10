<?php

require "includes/database.php";
require 'includes/funciones.php';
$db = conectarBD();

$errores = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user = $_POST["user"];
    $password = $_POST["password"];
    $id_personal = $_POST['id_personal'];

    $errores = [];
    if (!$user) {
        $errores[] = "El email es obligatorio o no es válido";
    }
    if (!$password) {
        $errores[] = "El Password es obligatorio";
    }
    if (!$id_personal) {
        $errores[] = "El id personal es obligatorio";
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    if (empty($errores)) {

        $verif = "SELECT * FROM usuarios WHERE usuario = ?";
        $statement = $db->prepare($verif);
        $statement->execute([$user]);

        if ($statement->rowCount() > 0) {
            $errores[] = "El usuario ya existe";
        } else {
            $query = "INSERT INTO usuarios (usuario, contrasena, id_personal) VALUES ( '{$user}', '{$passwordHash}', '{$id_personal}' );";
            $statement = $db->prepare($query);
            $statement->execute();
            header("Location: /");
        }
    }
}



incluirTemplate("header");
?>
<main class="contenedor seccion contenido-centrado">
    <?php
    foreach ($errores as $error) { ?>
        <div class="alerta error">
            <?php echo "" . $error . ""; ?>
        </div>
    <?php } ?>
    <h1>Registro</h1>



    <form class="formulario" method="POST">
        <fieldset class="campos" >
            <legend>Usuario, Contraseña y ID personal</legend>

            <label for="user">Usuario</label>
            <input type="text" name="user" placeholder="Tu Usuario" id="user">

            <label for="password">Contraseña</label>
            <input type="password" name="password" placeholder="Tu Contraseña" id="password">

            <label for="id_personal">ID personal</label>
            <input type="number" name="id_personal" placeholder="Tu ID personal" id="id_personal">
        </fieldset>

        <input type="submit" value="Registro" class="boton-verde">
        <p>Si ya tiene un usuario, entonces inicie sesión <a href="registro.php" class='enlace-registro'>Aquí</a></p>
</main>

<?php

incluirTemplate("footer");
?>