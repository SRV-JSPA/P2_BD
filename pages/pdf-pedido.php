<?php
require "../includes/database.php";
require '../includes/funciones.php';
require '../vendor/autoload.php';

if (!isset($_SESSION)) {
    session_start();
}


$html = '
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Resumen pedido</h1>

    <p>Cliente: </p>
    <p>Dirección: </p>
    <p>NIT: </p>
    <p>------------------</p>
    <p>Cantidad - nombre - total</p>
    <p>Subtotal: </p>
    <p>Propina: </p>
    <p>Total General: </p>
</body>
</html>
';

use Dompdf\Dompdf;


$dompdf = new Dompdf();


$dompdf->loadHtml($html);
$dompdf->render();


$filename = "resumen_pedido.pdf";


$output = $dompdf->output();
file_put_contents($filename, $output);


header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=\"{$filename}\"");
header("Content-Length: " . filesize($filename));


readfile($filename);


unlink($filename);


$_SESSION['descarga_exitosa'] = true;

var_dump($_SESSION['descarga_exitosa']);
exit;

