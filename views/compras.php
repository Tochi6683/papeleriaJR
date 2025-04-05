<?php
include('../config/config.php'); // Conexión a la base de datos

// Consulta para obtener los productos
$query = "SELECT id, nombre, precio FROM productos";
$result = mysqli_query($conexion, $query);

$productos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $productos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma de Compras | PapeleriaJR</title>
    <link rel="stylesheet" href="../public/style.css"> <!-- Archivo CSS -->
</head>
<body>
    <header>
        <h1>🛒 Plataforma de Compras - PapeleriaJR</h1>
        <a href="dashboard.php" class="btn">🔙 Volver al Inicio</a>
    </header>

    <main class="container">
        <h2>🛍️ Productos Disponibles</h2>
        <div id="productos-container">
            <?php foreach ($productos as $producto): ?>
                <div class="producto">
                    <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                    <p>💲 <?= number_format($producto['precio'], 2) ?> COP</p>
                    <button class="btn agregar-carrito" data-id="<?= $producto['id'] ?>" data-nombre="<?= htmlspecialchars($producto['nombre']) ?>" data-precio="<?= $producto['precio'] ?>">🛒 Agregar</button>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script src="../public/compras.js"></script> <!-- Archivo JavaScript -->
</body>
</html>
