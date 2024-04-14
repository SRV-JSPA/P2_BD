<?php

require "includes/database.php";
require 'includes/funciones.php';

$db = conectarBD();

$errores = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = $_POST["user"];
    $password = $_POST["password"];

    if (!$user) {
        $errores[] = "El usuario es obligatorio o no es válido";
        error_log("Inicio de sesión: Se ha ingresado un usuario vacío o inválido.");
    }

    if (!$password) {
        $errores[] = "El Password es obligatorio";
        error_log("Inicio de sesión: Se ha ingresado un password vacío.");
    }

    if (empty($errores)) {
        try {
            $query = "SELECT u.usuario, u.contrasena, per.rol, u.id_personal FROM usuarios AS u INNER JOIN personal AS per ON u.id_personal = per.id_personal WHERE u.usuario = ?";
            $stmt = $db->prepare($query);
            $stmt->bindParam(1, $user, PDO::PARAM_STR);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                if (password_verify($password, $usuario['contrasena'])) {
                    session_start();
                    $_SESSION["usuario"] = $usuario["usuario"];
                    $_SESSION["rol"] = $usuario["rol"];
                    $_SESSION['id_personal'] = $usuario["id_personal"];
                    $_SESSION["login"] = true;
                    
                    error_log("Inicio de sesión exitoso para el usuario: {$user}");
                    
                    header("Location: /pages");
                    exit;
                } else {
                    if ($password === $usuario['contrasena']) {
                        $hash = password_hash($password, PASSWORD_DEFAULT);
                        $updateQuery = "UPDATE usuarios SET contrasena = ? WHERE id_personal = ?";
                        $updateStmt = $db->prepare($updateQuery);
                        $updateStmt->bindParam(1, $hash, PDO::PARAM_STR);
                        $updateStmt->bindParam(2, $usuario['id_personal'], PDO::PARAM_INT);
                        $updateStmt->execute();
                        
                        session_start();
                        $_SESSION["usuario"] = $usuario["usuario"];
                        $_SESSION["rol"] = $usuario["rol"];
                        $_SESSION['id_personal'] = $usuario["id_personal"];
                        $_SESSION["login"] = true;
                        
                        error_log("Inicio de sesión exitoso y contraseña actualizada para el usuario: {$user}");
                        
                        header("Location: /pages");
                        exit;
                    } else {
                        $errores[] = "El Password es incorrecto";
                        error_log("Inicio de sesión fallido: Contraseña incorrecta para el usuario {$user}.");
                    }
                }
            } else {
                $errores[] = "El usuario no existe";
                error_log("Inicio de sesión fallido: El usuario {$user} no existe.");
            }
        } catch (PDOException $e) {
            $error = $e->getMessage();
            $errores[] = "Error al ejecutar la consulta: {$error}";
            error_log("Error al ejecutar la consulta en el inicio de sesión: {$error}");
            die('Error al ejecutar la consulta: ' . $error);
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
        <p>Si no tiene usuario aún, porfavor regístrese <a href="registro.php" class='enlace-registro'>Aquí</a></p>
</main>
<?php
incluirTemplate("footer");
?>