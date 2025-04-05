<?php
include(__DIR__ . '/../config/conexion.php');

if (!isset($reporteVentas)) {
    die("No hay datos para mostrar.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <h2>Reporte de Ventas</h2>
    <table border="1">
        <tr>
            <th>ID Venta</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Total</th>
        </tr>
        <?php foreach ($reporteVentas as $venta): ?>
            <tr>
                <td><?php echo $venta["id"]; ?></td>
                <td><?php echo $venta["cliente"]; ?></td>
                <td><?php echo $venta["fecha"]; ?></td>
                <td>$<?php echo number_format($venta["total"], 2); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="../index.php">🔙 Volver al menú</a>
</body>
</html>
