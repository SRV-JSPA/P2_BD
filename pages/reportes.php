<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);
?>

<main class="reportes">
<button class="boton-reporte-platos" onclick="window.location.href = 'form-reporte-platos.php';" >+ Agregar reporte de platos más pedidos</button>
<button class="boton-reporte-horario" onclick="window.location.href = 'form-reporte-horario.php';" >+ Agregar reporte de horario con más pedidos</button>
<button class="boton-reporte-promedio" onclick="window.location.href = 'form-reporte-promedio.php';" >+ Agregar reporte de promedio de consumo</button>
<button class="boton-reporte-quejasper" onclick="window.location.href = 'form-reporte-quejasper.php';" >+ Agregar reporte de quejas por persona</button>
<button class="boton-reporte-quejasp" onclick="window.location.href = 'form-reporte-quejasp.php';" >+ Agregar reporte de quejas por plato</button> 
<button class="boton-reporte-eficiencia" onclick="window.location.href = 'form-reporte-eficiencia.php';" >+ Agregar reporte de eficiencia de meseros</button>  
</main>

<?php
incluirTemplate('footer');
?>