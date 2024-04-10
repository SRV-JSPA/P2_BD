<?php
require "../includes/database.php";
require '../includes/funciones.php';

$db = conectarBD();

if (!isset($_SESSION)) {
    session_start();
}

$rol = $_SESSION['rol'];
incluirTemplate('header', $inicio = true);
?>

<main class="contenedor-menu menu">

    <?php
    switch ($rol) {
        case 'Gerente':
            mostrarTodasSecciones();
            break;
        case 'Host':
            mostrarSeccionMesas();
            break;
        case 'Mesero':
            mostrarSeccionMesas();
            mostrarSeccionPedidos();
            break;
        case 'Chef':
            mostrarSeccionBebidasEspera();
            mostrarSeccionPlatillosEspera();
            break;
        default:
            mostrarTodasSecciones();
            break;
    }

    function mostrarTodasSecciones()
    {
        mostrarSeccionMesas();
        mostrarSeccionPersonal();
        mostrarSeccionPedidos();
        mostrarSeccionPlatillosEspera();
        mostrarSeccionBebidasEspera();
    }

    function mostrarSeccionMesas()
    {
        ?>
        <section class="menu-seccion">
            <p class="titulo-menu">Mesas</p>
            <div className="img-menu">
                <a href="/pages/mesas.php">
                    <img src='../img/mesas.png' alt="Icono" />
                </a>
            </div>
        </section>
        <?php
    }

    function mostrarSeccionPersonal()
    {
        ?>
        <section class="menu-seccion">
            <p class="titulo-menu">Personal</p>
            <div className="img-menu">
                <a href="/pages/personal.php">
                    <img src='../img/personal.png' alt="Icono" />
                </a>
            </div>
        </section>
        <?php
    }

    function mostrarSeccionPedidos()
    {
        ?>
        <section class="menu-seccion">
            <p class="titulo-menu">Pedidos</p>
            <div className="img-menu">
                <a href="/pages/pedidos.php">
                    <img src='../img/pedido.png' alt="Icono" />
                </a>
            </div>
        </section>
        <?php
    }

    function mostrarSeccionPlatillosEspera()
    {
        ?>
        <section class="menu-seccion">
            <p class="titulo-menu">Platillos en espera</p>
            <div className="img-menu">
                <a href="/pages/cocina.php">
                    <img src='../img/cocina.png' alt="Icono" />
                </a>
            </div>
        </section>
        <?php
    }

    function mostrarSeccionBebidasEspera()
    {
        ?>
        <section class="menu-seccion">
            <p class="titulo-menu">Bebidas en espera</p>
            <div className="img-menu">
                <a href="/pages/bar.php">
                    <img src='../img/bar.png' alt="Icono" />
                </a>
            </div>
        </section>
        <?php
    }
    ?>

</main>

<?php
incluirTemplate('footer');
?>
