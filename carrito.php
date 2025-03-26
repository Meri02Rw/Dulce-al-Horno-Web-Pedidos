<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="icon" type="image/x-icon" href="resources/icon/Icon_DulceAlHorno_2.jpg">  
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles-includes.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        
    </style>
</head>
<body>
    <div>
        <!-- Incluir el banner con PHP -->
        <div id="banner-container">
            <?php include 'includes/banner.php'; ?>
        </div>
        
        <div class="main-container">
            <div>
                <i class="bi bi-cart-fill" style="color: rgba(53, 59, 59, 0.113); font-size: 300px;"></i>
            </div>
            <!-- Botón para abrir el modal -->
            <button id="btnAbrirModal">Acceder</button>

            <!-- Incluir el login con PHP -->
            <div id="login-container">
                <?php include 'login.php'; ?>
            </div>
        </div>
        <!-- Incluir el footer con PHP -->
        <div id="footer-container">
            <?php include 'includes/footer.php'; ?>
        </div>
    </div>
    <script src="js/script-login.js"></script>
    </div>
</body>
</html>