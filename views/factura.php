<?php
session_start();
require_once(__DIR__ . '/../config/conexion.php');
$conn = (new Conexion())->getConexion();

$conn->begin_transaction();

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "<p>No hay productos en el carrito.</p>";
    echo "<a href='?page=tienda'>Volver a Tienda</a>";
    exit;
}

try {
    // Insertar la venta principal
    $fecha = date('Y-m-d H:i:s');
    $total = 0;

    // Calcular el total con validación de cantidad
    foreach ($_SESSION['carrito'] as $item) {
        $cantidad = isset($item['cantidad']) ? (int)$item['cantidad'] : 1;
        $total += $item['precio'] * $cantidad;
    }

    $stmt = $conn->prepare("INSERT INTO ventas (fecha, total) VALUES (?, ?)");
    $stmt->bind_param("sd", $fecha, $total);
    $stmt->execute();
    $id_venta = $conn->insert_id;

    // Insertar detalles y actualizar stock
    foreach ($_SESSION['carrito'] as $item) {
        $idProducto = $item['id'];
        $precio = $item['precio'];
        $cantidad = isset($item['cantidad']) ? (int)$item['cantidad'] : 1;

        // Insertar detalle
        $stmt_detalle = $conn->prepare("INSERT INTO detalle_venta (id_venta, id_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
        $stmt_detalle->bind_param("iiid", $id_venta, $idProducto, $cantidad, $precio);
        $stmt_detalle->execute();

        // Actualizar stock
        $stmt_stock = $conn->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
        $stmt_stock->bind_param("ii", $cantidad, $idProducto);
        $stmt_stock->execute();
    }

    $conn->commit(); // Guardar todo

    // Vaciar carrito
    $_SESSION['carrito'] = [];

    echo "<h2>✅ Factura generada correctamente</h2>";
    echo "<p>Total pagado: <strong>$" . number_format($total, 2) . "</strong></p>";
    echo "<a href='?page=ventas'>🧾 Ver Ventas</a> | <a href='?page=tienda'>🏪 Volver a Tienda</a>";

} catch (Exception $e) {
    $conn->rollback();
    echo "<p style='color:red;'>❌ Error al generar la factura: " . $e->getMessage() . "</p>";
}
?>
