<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link rel="icon" type="image/x-icon" href="../resources/icon/Icon_DulceAlHorno_2.jpg">  
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/styles-banner-footer.css">
    <link rel="stylesheet" href="../assets/css/styles-productos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .producto {
            padding: 50px;
        }
    </style>
</head>
<body>
    <div id="banner-container">
        <?php include __DIR__ . '/../includes/banner.php'; ?>
    </div>

    <div class="main-container">
        <h1 class="title">Catálogo</h1>
        <div class="productos">
            <?php include __DIR__ . '/../productos/productos.php'; ?>
        </div>
    </div>

    <div id="footer-container">
        <?php include __DIR__ . '/../includes/footer.php'; ?>
    </div>
</body>
</html>