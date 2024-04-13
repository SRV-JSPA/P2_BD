<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);

$db = conectarBD();

$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre']; 
    $rol = $_POST['rol'];

    if(!$nombre){
        $errores[] = "El nombre es obligatorio";
    }

    if(!$rol){
        $errores[] = "El rol es obligatorio";

    }

    if(empty($errores)) {
        $query = "INSERT INTO personal (nombre, rol) VALUES ('$nombre', '$rol')";
        $stmt = $db->prepare($query);
        $stmt->execute();
        
        if($stmt ->rowCount() > 0){
            header('Location: /pages/personal.php?success=1');
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
            <input type="text" name="nombre" placeholder="Nombre completo" id="nombre" required>

            <label for="rol">Rol:</label>
            <select name="rol" id="rol" required>
                <option value="">Selecciona un rol</option>
                <option value="Mesero">Mesero</option>
                <option value="Chef">Chef</option>
                <option value="Host">Host</option>
                <option value="Gerente">Gerente</option>s
            </select>
        </fieldset>

        <input type="submit" value="Crear" class="boton-verde">
    </form>

<?php
incluirTemplate('footer');
?>