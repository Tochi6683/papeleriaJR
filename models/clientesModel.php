<?php
require_once(__DIR__ . '/../config/conexion.php');

class ClientesModel {
    private $conexion;

    public function __construct() {
        $db = new Conexion(); // Se instancia la clase Conexion
        $this->conexion = $db->getConexion(); // Se obtiene la conexión
    }

    // Obtener todos los clientes
    public function obtenerClientes() {
        $sql = "SELECT * FROM clientes ORDER BY id DESC";
        $result = $this->conexion->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Agregar un cliente
    public function agregarCliente($nombre, $telefono, $email) {
        $stmt = $this->conexion->prepare("INSERT INTO clientes (nombre, telefono, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $telefono, $email);
        return $stmt->execute();
    }

    // Editar un cliente
    public function editarCliente($id, $nombre, $telefono, $email) {
        $stmt = $this->conexion->prepare("UPDATE clientes SET nombre = ?, telefono = ?, email = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nombre, $telefono, $email, $id);
        return $stmt->execute();
    }

    // Eliminar un cliente
    public function eliminarCliente($id) {
        $stmt = $this->conexion->prepare("DELETE FROM clientes WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
