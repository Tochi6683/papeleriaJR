<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- 🔹 Se agregó esto -->
    <title>Papelería JR</title>
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        /* Estilo adicional para el menú de navegación */
        nav {
            background-color: #007bff;
            padding: 10px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .nav-btn {
            background-color: #0056b3;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s;
        }

        .nav-btn:hover {
            background-color: #003d80;
        }

        header, footer {
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
        }

        main {
            padding: 20px;
        }

        /* 🔹 Estilo para el fondo de bienvenida */
        .welcome-container {
            background-image: url('assets/img/papeleriajr.jpg'); /* 🔹 Ruta corregida */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: white;
            padding: 50px;
            text-align: center;
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <header>
        <h1><i class="fas fa-store"></i> Papelería JR</h1>
    </header>

    <nav>
        <a href="?page=dashboard" class="nav-btn"><i class="fas fa-home"></i> Inicio</a>
        <a href="?page=productos" class="nav-btn"><i class="fas fa-box"></i> Productos</a>
        <a href="?page=clientes" class="nav-btn"><i class="fas fa-users"></i> Clientes</a>
        <a href="?page=ventas" class="nav-btn"><i class="fas fa-shopping-cart"></i> Ventas</a>
        <a href="?page=factura" class="nav-btn"><i class="fas fa-file-invoice"></i> Facturar</a>
        <a href="?page=tienda" class="nav-btn"><i class="fas fa-store-alt"></i> Tienda</a>
    </nav>

    <!-- 🔹 Se agregó el div para el fondo de bienvenida -->
    <div class="welcome-container">
        <h1>Bienvenido a su Papelería JR</h1>
        <p>gestionar productos, clientes y ventas.</p>
    </div>

    <main class="container">
        <?php
        $pagina = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
        $ruta = "views/{$pagina}.php";

        if (file_exists($ruta)) {
            include $ruta;
        } else {
            echo "<div class='alert alert-error'>Página no encontrada: <strong>{$pagina}</strong></div>";
        }
        ?>
    </main>

    <footer>
        <p>&copy; 2025 Papelería JR - Todos los derechos reservados</p>
    </footer>

</body>
</html>
