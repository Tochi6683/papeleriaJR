<?php
require_once(__DIR__ . '/../config/conexion.php');

class ReportesModel {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::conectar();
    }

    public function obtenerVentasPorFecha($fecha) {
        $stmt = $this->conexion->prepare("SELECT * FROM ventas WHERE DATE(fecha) = ?");
        $stmt->bind_param("s", $fecha);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerProductosStockBajo($limite) {
        $stmt = $this->conexion->prepare("SELECT * FROM productos WHERE stock <= ?");
        $stmt->bind_param("i", $limite);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
?>
