<?php
require_once(__DIR__ . '/../models/productosModel.php');

$productosModel = new ProductosModel();
$productos = $productosModel->obtenerProductos();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["accion"])) {
        if ($_POST["accion"] == "agregar") {
            if (!empty($_POST["nombre"]) && !empty($_POST["precio"]) && !empty($_POST["stock"])) {
                $productosModel->agregarProducto($_POST["nombre"], $_POST["precio"], $_POST["stock"]);
                header("Location: ?page=productos");
                exit();
            } else {
                $error = "❌ Todos los campos son obligatorios.";
            }
        } elseif ($_POST["accion"] == "eliminar") {
            if (!empty($_POST["id"])) {
                $productosModel->eliminarProducto($_POST["id"]);
                header("Location: ?page=productos");
                exit();
            } else {
                $error = "❌ ID del producto no recibido.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <h2>📦 Gestión de Productos</h2>

    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

    <!-- Formulario para agregar productos -->
    <form action="?page=productos" method="POST">
        <input type="hidden" name="accion" value="agregar">
        <input type="text" name="nombre" placeholder="Nombre del producto" required>
        <input type="number" name="precio" placeholder="Precio" required>
        <input type="number" name="stock" placeholder="Stock" required>
        <button type="submit">➕ Agregar Producto</button>
    </form>

    <!-- Tabla de productos -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($productos as $producto): ?>
            <tr>
                <td><?= $producto["id"] ?></td>
                <td><?= $producto["nombre"] ?></td>
                <td>$<?= $producto["precio"] ?></td>
                <td><?= $producto["stock"] ?></td>
                <td>
                    <form action="?page=productos" method="POST" style="display:inline;">
                        <input type="hidden" name="accion" value="eliminar">
                        <input type="hidden" name="id" value="<?= $producto["id"] ?>">
                        <button type="submit" onclick="return confirm('¿Eliminar este producto?')">❌ Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="../index.php">🏠 Volver al inicio</a>
</body>
</html>
