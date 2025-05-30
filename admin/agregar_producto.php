<?php
// Verificar sesión y rol de admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['correo'] !== 'dulcealhorno@gmail.com') {
    $_SESSION['mensaje'] = "Acceso denegado.";
    header("Location: ../cuenta.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link rel="icon" type="image/x-icon" href="../resources/icon/Icon_DulceAlHorno_2.jpg">  
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/styles-banner-footer.css">
    <link rel="stylesheet" href="../css/styles-productos.css">
</head>
<body>
    <div>
        <!-- Incluir el banner con PHP -->
        <div id="banner-container">
            <?php include '../includes/banner.php'; ?>
        </div>
        <h1 class="title">Agregar Producto</h1>
        <form action="guardar_producto.php" method="POST" enctype="multipart/form-data">
            <label>Nombre:</label>
            <input type="text" name="nombre" required><br>

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
            <?php include '../includes/footer.php'; ?>
        </div>
    </div>
</body>
</html>
