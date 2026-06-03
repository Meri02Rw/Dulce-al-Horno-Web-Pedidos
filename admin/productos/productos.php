<?php
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../config/db.php';
include __DIR__ . '/../includes/alert.php';

// Verificar sesión y rol de admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['correo'] !== 'dulcealhorno@gmail.com') {
    $_SESSION['mensaje'] = "Acceso denegado.";
    header("Location: ../cuenta.php");
    exit();
}

// Obtener productos de la base de datos
$sql = "SELECT * FROM productos ORDER BY nombre ASC";
$result = $conn->query($sql);

$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
    <link rel="icon" type="image/x-icon" href="../resources/icon/Icon_DulceAlHorno_2.jpg">  
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/styles-banner-footer.css">
    <link rel="stylesheet" href="../css/styles-alert.css">
</head>
<body>
    <div>
        <div id="banner-container">
            <?php include '../includes/banner.php'; ?>
        </div>

        <div class="main-container">
            <h2 class="title">Productos</h2>

            <a href="agregar_producto.php" class="btn-agregar-producto">+ Agregar Producto</a>

            <?php if (count($productos) > 0): ?>
                <div class="lista-productos">
                    <?php foreach ($productos as $producto): ?>
                        <div class="producto-card">
                            <div class="producto-img">
                                <?php if (!empty($producto['img_url'])): ?>
                                    <img src="../<?= htmlspecialchars($producto['img_url']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                                <?php else: ?>
                                    <i class="bi bi-image" style="font-size: 40px; color: gray;"></i>
                                <?php endif; ?>
                            </div>

                            <div class="producto-info">
                                <strong><?= htmlspecialchars($producto['nombre']) ?></strong>
                            </div>

                            <div class="producto-opciones">
                                <form method="POST" action="cambiar_estado_producto.php">
                                    <input type="hidden" name="producto_id" value="<?= $producto['producto_id'] ?>">

                                    <select name="nuevo_estado" onchange="this.form.submit()" class="selector-estado">
                                        <option value="disponible" <?= $producto['estado'] === 'disponible' ? 'selected' : '' ?>>Disponible</option>
                                        <option value="no disponible" <?= $producto['estado'] === 'no disponible' ? 'selected' : '' ?>>No disponible</option>
                                    </select>
                                </form>

                                <a href="editar_producto.php?id=<?= $producto['producto_id'] ?>" class="btn-editar" onclick="return confirm('¿Editar este producto?')">Editar</a>

                                <form method="POST" action="eliminar_producto.php" onsubmit="return confirm('¿Seguro que deseas eliminar este producto?')">
                                    <input type="hidden" name="producto_id" value="<?= $producto['producto_id'] ?>">
                                    <button type="submit" class="btn-eliminar">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No hay productos registrados.</p>
            <?php endif; ?>
        </div>

        <div id="footer-container">
            <?php include '../includes/footer.php'; ?>
        </div>
    </div>
</body>
</html>
