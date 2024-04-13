<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);

$db = conectarBD();

$id = $_GET['id'];

$query = "SELECT * FROM personal WHERE id_personal = $id;";
$stmt = $db->prepare($query);
$stmt->execute();
$info = $stmt->fetchAll(PDO::FETCH_ASSOC);

$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre']; 
    $rol = $_POST['rol'];

    if(empty($nombre)){
        $errores[] = "El nombre es obligatorio";
    }

    if(empty($rol)){
        $errores[] = "El rol es obligatorio";
    }

    if(empty($errores)) {
        
        $query = "UPDATE personal SET nombre = '$nombre', rol = '$rol' WHERE id_personal = $id";
        $stmt = $db->prepare($query);
        $stmt->execute();

        
        if($stmt->rowCount() > 0){
            header('Location: /pages/personal.php?success=2');
            exit; 
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
    <h1>Editar Personal</h1>

    <form class="formulario" method="POST"> 
        <fieldset>
            <legend>Información del Personal</legend>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" placeholder="Nombre completo" id="nombre" value="<?= htmlspecialchars($info[0]['nombre']); ?>" required>

            <label for="rol">Rol:</label>
            <select name="rol" id="rol" required>
                <option value="">Selecciona un rol</option>
                <option value="Mesero" <?= ($info[0]['rol'] === 'Mesero') ? 'selected' : ''; ?>>Mesero</option>
                <option value="Chef" <?= ($info[0]['rol'] === 'Chef') ? 'selected' : ''; ?>>Chef</option>
                <option value="Host" <?= ($info[0]['rol'] === 'Host') ? 'selected' : ''; ?>>Host</option>
                <option value="Gerente" <?= ($info[0]['rol'] === 'Gerente') ? 'selected' : ''; ?>>Gerente</option>
            </select>
        </fieldset>

        <input type="submit" value="Guardar Cambios" class="boton-verde">
    </form>
</main>

<?php
incluirTemplate('footer');
?>
