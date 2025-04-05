<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Papelería JR</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #007bff;
            padding: 10px;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin-right: 15px;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        main {
            padding: 20px;
        }
    </style>
</head>
<body>

<nav>
    <a href="?page=dashboard">Inicio</a>
    <a href="?page=tienda">Tienda</a>
    <a href="?page=clientes">Clientes</a>
    <a href="?page=ventas">Ventas</a>
    <a href="?page=factura">Facturar</a>
</nav>

<main>
    <?php include $vista; ?>
</main>

</body>
</html>
