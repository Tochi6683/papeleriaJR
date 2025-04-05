<?php
include(__DIR__ . "/conexion.php"); // Incluir la conexión

if (isset($conexion) && $conexion->connect_error == false) {
    echo "✅ Conexión exitosa a la base de datos.";
} else {
    echo "❌ Error de conexión.";
}
?>
