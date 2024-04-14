<?php
require "../includes/database.php";
require '../includes/funciones.php';

$db = conectarBD();

incluirTemplate('header', $inicio = true);

if (isset($_GET['eliminar'])) {
    $id = intval($_GET['id']);

    $info = "SELECT rol FROM personal WHERE id_personal = $id";
    $stmtInfo = $db->prepare($info);
    $stmtInfo->execute();
    $resultado = $stmtInfo->fetch(PDO::FETCH_ASSOC);
    $rol = $resultado['rol'];

    if ($rol == 'Mesero') {

        $query_id_mesero = "SELECT * FROM mesero WHERE id_personal = $id";
        $stmt_id_mesero = $db->prepare($query_id_mesero);
        $stmt_id_mesero->execute();
        $info_mesero = $stmt_id_mesero->fetch(PDO::FETCH_ASSOC);
        

        $id_mesero = $info_mesero['id_mesero'];


        $queryPedido = "UPDATE pedido SET id_mesero = NULL WHERE id_mesero = $id_mesero";
        $stmtPedido = $db->prepare($queryPedido);
        $stmtPedido->execute();

        $queryEncuesta = "UPDATE encuesta SET id_mesero = NULL WHERE id_mesero = $id_mesero";
        $stmtEncuesta = $db->prepare($queryEncuesta);
        $stmtEncuesta->execute();

        $queryQueja = "UPDATE queja SET id_personal = NULL WHERE id_personal = $id";
        $stmtQueja = $db->prepare($queryQueja);
        $stmtQueja->execute();


        $queryMesero = "DELETE FROM mesero WHERE id_personal = $id";
        $stmtMesero = $db->prepare($queryMesero);
        $stmtMesero->execute();
    }

    $usuarioQuery = "DELETE FROM usuarios WHERE id_personal = $id";
    $stmtUsuario = $db->prepare($usuarioQuery);
    $stmtUsuario->execute();


    $sql = "DELETE FROM personal WHERE id_personal = $id";
    $stmt  = $db->prepare($sql);
    $stmt->execute();



    if ($stmt->rowCount() > 0 && $stmtUsuario->rowCount() > 0 && $stmtMesero->rowCount() > 0 && $stmtPedido->rowCount() > 0) {
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