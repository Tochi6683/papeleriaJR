<?php
$routes = [
    'dashboard' => 'views/dashboard.php',
    'tienda' => 'views/tienda.php',
    'clientes' => 'views/clientes.php',
    'ventas' => 'views/ventas.php',
    'factura' => 'views/factura.php'
];

$page = $_GET['page'] ?? 'dashboard';

if (array_key_exists($page, $routes)) {
    $vista = $routes[$page];
    include 'views/layout.php';
} else {
    echo "Error 404: Página no encontrada.";
}
