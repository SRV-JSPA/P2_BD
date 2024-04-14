<?php
require "../includes/database.php";
require '../includes/funciones.php';

incluirTemplate('header', $inicio = true);
?>

<main class="pedidos">
<button class="boton-verde">+ Agregar reporte de platos más pedidos</button>
<button class="boton-verde">+ Agregar reporte de horario con más pedidos</button>
<button class="boton-verde">+ Agregar reporte de promedio de consumo</button>
<button class="boton-verde">+ Agregar reporte de quejas por persona</button>
<button class="boton-verde">+ Agregar reporte de quejas por plato</button> 
<button class="boton-verde">+ Agregar reporte de eficiencia de meseros</button>  
</main>

<?php
incluirTemplate('footer');
?>