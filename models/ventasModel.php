<?php
require_once(__DIR__ . '/../config/conexion.php');

class VentasModel {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::conectar();
    }

    public function registrarVenta($cliente_id, $total) {
        $stmt = $this->conexion->prepare("INSERT INTO ventas (cliente_id, total, fecha) VALUES (?, ?, NOW())");
        $stmt->bind_param("id", $cliente_id, $total);
        if ($stmt->execute()) {
            return $this->conexion->insert_id;
        }
        return false;
    }

    public function agregarDetalleVenta($venta_id, $producto_id, $cantidad, $precio_unitario) {
        $stmt = $this->conexion->prepare("INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $venta_id, $producto_id, $cantidad, $precio_unitario);
        return $stmt->execute();
    }

    public function actualizarStock($producto_id, $cantidad) {
        $stmt = $this->conexion->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
        $stmt->bind_param("ii", $cantidad, $producto_id);
        return $stmt->execute();
    }

    public function obtenerVentas() {
        $resultado = $this->conexion->query("
            SELECT v.id, c.nombre AS cliente, v.total, v.fecha 
            FROM ventas v
            JOIN clientes c ON v.cliente_id = c.id
            ORDER BY v.fecha DESC
        ");
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerVentaPorId($venta_id) {
        $stmt = $this->conexion->prepare("
            SELECT v.id, c.nombre AS cliente, v.total, v.fecha 
            FROM ventas v
            JOIN clientes c ON v.cliente_id = c.id
            WHERE v.id = ?
        ");
        $stmt->bind_param("i", $venta_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function obtenerProductosDeVenta($venta_id) {
        $stmt = $this->conexion->prepare("
            SELECT dv.producto_id, p.nombre AS producto, dv.cantidad, dv.precio_unitario 
            FROM detalle_ventas dv
            JOIN productos p ON dv.producto_id = p.id
            WHERE dv.venta_id = ?
        ");
        $stmt->bind_param("i", $venta_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
?>
