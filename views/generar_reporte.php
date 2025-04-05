<?php
include(__DIR__ . '/../config/conexion.php');
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reporte</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>

    <h2>📊 Generar Reporte</h2>

    <form action="../controllers/reportesController.php" method="POST">
        <label for="tipo_reporte">Selecciona el tipo de reporte:</label>
        <select name="tipo_reporte" id="tipo_reporte" required onchange="mostrarFechas()">
            <option value="ventas">📈 Reporte de Ventas</option>
            <option value="stock">📉 Reporte de Stock Bajo</option>
        </select>

        <div id="fecha_rango" style="display: none;">
            <label for="fecha_inicio">Fecha Inicio:</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio">
            
            <label for="fecha_fin">Fecha Fin:</label>
            <input type="date" name="fecha_fin" id="fecha_fin">
        </div>

        <button type="submit">📄 Generar Reporte</button>
    </form>

    <?php
    if (isset($_SESSION["error_reporte"])) {
        echo "<p style='color: red;'>⚠️ " . $_SESSION["error_reporte"] . "</p>";
        unset($_SESSION["error_reporte"]);
    }
    ?>

    <br>
    <a href="../index.php">🔙 Volver al Menú Principal</a>

    <script>
        function mostrarFechas() {
            var tipoReporte = document.getElementById("tipo_reporte").value;
            var fechaRango = document.getElementById("fecha_rango");
            
            if (tipoReporte === "ventas") {
                fechaRango.style.display = "block";
            } else {
                fechaRango.style.display = "none";
            }
        }
    </script>

</body>
</html>
