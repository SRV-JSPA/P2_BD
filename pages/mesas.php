<?php
require "../includes/database.php";
require '../includes/funciones.php';

if (!isset($_SESSION)) {
    session_start();
}

$rol = $_SESSION['rol'];
$id = $_SESSION['id_personal'];

$db = conectarBD();

incluirTemplate('header', $inicio = true);

$query = "SELECT ms.id_mesa, ms.capacidad, ms.movil, ar.nombre FROM mesa AS ms INNER JOIN area AS ar ON ar.id_area = ms.id_area;";
$stmt = $db->prepare($query);
$stmt->execute();

$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<main class="mesas">
    <?php

    switch ($rol) {
        case 'Gerente':
            todasLasMesas($datos);
            break;

        case 'Mesero':
            mesasDeMesero($db, $id);
            break;

        case 'Host':
            todasLasMesas($datos);
            break;

        default:
            break;
    }

    function todasLasMesas($datos)
    {
        foreach ($datos as $dato) {
    ?>
            <section class="mesas-seccion">
                <p class="titulo-menu">Mesa <?php echo $dato['id_mesa'] ?></p>
                <img src='../img/mesa_r.png' alt="Icono" class="img-mesa" />

                <div class="c-boton">
                    <button class="boton-verde">✓</button>
                    <button class="boton-rojo">྾</button>
                </div>

                <p>Capacidad: <?php echo $dato['capacidad']  ?></p>
                <p>Área: <?php echo $dato['nombre']  ?> </p>
            </section>
            <?php
        }
    }

    function mesasDeMesero($db, $id)
    {
        $query = "SELECT ar.nombre 
              FROM mesero AS mes 
              INNER JOIN area AS ar ON ar.id_area = mes.id_area_asignada 
              WHERE mes.id_personal = '{$id}'";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $area = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($area)) {
            $nombre = $area[0]['nombre'];

            $info = "SELECT ms.id_mesa, ms.capacidad, ms.movil, ar.nombre 
                 FROM mesa AS ms 
                 INNER JOIN area AS ar ON ar.id_area = ms.id_area 
                 WHERE ar.nombre = '{$nombre}'";
            $stmt = $db->prepare($info);
            $stmt->execute();

            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($datos as $dato) {
            ?>
                <section class="mesas-seccion">
                    <p class="titulo-menu">Mesa <?php echo $dato['id_mesa'] ?></p>
                    <img src='../img/mesa_r.png' alt="Icono" class="img-mesa" />

                    <div class="c-boton">
                        <button class="boton-verde">✓</button>
                        <button class="boton-rojo">྾</button>
                    </div>

                    <p>Capacidad: <?php echo $dato['capacidad']  ?></p>
                    <p>Área: <?php echo $dato['nombre']  ?> </p>
                </section>
    <?php
            }
        } else {
            echo "No se encontró ninguna área asignada para este mesero.";
        }
    }


    ?>

</main>

<script src="../app.js" ></script>

<?php
incluirTemplate('footer');
?>