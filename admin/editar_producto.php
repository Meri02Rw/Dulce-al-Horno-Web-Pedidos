<?php
include '../config/config.php';
include '../config/db.php';

// Verificar sesión y rol de admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['correo'] !== 'dulcealhorno@gmail.com') {
    $_SESSION['mensaje'] = "Acceso denegado.";
    header("Location: ../cuenta.php");
    exit();
}

$producto_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM productos WHERE producto_id = ?");
$stmt->bind_param("i", $producto_id);
$stmt->execute();
$result = $stmt->get_result();
$producto = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
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
        <h1 class="title">Editar Producto</h1>
        <form action="actualizar_producto.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="producto_id" value="<?= $producto['producto_id'] ?>">

            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required><br>

            <label>Precio:</label>
            <input type="number" name="precio" step="0.01" value="<?= $producto['precio'] ?>" required><br>

            <label>Descripción:</label>
            <textarea name="descripcion"><?= htmlspecialchars($producto['descripcion']) ?></textarea><br>

            <label>Estado:</label>
            <select name="estado">
                <option value="disponible" <?= $producto['estado'] == 'disponible' ? 'selected' : '' ?>>Disponible</option>
                <option value="no disponible" <?= $producto['estado'] == 'no disponible' ? 'selected' : '' ?>>No disponible</option>
            </select><br>

            <label>Imagen actual:</label><br>
            <?php if ($producto['img_url']): ?>
                <img src="../<?= $producto['img_url'] ?>" alt="Imagen del producto" width="100"><br>
            <?php else: ?>
                <p>No hay imagen disponible.</p>
            <?php endif; ?>

            <label>Cambiar imagen:</label>
            <input type="file" name="imagen" accept="image/*"><br>

            <button style="margin-bottom: 20px;" type="submit">Actualizar Producto</button>
        </form>
        <!-- Incluir el footer con PHP -->
        <div id="footer-container">
            <?php include '../includes/footer.php'; ?>
        </div>
    </div>
</body>
</html>