<?php
class Database {
    private static $host = "localhost"; // Cambia si tu servidor es diferente
    private static $db_name = "papeleriajr"; // Asegúrate de que el nombre es correcto
    private static $username = "root"; // Usuario de la BD
    private static $password = ""; // Si tienes contraseña, agrégala aquí
    private static $conn = null;

    public static function getConnection() {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$db_name, self::$username, self::$password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                die("❌ Error de conexión a la base de datos: " . $exception->getMessage());
            }
        }
        return self::$conn;
    }
}
?>
