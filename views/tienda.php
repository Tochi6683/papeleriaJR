<?php
session_start();
require_once(__DIR__ . '/../models/productosModel.php');

$productosModel = new ProductosModel();
$productos = $productosModel->obtenerProductos();

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Agregar producto al carrito
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar"])) {
    $id = $_POST["id_producto"];

    // Buscar el producto por ID
    foreach ($productos as $producto) {
        if ($producto["id"] == $id) {
            $producto["cantidad"] = isset($_POST["cantidad"]) ? (int)$_POST["cantidad"] : 1;
            $_SESSION["carrito"][] = $producto;
            break;
        }
    }

    echo "<p style='color:green;'>✅ Producto agregado al carrito</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda - Papelería JR</title>
    <link rel="stylesheet" href="../assets/styles.css"> <!-- Tu estilo si ya lo tienes -->
</head>
<body>
    <h2>🛍️ Tienda</h2>

    <?php if (count($productos) > 0): ?>
        <table border="1">
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acción</th>
            </tr>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?= $producto["nombre"] ?></td>
                    <td>$<?= number_format($producto["precio"], 2) ?></td>
                    <td><?= $producto["stock"] ?></td>
                    <td>
                       <form method="post" action="?page=tienda">
                       <input type="hidden" name="id_producto" value="<?= $producto["id"] ?>">
                       <input type="number" name="cantidad" value="1" min="1" style="width: 60px;" required>
                       <input type="submit" name="agregar" value="Agregar al carrito">
                       </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No hay productos disponibles.</p>
    <?php endif; ?>

    <br>
    <a href="?page=ventas">🧾 Ir a Ventas / Facturar</a>
</body>
</html>
