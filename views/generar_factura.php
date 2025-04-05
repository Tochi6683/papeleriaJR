<?php
require_once(__DIR__ . '/../models/ventasModel.php');

if (!isset($_GET['venta_id'])) {
    die("❌ Error: No se proporcionó un ID de venta.");
}

$ventasModel = new VentasModel();
$venta = $ventasModel->obtenerVentaPorId($_GET['venta_id']);
$productos = $ventasModel->obtenerProductosDeVenta($_GET['venta_id']);

if (!$venta) {
    die("❌ Error: Venta no encontrada.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Venta</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <h1>Factura de Venta</h1>
    <p><strong>Cliente:</strong> <?= $venta["cliente"] ?></p>
    <p><strong>Fecha:</strong> <?= $venta["fecha"] ?></p>

    <table>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Total</th>
        </tr>
        <?php foreach ($productos as $producto): ?>
            <tr>
                <td><?= $producto["producto"] ?></td>
                <td><?= $producto["cantidad"] ?></td>
                <td>$<?= number_format($producto["precio_unitario"], 2) ?></td>
                <td>$<?= number_format($producto["cantidad"] * $producto["precio_unitario"], 2) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Total: $<?= number_format($venta["total"], 2) ?></h2>

    <br>
    <a href="ventas.php">📋 Volver a Ventas</a>
    <a href="../index.php">🏠 Volver al Inicio</a>

</body>
</html>
