<?php
require_once(__DIR__ . '/../models/comprasModel.php');

class ComprasController {
    private $comprasModel;

    public function __construct() {
        $this->comprasModel = new ComprasModel();
    }

    public function registrarCompra() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["proveedor_id"]) && isset($_POST["productos"])) {
            $proveedor_id = $_POST["proveedor_id"];
            $productos = json_decode($_POST["productos"], true);

            $total = 0;
            foreach ($productos as $producto) {
                $total += $producto["cantidad"] * $producto["precio"];
            }

            $compra_id = $this->comprasModel->registrarCompra($proveedor_id, $total);
            if ($compra_id) {
                foreach ($productos as $producto) {
                    $this->comprasModel->agregarDetalleCompra($compra_id, $producto["id"], $producto["cantidad"], $producto["precio"]);
                    $this->comprasModel->actualizarStock($producto["id"], $producto["cantidad"]);
                }
                header("Location: ../views/factura_compra.php?compra_id=$compra_id");
                exit();
            } else {
                die("❌ Error al registrar la compra.");
            }
        } else {
            die("❌ Error: Datos incompletos.");
        }
    }
}

$controller = new ComprasController();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller->registrarCompra();
}
?>
