<?php
session_start();
include(__DIR__ . '/../config/conexion.php');

$cliente_id = 1; // Cliente fijo temporalmente, cambiar según autenticación

// Obtener historial de compras del cliente
$stmt = $conexion->prepare("SELECT ventas.id, ventas.fecha, ventas.total FROM ventas WHERE cliente_id = ? ORDER BY ventas.fecha DESC");
$stmt->bind_param("i", $cliente_id);
$stmt->execute();
$result = $stmt->get_result();
$ventas = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Compras</title>
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
    <h2>Historial de Compras</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID Venta</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Factura</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ventas as $venta): ?>
                <tr>
                    <td><?php echo $venta['id']; ?></td>
                    <td><?php echo $venta['fecha']; ?></td>
                    <td>$<?php echo number_format($venta['total'], 2); ?></td>
                    <td><a href="../public/facturas/factura_<?php echo $venta['id']; ?>.pdf" target="_blank">Descargar</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <a href="../index.php">Volver al inicio</a>
</body>
</html>
