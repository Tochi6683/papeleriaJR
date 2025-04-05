<?php
require_once(__DIR__ . '/../config/conexion.php');

class ProductosModel {
    private $conn;

    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }

    // Obtener todos los productos
    public function obtenerProductos() {
        $sql = "SELECT * FROM productos";
        $resultado = $this->conn->query($sql);
        return $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Obtener un producto por su ID
    public function obtenerProductoPorId($id) {
        $sql = "SELECT * FROM productos WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    // Agregar un producto nuevo
    public function agregarProducto($nombre, $precio, $stock) {
        $sql = "INSERT INTO productos (nombre, precio, stock) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sdi", $nombre, $precio, $stock);
        return $stmt->execute();
    }

    // Eliminar un producto por ID
    public function eliminarProducto($id) {
        $sql = "DELETE FROM productos WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Actualizar stock luego de una venta
    public function actualizarStock($id, $nuevoStock) {
        $sql = "UPDATE productos SET stock = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $nuevoStock, $id);
        return $stmt->execute();
    }
}
?>
