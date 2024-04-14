<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);
?>

<main class="reportes">
<button class="boton-reporte-platos">+ Agregar reporte de platos más pedidos</button>
<button class="boton-reporte-horario">+ Agregar reporte de horario con más pedidos</button>
<button class="boton-reporte-promedio">+ Agregar reporte de promedio de consumo</button>
<button class="boton-reporte-quejasper">+ Agregar reporte de quejas por persona</button>
<button class="boton-reporte-quejasp">+ Agregar reporte de quejas por plato</button> 
<button class="boton-reporte-eficiencia">+ Agregar reporte de eficiencia de meseros</button>  
</main>

<?php
incluirTemplate('footer');
?>