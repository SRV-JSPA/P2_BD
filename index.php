<?php

require "includes/database.php";
require 'includes/funciones.php';

$db = conectarBD();

$errores = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = $_POST["user"];
    $password = $_POST["password"];

    if (!$user) {
        $errores[] = "El user es obligatorio o no es válido";
    }

    if (!$password) {
        $errores[] = "El Password es obligatorio";
    }

    if (empty($errores)) {
        try {
            
            $query = "SELECT * FROM usuarios WHERE usuario = '{$user}';";
            $stmt = $db->prepare($query);
            $stmt->execute();

            
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                
                if (password_verify($password, $usuario['contraseña'])) {
                    
                    session_start();

                    
                    $_SESSION["usuario"] = $usuario["email"];
                    $_SESSION["login"] = true;

                    header("Location: /pages");
                    exit; 
                } else {
                    $errores[] = "El password es incorrecto";
                }
            } else {
                $errores[] = "El usuario no existe";
            }
        } catch (PDOException $e) {
            die('Error al ejecutar la consulta: ' . $e->getMessage());
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
    <h1>Iniciar Sesión</h1>



    <form class="formulario" method="POST">
        <fieldset>
            <legend>Usuario y Contraseña</legend>

            <label for="user">Usuario</label>
            <input type="text" name="user" placeholder="Tu Usuario" id="user">

            <label for="password">Contraseña</label>
            <input type="password" name="password" placeholder="Tu Contraseña" id="password">
        </fieldset>

        <input type="submit" value="Iniciar Sesión" class="boton-verde">
        <a href="registro.php" class="boton-gris">Registro</a>
</main>

<?php

incluirTemplate("footer");
?>