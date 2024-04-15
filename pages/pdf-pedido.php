<?php
require "../includes/database.php";
require '../includes/funciones.php';
require '../vendor/autoload.php';

if (!isset($_SESSION)) {
    session_start();
}
$db = conectarBD();

$id = $_GET['id'] ?? null;
$id_pedido = intval($id);

$query = "SELECT * FROM pedido WHERE id_pedido = $id_pedido";
$stmt = $db->prepare($query);
$stmt->execute();

$pedido = $stmt->fetch(PDO::FETCH_ASSOC);

$id_cliente = $pedido['id_cliente'];

$query_cliente = "SELECT * FROM cliente WHERE id_cliente = $id_cliente";
$stmt_cliente = $db->prepare($query_cliente);
$stmt_cliente->execute();
$cliente = $stmt_cliente->fetch(PDO::FETCH_ASSOC);

$nombre_cliente = $cliente['nombre'];
$direccion_cliente = $cliente['direccion'];
$nit_cliente = $cliente['nit'];



$subtotal = $pedido['subtotal'];
$propina = $pedido['propina'];
$total = $pedido['total'];

$query_detalle_pedido = "SELECT dp.id_detalle_pedido, dp.id_pedido, dp.id_item, dp.cantidad, itm.nombre, itm.precio,(dp.cantidad * itm.precio) AS total FROM detalle_pedido AS dp INNER JOIN item AS itm ON itm.id_item = dp.id_item WHERE id_pedido = $id_pedido";
$stmt_query_detalle_pedido = $db->prepare($query_detalle_pedido);
$stmt_query_detalle_pedido->execute();
$productos = $stmt_query_detalle_pedido->fetchAll(PDO::FETCH_ASSOC);


$html = '
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Resumen pedido</h1>

    <p>Cliente: '. $nombre_cliente .' </p>
    <p>Dirección: '. $direccion_cliente .'  </p>
    <p>NIT: '. $nit_cliente .'</p>
    <p>------------------</p>';
    foreach ($productos as $producto) {
        $html .= '<p>' . $producto['cantidad'] . ' - ' . $producto['nombre'] . ' - ' . $producto['total'] . '</p>';
    }
    $html.='<p>Subtotal: '. $subtotal .' </p>
    <p>Propina: '. $propina .'  </p>
    <p>Total General: '. $total  .'</p>
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

