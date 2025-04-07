<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dulce al Horno</title>
    <link rel="icon" type="image/x-icon" href="resources/icon/Icon_DulceAlHorno_2.jpg">  
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles-banner-footer.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <!-- Menú de navegación -->
    <div id="banner-container">
        <ul class="ul-banner">
            <!-- Logo -->
            <li class="logo">
                <img src="/DulceAlHornoWebPedidos/resources/icon/Icon_DulceAlHorno_1.jpg" alt="Icon_DulceAlHorno" usemap="#inicio">
                <map name="inicio">
                    <area shape="rect" coords="0,0,90,90" href="/DulceAlHornoWebPedidos/index.php" alt="Icon_DulceAlHorno">
                </map>
            </li>
    
            <!-- Buscador -->
            <div class="search-container">
                <form class="search-box" method="GET" action="catalogo.php">
                    <input type="text" placeholder="Buscar..." name="q" style="margin: 5px;">
                    <button type="submit" class="bi bi-search" style="color: black;"></button>
                </form>
            </div>

            <!-- Botón de menú para pantallas pequeñas -->
            <button class="menu-toggle" onclick="toggleMenu()"><i class="bi bi-list"></i></button>
    
            <!-- Menú principal -->
            <div class="menu">
                <li class="li-banner"><a href="/DulceAlHornoWebPedidos/index.php"><i class="bi bi-house-door-fill icon-banner"></i>Inicio</a></li>
                <li class="li-banner"><a href="/DulceAlHornoWebPedidos/catalogo.php"><i class="bi bi-journal-text icon-banner"></i>Catálogo</a></li>
                <li class="li-banner"><a href="/DulceAlHornoWebPedidos/contacto.php"><i class="bi bi-envelope-check-fill icon-banner"></i>Contacto</a></li>
                <li class="li-banner"><a href="/DulceAlHornoWebPedidos/cuenta.php"><i class="bi bi-person-fill icon-banner"></i>Cuenta</a></li>
                <li class="li-banner"><a href="/DulceAlHornoWebPedidos/carrito.php"><i class="bi bi-cart-fill icon-banner"></i>Carrito</a></li>
            </div>
        </ul>
    </div>
    <script src="/DulceAlHornoWebPedidos/js/script-banner.js"></script>
</body>
</html>