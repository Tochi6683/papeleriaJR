<?php
session_start();
include(__DIR__ . '/../config/conexion.php');

if (!isset($_GET['id']) || !isset($_GET['cantidad'])) {
    die("Error: Faltan datos.");
}

$id_producto = intval($_GET['id']);
$cantidad = intval($_GET['cantidad']);

if ($cantidad < 1) {
    die("Error: La cantidad debe ser mayor o igual a 1.");
}

// Obtener datos del producto desde la base de datos
$sql = "SELECT * FROM productos WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$resultado = $stmt->get_result();
$producto = $resultado->fetch_assoc();

if (!$producto) {
    die("Error: Producto no encontrado.");
}

// Agregar al carrito
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Verificar si ya está en el carrito
$encontrado = false;
foreach ($_SESSION['carrito'] as &$item) {
    if ($item['id'] == $id_producto) {
        $item['cantidad'] += $cantidad;  // Sumar la cantidad seleccionada
        $encontrado = true;
        break;
    }
}

if (!$encontrado) {
    $_SESSION['carrito'][] = [
        'id' => $producto['id'],
        'nombre' => $producto['nombre'],
        'precio' => $producto['precio'],
        'cantidad' => $cantidad // Guardar la cantidad ingresada
    ];
}

// Redirigir al carrito
header("Location: carrito.php");
exit();
?>
