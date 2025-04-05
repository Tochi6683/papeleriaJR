<?php
require_once(__DIR__ . '/../models/clientesModel.php');

$clientesModel = new ClientesModel();

// Manejo de solicitudes GET y POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["accion"])) {
        
        // Agregar Cliente
        if ($_POST["accion"] == "agregar") {
            if (!empty($_POST["nombre"]) && !empty($_POST["telefono"]) && !empty($_POST["email"])) {
                $clientesModel->agregarCliente($_POST["nombre"], $_POST["telefono"], $_POST["email"]);
            } else {
                die("❌ Error: Todos los campos son obligatorios.");
            }
        }

        // Editar Cliente
        elseif ($_POST["accion"] == "editar") {
            if (!empty($_POST["id"]) && !empty($_POST["nombre"]) && !empty($_POST["telefono"]) && !empty($_POST["email"])) {
                $clientesModel->editarCliente($_POST["id"], $_POST["nombre"], $_POST["telefono"], $_POST["email"]);
            } else {
                die("❌ Error: Todos los campos son obligatorios.");
            }
        }

        // Eliminar Cliente
        elseif ($_POST["accion"] == "eliminar") {
            if (!empty($_POST["id"])) {
                $clientesModel->eliminarCliente($_POST["id"]);
            } else {
                die("❌ Error: ID del cliente no recibido.");
            }
        }

        // Si la acción no es válida
        else {
            die("❌ Error: Acción no válida.");
        }
    } else {
        die("❌ Error: Acción no definida.");
    }

    // Redirigir de vuelta a la vista de clientes
    header("Location: ../views/clientes.php");
    exit();
}

// Si se accede directamente, obtener todos los clientes
$clientes = $clientesModel->obtenerClientes();
?>
