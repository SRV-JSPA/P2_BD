<?php
if (!isset($_SESSION)) {
    session_start();
}

$auth = $_SESSION["login"] ?? null;

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto 2 BD</title>
    <link href="../../style.css" rel="stylesheet">
    <link rel="stylesheet" href="../../normalize.css">
</head>

<body>

    <header class=" <?php echo $inicio ? "inicio" : 'header'; ?>">
        <div class="contenedor">
            <div class="barra">
                <a class="logo" href="/">
                    <h1 class="logo__nombre no-margin centrar-texto">Restaurante<span class="logo__bold">Asgard</span></h1>
                </a>

                <nav class="navegacion">
                    <p class="texto-header" >Lo mejor de lo mejor</p>
                    <?php if ($auth) : ?>
                        <a href="../../cerrar-sesion.php" class='navegacion__enlace' >Cerrar Sesión</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>