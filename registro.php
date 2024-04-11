<?php

require "includes/database.php";
require 'includes/funciones.php';
$db = conectarBD();

$errores = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user = $_POST["user"];
    $password = $_POST["password"];

    $errores = [];
    if (!$user) {
        $errores[] = "El email es obligatorio o no es válido";
    }
    if (!$password) {
        $errores[] = "El Password es obligatorio";
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    if (empty($errores)) {

        $verif = "SELECT * FROM usuarios WHERE usuario = ?";
        $statement = $db->prepare($verif);
        $statement->execute([$user]);

        if ($statement->rowCount() > 0) {
            $errores[] = "El usuario ya existe";
        } else {
            $query = "INSERT INTO usuarios (usuario, contrasena) VALUES ( '{$user}', '{$passwordHash}' );";
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
        <fieldset>
            <legend>Usuario y Contraseña</legend>

            <label for="user">Usuario</label>
            <input type="text" name="user" placeholder="Tu Usuario" id="user">

            <label for="password">Contraseña</label>
            <input type="password" name="password" placeholder="Tu Contraseña" id="password">
        </fieldset>

        <input type="submit" value="Registro" class="boton-verde">
        <p>Si ya tiene un usuario, entonces inicie sesión <a href="index.php" class='enlace-registro'>Aquí</a></p>
</main>

<?php

incluirTemplate("footer");
?>