<?php
include __DIR__ . '/../../config/config.php';
include __DIR__ . '/../../config/db.php';
include __DIR__ . '/../../includes/alert.php';
include __DIR__ . '/../../includes/auth_admin.php';

/* Verificar que exista ID */
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['mensaje'] = "Producto no encontrado.";
    header("Location: productos.php");
    exit();
}

$producto_id = $_GET['id'];

$stmt = $conn->prepare("
    SELECT * 
    FROM productos 
    WHERE producto_id = ?
");

$stmt->bind_param("i", $producto_id);
$stmt->execute();

$result = $stmt->get_result();
$producto = $result->fetch_assoc();

/* Validar existencia */
if (!$producto) {
    $_SESSION['mensaje'] = "Producto no encontrado.";
    header("Location: productos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
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
        <div class="main-container">
            <h1 class="title">Editar Producto</h1>
            <form action="actualizar_producto.php" method="POST" enctype="multipart/form-data" class="form-editar-producto" style="margin-top: 30px; display: flex; flex-direction: column; gap: 15px; max-width: 400px;">
                <input type="hidden" name="producto_id" value="<?= $producto['producto_id'] ?>">

                <label>Nombre:</label>
                <input type="text" name="nombre"value="<?= htmlspecialchars($producto['nombre']) ?>"required>

                <label>Precio:</label>
                <input type="number" name="precio" min="0.01" step="0.01" value="<?= $producto['precio'] ?>" required>
                
                <label>Stock:</label>
                <input type="number" name="stock" min="0" value="<?= $producto['stock'] ?>" required><br>

                <label>Descripción:</label>
                <textarea name="descripcion" style="width: 100%; height: 100px;"><?= htmlspecialchars($producto['descripcion']) ?></textarea>

                <label>Estado:</label>
                <select name="estado">
                    <option 
                        value="disponible"
                        <?= $producto['estado'] == 'disponible' ? 'selected' : '' ?>
                    >
                        Disponible
                    </option>
                    <option
                        value="no disponible"
                        <?= $producto['estado'] == 'no disponible' ? 'selected' : '' ?>
                    >
                        No disponible
                    </option>
                </select>

                <label>Imagen actual:</label>
                <?php if (!empty($producto['img_url'])): ?>
                    <img
                        src="/DulceAlHornoWebPedidos/v4 (mejorada)/<?= htmlspecialchars($producto['img_url']) ?>"
                        alt="Imagen producto"
                        width="120"
                    >
                <?php else: ?>

                    <p>No hay imagen disponible.</p>
                <?php endif; ?>

                <label>Cambiar imagen:</label>
                <input
                    type="file"
                    name="imagen"
                    accept="image/*"
                >
                <button 
                    type="submit"
                    style="margin-top:20px;"
                >
                    Actualizar Producto
                </button>
            </form>
        </div>
        <!-- Incluir el footer con PHP -->
        <div id="footer-container">
            <?php include __DIR__ . '/../../includes/footer.php'; ?>
        </div>
    </div>
</body>
</html>