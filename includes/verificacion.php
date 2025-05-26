<?php 
include '../includes/alert.php';
include '../config/config.php'; // Configuración general y sesión
include '../config/db.php'; // Conexión a la base de datos
?>
<!DOCTYPE html>
<html lang="es-MX">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dulce al Horno</title>
        <link rel="icon" type="../image/x-icon" href="../resources/icon/Icon_DulceAlHorno_2.jpg">  
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/styles-banner-footer.css">
        <link rel="stylesheet" href="../css/styles-productos.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    </head>
    <body>        
        <div class="container-primary">
            <!-- Incluir el banner con PHP -->
            <div id="banner-container">
                <?php include '../includes/banner.php'; ?>
            </div>
            <div class="main-container">
                <!-- Formulario de verificación -->
                <form method="POST">
                    <label>Ingresa el código que se envió a tu correo:</label>
                    <input type="text" name="codigo" required style="width: auto;">
                    <button type="submit">Verificar</button>
                </form>
            </div>
            <div id="footer-container">
                <?php include '../includes/footer.php'; ?>
            </div>
        </div>
        <script src="../js/script-alert.js"></script>
    </body>
</html>
