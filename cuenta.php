<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta</title>
    <link rel="icon" type="image/x-icon" href="resources/icon/Icon_DulceAlHorno_2.jpg">  
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles-banner-footer.css">
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

            <!-- Botón para abrir el modal -->
            <button id="btnAbrirModal">Acceder</button>

            <!-- Incluir el login con PHP -->
            <div id="login-container">
                <?php include 'includes/login-registro.php'; ?>
            </div>

            <a href="./includes/logout.php">Cerrar Sesión</a>
        </div>
        <!-- Incluir el footer con PHP -->
        <div id="footer-container">
            <?php include 'includes/footer.php'; ?>
        </div>
    </div>
    <script src="js/script-login-registro.js"></script>
</body>
</html>