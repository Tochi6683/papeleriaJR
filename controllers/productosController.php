<?php
require_once(__DIR__ . '/../models/productosModel.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["accion"])) {
        $productosModel = new ProductosModel();

        if ($_POST["accion"] == "agregar") {
            if (!empty($_POST["nombre"]) && !empty($_POST["precio"]) && !empty($_POST["stock"])) {
                $productosModel->agregarProducto($_POST["nombre"], $_POST["precio"], $_POST["stock"]);
                header("Location: ../views/productos.php?mensaje=Producto agregado");
                exit();
            } else {
                die("❌ Error: Todos los campos son obligatorios.");
            }
        } elseif ($_POST["accion"] == "eliminar") {
            if (!empty($_POST["id"])) {
                $productosModel->eliminarProducto($_POST["id"]);
                header("Location: ../views/productos.php?mensaje=Producto eliminado");
                exit();
            } else {
                die("❌ Error: ID del producto no recibido.");
            }
        }
    } else {
        die("❌ Error: Acción no válida.");
    }
}
?>
