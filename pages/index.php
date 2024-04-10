<?php
require "../includes/database.php";
require '../includes/funciones.php';

$db = conectarBD();

incluirTemplate('header', $inicio = true)
?>

<main class="contenedor-menu menu">
    <section class="menu-seccion">
        <p class="titulo-menu">Mesas</p>
        <div className="img-menu">
            <a href="/pages/mesas.php">
                <img src='../img/mesas.png' alt="Icono" />
            </a>
        </div>
    </section>
    <section class="menu-seccion">
        <p class="titulo-menu">Personal</p>
        <div className="img-menu">
            <a href="/pages/personal.php">
                <img src='../img/personal.png' alt="Icono" />
            </a>
        </div>
    </section>
    <section class="menu-seccion">
        <p class="titulo-menu">Pedidos</p>
        <div className="img-menu">
            <a href="/pages/pedidos.php">
                <img src='../img/pedido.png' alt="Icono" />
            </a>
        </div>
    </section>
    <section class="menu-seccion">
        <p class="titulo-menu">Platillos en espera</p>
        <div className="img-menu">
            <a href="/pages/cocina.php">
                <img src='../img/cocina.png' alt="Icono" />
            </a>
        </div>
    </section>
    <section class="menu-seccion">
        <p class="titulo-menu">Bebidas en espera</p>
        <div className="img-menu">
            <a href="/pages/bar.php">
                <img src='../img/bar.png' alt="Icono" />
            </a>
        </div>
    </section>
</main>

<?php

incluirTemplate('footer')
?>