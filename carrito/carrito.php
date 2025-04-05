<?php
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Vaciar carrito si se presiona el botón
if (isset($_POST['vaciar'])) {
    $_SESSION['carrito'] = [];
    header("Location: carrito.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - PapeleriaJR</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>

<div class="container">
    <h2>🛒 Carrito de Compras</h2>

    <?php if (empty($_SESSION['carrito'])): ?>
        <p>El carrito está vacío.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
            <?php
            $totalCompra = 0;
            foreach ($_SESSION['carrito'] as $id => $producto):
                // Seguridad: Asegurar que los datos están seteados
                $nombre = isset($producto['nombre']) ? htmlspecialchars($producto['nombre']) : 'Desconocido';
                $cantidad = isset($producto['cantidad']) ? (int)$producto['cantidad'] : 1;
                $precio = isset($producto['precio']) ? (float)$producto['precio'] : 0;
                $totalProducto = $cantidad * $precio;
                $totalCompra += $totalProducto;
            ?>
            <tr>
                <td><?= $nombre ?></td>
                <td><?= $cantidad ?></td>
                <td>$<?= number_format($precio, 2) ?></td>
                <td>$<?= number_format($totalProducto, 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <p><strong>Total a pagar:</strong> $<?= number_format($totalCompra, 2) ?></p>

        <form method="POST">
            <button type="submit" name="vaciar" class="button alert-error">🗑 Vaciar Carrito</button>
        </form>

        <a href="procesar_compra.php" class="button">✅ Finalizar Compra</a>

    <?php endif; ?>

    <br><br>
    <a href="../index.php" class="button">⬅ Volver a la Tienda</a>
</div>

</body>
</html>
