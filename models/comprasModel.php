<?php
require_once(__DIR__ . '/../config/conexion.php');

class ComprasModel {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::conectar();
    }

    // Registrar una nueva compra
    public function registrarCompra($proveedor_id, $total) {
        $stmt = $this->conexion->prepare("INSERT INTO compras (proveedor_id, total, fecha) VALUES (?, ?, NOW())");
        $stmt->bind_param("id", $proveedor_id, $total);
        if ($stmt->execute()) {
            return $this->conexion->insert_id; // Retorna el ID de la compra recién creada
        } else {
            return false;
        }
    }

    // Agregar productos comprados a la tabla detalle_compras
    public function agregarDetalleCompra($compra_id, $producto_id, $cantidad, $precio_unitario) {
        $stmt = $this->conexion->prepare("INSERT INTO detalle_compras (compra_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $compra_id, $producto_id, $cantidad, $precio_unitario);
        return $stmt->execute();
    }

    // Actualizar el stock después de una compra
    public function actualizarStock($producto_id, $cantidad) {
        $stmt = $this->conexion->prepare("UPDATE productos SET stock = stock + ? WHERE id = ?");
        $stmt->bind_param("ii", $cantidad, $producto_id);
        return $stmt->execute();
    }

    // Obtener detalles de una compra específica
    public function obtenerCompraPorId($compra_id) {
        $stmt = $this->conexion->prepare("SELECT c.id, p.nombre AS proveedor, c.total, c.fecha 
            FROM compras c
            JOIN proveedores p ON c.proveedor_id = p.id
            WHERE c.id = ?");
        $stmt->bind_param("i", $compra_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    // Obtener productos de una compra específica
    public function obtenerProductosDeCompra($compra_id) {
        $stmt = $this->conexion->prepare("SELECT dc.producto_id, p.nombre AS producto, dc.cantidad, dc.precio_unitario, 
            (dc.cantidad * dc.precio_unitario) AS subtotal
            FROM detalle_compras dc
            JOIN productos p ON dc.producto_id = p.id
            WHERE dc.compra_id = ?");
        $stmt->bind_param("i", $compra_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
?>
