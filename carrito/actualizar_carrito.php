<?php
session_start();
if (!isset($_SESSION['carrito']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: carrito.php");
    exit();
}

$id = intval($_POST['id']);
$cantidad = intval($_POST['cantidad']);

if ($cantidad < 1) {
    $cantidad = 1;
}

// Actualizar la cantidad en el carrito
foreach ($_SESSION['carrito'] as &$producto) {
    if ($producto['id'] == $id) {
        $producto['cantidad'] = $cantidad;
        break;
    }
}

header("Location: carrito.php");
exit();
?>
