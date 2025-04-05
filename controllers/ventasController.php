<?php
require_once(__DIR__ . '/../models/ventasModel.php');

class VentasController {
    private $ventasModel;

    public function __construct() {
        $this->ventasModel = new VentasModel();
    }

    public function registrarVenta() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cliente_id"]) && isset($_POST["productos"])) {
            $cliente_id = $_POST["cliente_id"];
            $productos = json_decode($_POST["productos"], true);
            $total = 0;

            foreach ($productos as $producto) {
                $total += $producto["cantidad"] * $producto["precio"];
            }

            $venta_id = $this->ventasModel->registrarVenta($cliente_id, $total);
            if ($venta_id) {
                foreach ($productos as $producto) {
                    $this->ventasModel->agregarDetalleVenta($venta_id, $producto["id"], $producto["cantidad"], $producto["precio"]);
                    $this->ventasModel->actualizarStock($producto["id"], $producto["cantidad"]);
                }
                header("Location: ../views/generarFactura.php?venta_id=$venta_id");
                exit();
            } else {
                die("❌ Error al registrar la venta.");
            }
        } else {
            die("❌ Error: Datos incompletos.");
        }
    }
}

$controller = new VentasController();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller->registrarVenta();
}
?>
