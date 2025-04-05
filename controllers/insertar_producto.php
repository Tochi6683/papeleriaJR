<?php
include('conexion.php'); // Incluir archivo de conexión

// Verificar que el formulario se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger datos del formulario
    $nombre_producto = $_POST['nombre_producto'];
    $precio_producto = $_POST['precio_producto'];
    $descripcion_producto = $_POST['descripcion_producto'];

    // Consulta SQL para insertar datos en la tabla de productos
    $sql = "INSERT INTO productos (nombre, precio, descripcion) 
            VALUES ('$nombre_producto', '$precio_producto', '$descripcion_producto')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Producto agregado exitosamente";
    } else {
        echo "Error al agregar producto: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
?>
