<?php
require_once("../models/serviciosModel.php");

$serviciosModel = new ServiciosModel();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["accion"])) {
        if ($_POST["accion"] == "agregar") {
            if (!empty($_POST["nombre"]) && !empty($_POST["descripcion"]) && !empty($_POST["precio"])) {
                $serviciosModel->agregarServicio($_POST["nombre"], $_POST["descripcion"], $_POST["precio"]);
            } else {
                die("❌ Error: Todos los campos son obligatorios.");
            }
        } elseif ($_POST["accion"] == "eliminar") {
            if (!empty($_POST["id"])) {
                $serviciosModel->eliminarServicio($_POST["id"]);
            } else {
                die("❌ Error: ID del servicio no recibido.");
            }
        } else {
            die("❌ Error: Acción no válida.");
        }
    } else {
        die("❌ Error: Acción no definida.");
    }
}

// Redirigir de vuelta a la vista de servicios
header("Location: ../views/servicios.php");
exit();
?>
