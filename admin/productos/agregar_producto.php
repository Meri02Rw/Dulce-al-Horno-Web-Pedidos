<?php
include __DIR__ . '/../../config/config.php';
include __DIR__ . '/../../config/db.php';
include __DIR__ . '/../../includes/alert.php';
include __DIR__ . '/../../includes/auth_admin.php';
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link rel="icon" type="image/x-icon" href="/DulceAlHornoWebPedidos/v4 (mejorada)/resources/icon/Icon_DulceAlHorno_2.jpg">  
    <link rel="stylesheet" href="/DulceAlHornoWebPedidos/v4 (mejorada)/assets/css/styles.css">
    <link rel="stylesheet" href="/DulceAlHornoWebPedidos/v4 (mejorada)/assets/css/styles-banner-footer.css">
    <link rel="stylesheet" href="/DulceAlHornoWebPedidos/v4 (mejorada)/assets/css/styles-productos.css">
</head>
<body>
    <div>
        <!-- Incluir el banner con PHP -->
        <div id="banner-container">
            <?php include __DIR__ . '/../../includes/banner.php'; ?>
        </div>
        </div class="main-container">
            <h1 class="title">Agregar Producto</h1>
            <form action="guardar_producto.php" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; max-width: 400px; margin-left: 20px;">
                <label>Nombre:</label>
                <input type="text" name="nombre" required size="30"><br>

                <label>Precio:</label>
                <input type="number" name="precio" step="0.01" required><br>

                <label>Descripción:</label>
                <textarea name="descripcion"></textarea><br>

                <label>Estado:</label>
                <select name="estado">
                    <option value="disponible">Disponible</option>
                    <option value="no disponible">No disponible</option>
                </select><br>

                <label>Imagen:</label>
                <input type="file" name="imagen" accept="image/*"><br>

                <button style="margin-bottom: 20px;" type="submit">Agregar Producto</button>
            </form>
            <!-- Incluir el footer con PHP -->
            <div id="footer-container">
                <?php include __DIR__ . '/../../includes/footer.php'; ?>
            </div>
        </div>
</body>
</html>
