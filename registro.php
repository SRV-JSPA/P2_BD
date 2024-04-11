<?php

require "includes/database.php";
require 'includes/funciones.php';

$db = conectarBD();

$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario de registro
    $nombre = $_POST['nombre']; 
    $rol = $_POST['rol']; 
    $usuario = $_POST['user'];
    $contraseña = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    try {
        // Verifica si el usuario ya existe en la base de datos
        $stmt = $db->prepare("SELECT * FROM Usuarios WHERE usuario = :usuario");
        $stmt->execute(['usuario' => $usuario]);

        if ($stmt->rowCount() > 0) {
            echo "El usuario ya existe. Por favor, elige otro nombre de usuario.";
        } else {
            // Inserta primero en Personal
            $stmt = $db->prepare("INSERT INTO Personal (nombre, rol) VALUES (:nombre, :rol) RETURNING id_personal");
            $stmt->execute(['nombre' => $nombre, 'rol' => $rol]);
            $idPersonal = $db->lastInsertId(); // Obtener el ID del último registro insertado

            // Inserta el nuevo usuario en la base de datos vinculado a Personal
            $stmt = $db->prepare("INSERT INTO Usuarios (usuario, contrasena, id_personal) VALUES (:usuario, :contrasena, :id_personal)");
            $stmt->execute([
                'usuario' => $usuario,
                'contrasena' => $contraseña,
                'id_personal' => $idPersonal
            ]);
            if ($rol === 'Mesero') {
                // Inserta id_area_asignada como NULL para que gerente le asigne un area
                $stmt = $db->prepare("INSERT INTO Mesero (id_personal, nombre, id_area_asignada) VALUES (:id_personal, :nombre, NULL)");
                $stmt->execute(['id_personal' => $idPersonal, 'nombre' => $nombre]);
            }
            echo "El usuario se registró de manera exitosa!";

            header("Location: /"); 
            exit;
        }
    } catch (PDOException $e) {
        $errores[] = "Error en la base de datos: " . $e->getMessage();
        error_log('Error en registro: ' . $e->getMessage());
    }
}


incluirTemplate("header");
?>
<main class="contenedor seccion contenido-centrado">
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endforeach; ?>
    <h1>Registro</h1>

    <form class="formulario" method="POST"> 
        <fieldset>
            <legend>Información del Usuario y Personal</legend>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" placeholder="Nombre completo" id="nombre" required>

            <label for="rol">Rol:</label>
            <select name="rol" id="rol" required>
                <option value="">Selecciona un rol</option>
                <option value="Mesero">Mesero</option>
                <option value="Chef">Chef</option>
                <option value="Host">Host</option>
                <option value="Gerente">Gerente</option>
                
            </select>

            <label for="user">Usuario:</label>
            <input type="text" name="user" placeholder="Tu Usuario" id="user" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" placeholder="Tu Contraseña" id="password" required>
        </fieldset>

        <input type="submit" value="Registro" class="boton-verde">
        <p>Si ya tienes un usuario, entonces inicia sesión <a href="index.php" class='enlace-registro'>Aquí</a></p>
    </form>
</main>


<?php

incluirTemplate("footer");
?>