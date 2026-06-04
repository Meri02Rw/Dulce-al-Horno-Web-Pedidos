<?php
include __DIR__ . '/../../config/config.php';
include __DIR__ . '/../../config/db.php';
include __DIR__ . '/../../includes/alert.php';
include __DIR__ . '/../../includes/auth_admin.php';

// Obtener productos
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
    <link rel="icon" type="image/x-icon" href="/DulceAlHornoWebPedidos/v4 (mejorada)/resources/icon/Icon_DulceAlHorno_2.jpg">  
    <link rel="stylesheet" href="/DulceAlHornoWebPedidos/v4 (mejorada)/assets/css/styles.css">
    <link rel="stylesheet" href="/DulceAlHornoWebPedidos/v4 (mejorada)/assets/css/styles-banner-footer.css">
    <link rel="stylesheet" href="/DulceAlHornoWebPedidos/v4 (mejorada)/assets/css/styles-alert.css">
</head>
<body>
    <div>
        <div id="banner-container">
            <?php include __DIR__ . '/../../includes/banner.php'; ?>
        </div>

        <div class="main-container" >
            <h2 class="title">Productos</h2>
    
            <form action="/DulceAlHornoWebPedidos/v4 (mejorada)/admin/productos/agregar_producto.php" method="get" style="margin-left: 20px;">
                <button type="submit" class="btn-agregar-producto" class="btn btn-primary">
                    <i class="bi bi-plus" style="margin-right: 5px; font-size: 22px; "></i> Agregar Producto
                </button>
            </form>

            <?php if (count($productos) > 0): ?>
                <div class="lista-productos" 
                style="
                    display: flex;
                    flex-wrap: wrap;
                    gap: 30px;
                    padding: 20px;
                    justify-content: center;
                    align-items: flex-start;
                ">
                
                    <?php foreach ($productos as $producto): ?>
                        <div class="producto-card" 
                        style="
                            border: 1px solid #ccc;
                            border-radius: 8px;
                            padding: 15px;
                            width: 600px;
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                            box-sizing: border-box;
                        ">

                            <div class="producto-info" 
                            style="
                                margin-bottom: 10px;
                                font-weight: bold;
                                font-size: 18px;
                                color: #b47945;
                                text-align: center;
                            ">
                                <strong><?= htmlspecialchars($producto['nombre']) ?></strong>
                            </div>

                            <div class="producto-img" 
                            style="
                                margin-bottom: 15px;
                                width: 100%;
                                height: 200px;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                overflow: hidden;
                            ">

                                <?php if (!empty($producto['img_url'])): ?>
                                    <img 
                                    src="/DulceAlHornoWebPedidos/v4 (mejorada)/<?= htmlspecialchars($producto['img_url']) ?>" 
                                    alt="<?= htmlspecialchars($producto['nombre']) ?>"
                                    style="
                                        max-width: 100%;
                                        max-height: 100%;
                                        object-fit: contain;
                                    ">
                                <?php else: ?>
                                    <i class="bi bi-image" style="font-size: 40px; color: gray;"></i>
                                <?php endif; ?>

                            </div>

                            <div class="producto-opciones" 
                            style="
                                display: flex;
                                gap: 10px;
                                flex-wrap: wrap;
                                justify-content: center;
                            ">

                                <form method="POST" action="/DulceAlHornoWebPedidos/v4 (mejorada)/admin/productos/cambiar_estado_producto.php">
                                    <input type="hidden" name="producto_id" value="<?= $producto['producto_id'] ?>">

                                    <select name="nuevo_estado" onchange="this.form.submit()" class="selector-estado">
                                        <option value="disponible" <?= $producto['estado'] === 'disponible' ? 'selected' : '' ?>>
                                            Disponible
                                        </option>

                                        <option value="no disponible" <?= $producto['estado'] === 'no disponible' ? 'selected' : '' ?>>
                                            No disponible
                                        </option>
                                    </select>
                                </form>

                                <form action="/DulceAlHornoWebPedidos/v4 (mejorada)/admin/productos/editar_producto.php?id=<?= $producto['producto_id'] ?>" method="GET">
                                    <button type="submit" class="btn-editar">
                                        Editar
                                    </button>
                                </form>

                                <form method="POST" action="/DulceAlHornoWebPedidos/v4 (mejorada)/admin/productos/eliminar_producto.php" onsubmit="return confirm('¿Seguro que deseas eliminar este producto?')">
                                    <input type="hidden" name="producto_id" value="<?= $producto['producto_id'] ?>">

                                    <button type="submit" class="btn-eliminar">
                                        Eliminar
                                    </button>
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
            <?php include __DIR__ . '/../../includes/footer.php'; ?>
        </div>
    </div>
</body>
</html>
