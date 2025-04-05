<?php
class Conexion {
    private $host = "localhost";
    private $usuario = "root";
    private $password = "Rick0066"; // Agrega la contraseña aquí
    private $base_datos = "papeleriaJR";
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->usuario, $this->password, $this->base_datos);

        if ($this->conn->connect_error) {
            die("❌ Error de conexión: " . $this->conn->connect_error);
        }
    }

    public function getConexion() {
        return $this->conn;
    }
}
?>
