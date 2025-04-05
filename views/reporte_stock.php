<?php
include(__DIR__ . '/../config/conexion.php');

if (!isset($reporteStock)) {
    die("No hay datos para mostrar.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Stock Bajo</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <h2>Productos con Stock Bajo</h2>
    <table border="1">
        <tr>
            <th>ID Producto</th>
            <th>Nombre</th>
            <th>Stock Disponible</th>
        </tr>
        <?php foreach ($reporteStock as $producto): ?>
            <tr>
                <td><?php echo $producto["id"]; ?></td>
                <td><?php echo $producto["nombre"]; ?></td>
                <td><?php echo $producto["stock"]; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="../index.php">🔙 Volver al menú</a>
</body>
</html>
