<?php
$servidor = "localhost";
$usuario = "root";
$password = "Rick0066"; // Contraseña corregida
$base_datos = "papeleriaJR";

// Conexión a la base de datos con MySQLi
$conn = new mysqli($servidor, $usuario, $password, $base_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("❌ Error en la conexión: " . $conn->connect_error);
}

// Conexión a la base de datos con PDO (para transacciones seguras)
try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$base_datos;charset=utf8", $usuario, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Error en la conexión PDO: " . $e->getMessage());
}
?>
