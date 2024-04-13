<?php
require "../includes/database.php";
require '../includes/funciones.php';

$db = conectarBD();

incluirTemplate('header', $inicio = true);

if (isset($_GET['eliminar'])) {
    $id = $_GET['id']; 
    $sql = "DELETE FROM personal WHERE id_personal = $id"; 
    $stmt  = $db->prepare($sql);
    $stmt->execute();

    if($stmt -> rowCount() > 0){
        header('Location: /pages/personal.php?success=3');
    }
}

?>

<main>
    <p class="mensaje-eliminar">Desea eliminar a esta persona?</p>
    <div class="contenedor-eliminar">
    <button class="btn_verde" onclick="window.location.href = 'borrar-personal.php?id=<?php echo $_GET['id']; ?>&eliminar=true';">Sí</button>
        <button class="btn_rojo" onclick="window.location.href = 'personal.php';">No</button>
    </div>
</main>

<?php
incluirTemplate('footer');
?>