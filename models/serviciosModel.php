<?php
require_once("../config/conexion.php");

class ServiciosModel {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::conectar();
    }

    public function obtenerServicios() {
        $sql = "SELECT * FROM servicios";
        $resultado = $this->conexion->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function agregarServicio($nombre, $descripcion, $precio) {
        $sql = "INSERT INTO servicios (nombre, descripcion, precio) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssd", $nombre, $descripcion, $precio);
        return $stmt->execute();
    }

    public function eliminarServicio($id) {
        $sql = "DELETE FROM servicios WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
