<?php
require_once("../models/serviciosModel.php");

$serviciosModel = new ServiciosModel();
$servicios = $serviciosModel->obtenerServicios();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Servicios</title>
    <link rel="stylesheet" href="../assets/styles.css"> <!-- Asegúrate de tener este archivo CSS -->
</head>
<body>
    <h1>📌 Administración de Servicios</h1>

    <!-- Formulario para agregar servicio -->
    <h2>➕ Agregar Nuevo Servicio</h2>
    <form action="../controllers/serviciosController.php" method="POST">
        <label>Nombre del servicio:</label>
        <input type="text" name="nombre" required>

        <label>Descripción:</label>
        <textarea name="descripcion" required></textarea>

        <label>Precio:</label>
        <input type="number" name="precio" step="0.01" required>

        <input type="hidden" name="accion" value="agregar">
        <button type="submit">✅ Guardar Servicio</button>
    </form>

    <!-- Lista de servicios -->
    <h2>📋 Servicios Disponibles</h2>
    <?php if (count($servicios) > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($servicios as $servicio): ?>
                    <tr>
                        <td><?= $servicio["id"] ?></td>
                        <td><?= $servicio["nombre"] ?></td>
                        <td><?= $servicio["descripcion"] ?></td>
                        <td>$<?= number_format($servicio["precio"], 2) ?></td>
                        <td>
                            <!-- Botón para eliminar -->
                            <form action="../controllers/serviciosController.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $servicio["id"] ?>">
                                <input type="hidden" name="accion" value="eliminar">
                                <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este servicio?')">🗑 Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>❌ No hay servicios registrados.</p>
    <?php endif; ?>

    <!-- Botón para volver al inicio -->
    <br>
    <a href="../index.php" class="button">🏠 Volver al Inicio</a>

</body>
</html>
