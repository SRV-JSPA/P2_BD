<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);

$db = conectarBD();

$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $rol = $_POST['rol'];
    $id_area = intval($_POST['area']);

    if (!$nombre) {
        $errores[] = "El nombre es obligatorio";
    }

    if (!$rol) {
        $errores[] = "El rol es obligatorio";
    }

    if (empty($errores)) {
        $query = "INSERT INTO personal (nombre, rol) VALUES ('$nombre', '$rol')";
        $stmt = $db->prepare($query);
        $stmt->execute();

        if ($rol == 'Mesero') {

            if ($stmt->rowCount() > 0) {

                $id_personal = $db->lastInsertId();


                $meseroQuery = "INSERT INTO mesero (id_personal, nombre, id_area_asignada) VALUES ('$id_personal', '$nombre', '$id_area')";
                $stmtMesero = $db->prepare($meseroQuery);
                $stmtMesero->execute();


                if ($stmtMesero->rowCount() > 0) {

                    header('Location: /pages/personal.php?success=1');
                    exit;
                } else {
                    $errores[] = "Error al insertar en la tabla de mesero";
                }
            } else {
                $errores[] = "Error al insertar el personal";
            }
        } else {

            if ($stmt->rowCount() > 0) {
                header('Location: /pages/personal.php?success=1');
                exit;
            } else {
                $errores[] = "Error al insertar el personal";
            }
        }
    }
}
?>

<main class="contenedor seccion contenido-centrado">
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endforeach; ?>
    <h1>Agregar Personal</h1>

    <form class="formulario" method="POST">
        <fieldset>
            <legend>Información del Personal</legend>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" placeholder="Nombre completo" id="nombre" onchange="mostrarOcultarCampo()" required>

            <label for="rol">Rol:</label>
            <select name="rol" id="rol" required>
                <option value="">Selecciona un rol</option>
                <option value="Mesero">Mesero</option>
                <option value="Chef">Chef</option>
                <option value="Host">Host</option>
                <option value="Gerente">Gerente</option>
            </select>

            <div class="campoMesero">
                <label for="area">ID área asignada:</label>
                <input type="number" name="area" placeholder="ID área asignada" id="area">
            </div>

        </fieldset>

        <input type="submit" value="Crear" class="boton-verde">
    </form>

    <script src="../app.js"></script>

    <?php
    incluirTemplate('footer');
    ?>