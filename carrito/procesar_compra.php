<?php
session_start();
require '../config.php'; // Conexión a la base de datos
require '../vendor/autoload.php'; // Cargar PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    die("❌ Tu carrito está vacío. <a href='../index.php'>Volver a la tienda</a>");
}

try {
    $pdo->beginTransaction();

    // Insertar cliente (si no existe)
    $nombreCliente = "Jhon Chito"; // Nombre fijo
    $correoCliente = "rick6683rick@gmail.com"; // Correo fijo

    $stmt = $pdo->prepare("SELECT id FROM clientes WHERE correo = ?");
    $stmt->execute([$correoCliente]);
    $cliente = $stmt->fetch();

    if ($cliente) {
        $cliente_id = $cliente['id'];
    } else {
        $stmt = $pdo->prepare("INSERT INTO clientes (nombre, correo) VALUES (?, ?)");
        $stmt->execute([$nombreCliente, $correoCliente]);
        $cliente_id = $pdo->lastInsertId();
    }

    // Insertar venta
    $stmt = $pdo->prepare("INSERT INTO ventas (cliente_id, total, fecha) VALUES (?, ?, NOW())");
    $total = array_sum(array_column($_SESSION['carrito'], 'subtotal'));
    $stmt->execute([$cliente_id, $total]);
    $venta_id = $pdo->lastInsertId();

    // Insertar detalles de la venta y actualizar stock
    foreach ($_SESSION['carrito'] as $producto) {
        $stmt = $pdo->prepare("INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)");
        $stmt->execute([$venta_id, $producto['id'], $producto['cantidad'], $producto['precio']]);

        // Actualizar stock
        $stmt = $pdo->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
        $stmt->execute([$producto['cantidad'], $producto['id']]);
    }

    $pdo->commit();

    // Enviar correo con PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'rick6683rick@gmail.com'; // Tu correo
        $mail->Password = 'Rick0066'; // Tu contraseña (usar clave de aplicación si es Gmail)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('rick6683rick@gmail.com', 'Papeleria JR');
        $mail->addAddress($correoCliente, $nombreCliente);

        $mail->isHTML(true);
        $mail->Subject = 'Confirmación de compra - Papeleria JR';
        $mensaje = "<h2>Gracias por tu compra, $nombreCliente!</h2>";
        $mensaje .= "<p>Detalles de tu compra:</p><ul>";

        foreach ($_SESSION['carrito'] as $producto) {
            $mensaje .= "<li>{$producto['nombre']} - {$producto['cantidad']} x $" . number_format($producto['precio'], 2) . "</li>";
        }

        $mensaje .= "</ul><p>Total: $" . number_format($total, 2) . "</p>";
        $mail->Body = $mensaje;

        $mail->send();
        echo "✅ Compra finalizada. Revisa tu correo para la confirmación.";
    } catch (Exception $e) {
        echo "❌ Error al enviar el correo: {$mail->ErrorInfo}";
    }

    unset($_SESSION['carrito']); // Vaciar carrito después de la compra

} catch (Exception $e) {
    $pdo->rollBack();
    die("❌ Error en la compra: " . $e->getMessage());
}
?>
