<?php
require_once(__DIR__ . '/../models/ventasModel.php');

if (!isset($_GET["venta_id"])) {
    die("❌ Error: ID de venta no recibido.");
}

$id_venta = $_GET["venta_id"];
$ventasModel = new VentasModel();

// Obtener datos de la venta
$venta = $ventasModel->obtenerVentaPorId($id_venta);
$productos = $ventasModel->obtenerProductosDeVenta($id_venta);

if (!$venta) {
    die("❌ Error: No se encontró la venta.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Venta</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { font-weight: bold; }
        .btn { padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <h2>Factura de Venta</h2>
    <p><strong>Cliente:</strong> <?= $venta["cliente"] ?></p>
    <p><strong>Fecha:</strong> <?= $venta["fecha"] ?></p>

    <table>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach ($productos as $producto): ?>
        <tr>
            <td><?= $producto["producto"] ?></td>
            <td><?= $producto["cantidad"] ?></td>
            <td>$<?= number_format($producto["precio_unitario"], 2) ?></td>
            <td>$<?= number_format($producto["subtotal"], 2) ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" class="total">Total</td>
            <td class="total">$<?= number_format($venta["total"], 2) ?></td>
        </tr>
    </table>

    <br>
    <a href="ventas.php" class="btn">Volver</a>
</body>
</html>
