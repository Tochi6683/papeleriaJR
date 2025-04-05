<?php
class Conexion {
    private static $host = "localhost";
    private static $user = "root";
    private static $pass = ""; // Si tienes contraseña en MySQL, agrégala aquí
    private static $db = "papeleriaJR";
    private static $conn = null;

    public static function conectar() {
        if (self::$conn === null) {
            self::$conn = new mysqli(self::$host, self::$user, self::$pass, self::$db);
            if (self::$conn->connect_error) {
                die("❌ Error de conexión: " . self::$conn->connect_error);
            }
        }
        return self::$conn;
    }
}
?>
