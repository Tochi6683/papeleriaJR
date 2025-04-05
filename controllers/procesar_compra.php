<?php
include '../config/config.php'; // Conexión a la base de datos

// Verifica si se recibieron productos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productos'])) {
    $productos = json_decode($_POST['productos'], true);

    if (!empty($productos)) {
        // 1️⃣ Registrar la venta en la tabla "ventas"
        $sql = "INSERT INTO ventas (total) VALUES (0)";
        if ($conn->query($sql) === TRUE) {
            $venta_id = $conn->insert_id; // Obtiene el ID de la venta recién creada
            $total_venta = 0;

            // 2️⃣ Registrar cada producto en "detalle_ventas"
            foreach ($productos as $producto) {
                $producto_id = $producto['id'];
                $cantidad = $producto['cantidad'];
                $precio = $producto['precio'];
                $subtotal = $cantidad * $precio;
                $total_venta += $subtotal;

                $sql_detalle = "INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, precio)
                                VALUES ($venta_id, $producto_id, $cantidad, $precio)";
                $conn->query($sql_detalle);

                // 3️⃣ Actualizar el stock en "productos"
                $sql_update_stock = "UPDATE productos SET stock = stock - $cantidad WHERE id = $producto_id";
                $conn->query($sql_update_stock);
            }

            // 4️⃣ Actualizar el total en la venta
            $sql_update_venta = "UPDATE ventas SET total = $total_venta WHERE id = $venta_id";
            $conn->query($sql_update_venta);

            echo json_encode(["status" => "success", "message" => "Compra realizada con éxito", "venta_id" => $venta_id]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al registrar la venta"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "No hay productos seleccionados"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Solicitud no válida"]);
}

$conn->close();
?>
