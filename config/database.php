<?php
$host = "localhost";
$user = "root";
$pass = "Rick0066";
$db = "papeleriajr";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
