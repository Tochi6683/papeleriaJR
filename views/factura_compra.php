<?php
require_once(__DIR__ . '/../models/comprasModel.php');

if (!isset($_GET["compra_id"])) {
    die("❌ Error: ID de compra no recibido.");
}

$compra_id = $_GET["compra_id"];
$comprasModel = new ComprasModel();
$compra = $comprasModel->obtenerCompraPorId($compra_id);
$productos = $comprasModel->obtenerProductosDeCompra($compra_id);

if (!$compra) {
    die("❌ Error: No se encontró la compra.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Compra</title>
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
    <h2>Factura de Compra</h2>
    <p><strong>Proveedor:</strong> <?= $compra["proveedor"] ?></p>
    <p><strong>Fecha:</strong> <?= $compra["fecha"] ?></p>

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
            <td class="total">$<?= number_format($compra["total"], 2) ?></td>
        </tr>
    </table>

    <br>
    <a href="compras.php" class="btn">Volver</a>
</body>
</html>
