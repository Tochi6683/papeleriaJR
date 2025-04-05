<?php
session_start();
?>

<h2>🧾 Ventas (Carrito)</h2>

<?php if (!empty($_SESSION['carrito'])): ?>
    <table border="1">
        <tr>
            <th>Código</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
        </tr>
        <?php
        $total = 0;
        foreach ($_SESSION['carrito'] as $item):
            $subtotal = $item['precio'] * $item['cantidad'];
            $total += $subtotal;
        ?>
            <tr>
                <td><?= $item['codigo'] ?></td>
                <td><?= $item['descripcion'] ?></td>
                <td>$<?= number_format($item['precio'], 2) ?></td>
                <td><?= $item['cantidad'] ?></td>
                <td>$<?= number_format($subtotal, 2) ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="4"><strong>Total a pagar:</strong></td>
            <td><strong>$<?= number_format($total, 2) ?></strong></td>
        </tr>
    </table>

    <br>
    <a class="button" href="?page=factura">🧾 Proceder a Facturar</a>
<?php else: ?>
    <p>No hay productos en el carrito.</p>
<?php endif; ?>
