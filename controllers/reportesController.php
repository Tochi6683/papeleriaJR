<?php
session_start();
include(__DIR__ . '/../config/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tipo_reporte"])) {
    $tipo_reporte = $_POST["tipo_reporte"];

    if ($tipo_reporte == "ventas") {
        // Validar fechas
        $fecha_inicio = isset($_POST["fecha_inicio"]) ? $_POST["fecha_inicio"] : null;
        $fecha_fin = isset($_POST["fecha_fin"]) ? $_POST["fecha_fin"] : null;

        // Construcción de la consulta
        $query = "SELECT ventas.id, clientes.nombre AS cliente, ventas.fecha, ventas.total 
                  FROM ventas 
                  LEFT JOIN clientes ON ventas.cliente_id = clientes.id";
        
        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $query .= " WHERE ventas.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
        }
        
        $query .= " ORDER BY ventas.fecha DESC";

        $result = $conexion->query($query);

        if ($result && $result->num_rows > 0) {
            $_SESSION["reporte_ventas"] = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $_SESSION["error_reporte"] = "No hay datos para mostrar en el rango de fechas seleccionado.";
            $_SESSION["reporte_ventas"] = [];
        }

        header("Location: ../views/reporte_ventas.php");
        exit();
    } 

    elseif ($tipo_reporte == "stock") {
        // Obtener productos con stock bajo
        $query = "SELECT id, nombre, stock FROM productos WHERE stock < 5 ORDER BY stock ASC";
        $result = $conexion->query($query);

        if ($result && $result->num_rows > 0) {
            $_SESSION["reporte_stock"] = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $_SESSION["error_reporte"] = "No hay productos con stock bajo.";
            $_SESSION["reporte_stock"] = [];
        }

        header("Location: ../views/reporte_stock.php");
        exit();
    } 

    else {
        $_SESSION["error_reporte"] = "Tipo de reporte no válido.";
        header("Location: ../views/generar_reporte.php");
        exit();
    }
} else {
    $_SESSION["error_reporte"] = "Error: No se recibió el tipo de reporte.";
    header("Location: ../views/generar_reporte.php");
    exit();
}
?>
