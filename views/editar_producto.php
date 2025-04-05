<?php
require_once(__DIR__ . '/../config/conexion.php'); // Conectar a la BD

// Verificar si se recibió un ID válido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("❌ Error: ID de producto no válido.");
}

$conexion = Conexion::conectar();
$id = intval($_GET['id']);

// Obtener datos del producto
$stmt = $conexion->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("❌ Error: Producto no encontrado.");
}

$producto = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <h1>✏️ Editar Producto</h1>

    <form action="../controllers/productosController.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required>

        <label>Precio:</label>
        <input type="number" name="precio" step="0.01" value="<?php echo $producto['precio']; ?>" required>

        <label>Stock:</label>
        <input type="number" name="stock" value="<?php echo $producto['stock']; ?>" required>

        <input type="hidden" name="accion" value="editar">
        <button type="submit">💾 Guardar Cambios</button>
    </form>

    <a href="productos.php" class="btn">🔙 Volver a Productos</a>
</body>
</html>
