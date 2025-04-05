<?php
require_once(__DIR__ . '/../models/clientesModel.php');

$clientesModel = new ClientesModel();
$clientes = $clientesModel->obtenerClientes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>

    <h2>📋 Lista de Clientes</h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?= $cliente['id'] ?></td>
                <td><?= $cliente['nombre'] ?></td>
                <td><?= $cliente['telefono'] ?></td>
                <td><?= $cliente['email'] ?></td>
                <td>
                    <!-- Formulario para eliminar -->
                    <form action="../controllers/clientesController.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $cliente['id'] ?>">
                        <input type="hidden" name="accion" value="eliminar">
                        <button type="submit">❌ Eliminar</button>
                    </form>

                    <!-- Formulario para editar -->
                    <button onclick="llenarFormulario(<?= $cliente['id'] ?>, '<?= $cliente['nombre'] ?>', '<?= $cliente['telefono'] ?>', '<?= $cliente['email'] ?>')">✏️ Editar</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>➕ Agregar / Editar Cliente</h3>
    <form action="../controllers/clientesController.php" method="POST">
        <input type="hidden" name="id" id="cliente_id">
        <label>Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>

        <label>Teléfono:</label>
        <input type="text" name="telefono" id="telefono" required>

        <label>Email:</label>
        <input type="email" name="email" id="email" required>

        <input type="hidden" name="accion" id="accion" value="agregar">
        <button type="submit" id="boton-submit">Agregar Cliente</button>
    </form>

    <br>
    <a href="../index.php">🏠 Volver al Inicio</a>

    <script>
        function llenarFormulario(id, nombre, telefono, email) {
            document.getElementById("cliente_id").value = id;
            document.getElementById("nombre").value = nombre;
            document.getElementById("telefono").value = telefono;
            document.getElementById("email").value = email;
            document.getElementById("accion").value = "editar";
            document.getElementById("boton-submit").innerText = "Actualizar Cliente";
        }
    </script>

</body>
</html>
