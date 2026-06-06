<?php
include __DIR__ . '/../config/db.php'; // Conectar a la base de datos

$isCatalogo = basename($_SERVER['PHP_SELF']) === 'catalogo.php';
$productos = [];

// Obtener productos
if (isset($_GET['q']) && !empty(trim($_GET['q']))) {
    $busqueda = "%" . $_GET['q'] . "%";
    $stmt = $conn->prepare("SELECT * FROM productos WHERE estado = 'disponible' AND (nombre LIKE ? OR descripcion LIKE ?)");
    $stmt->bind_param("ss", $busqueda, $busqueda);
    $stmt->execute();
    $resultado = $stmt->get_result();
    echo "<h2>Resultados para: <em>" . htmlspecialchars($_GET['q']) . "</em></h2>";
} else {
    if ($isCatalogo) {
        $resultado = $conn->query("SELECT * FROM productos WHERE estado = 'disponible'");
    } else {
        $resultado = $conn->query("SELECT * FROM productos WHERE estado = 'disponible' ORDER BY RAND() LIMIT 6");
    }
}

if ($resultado->num_rows === 0) {
    $_SESSION['mensaje'] = "No se encontraron productos.";
    header("Location: /index.php");
    exit();
    
}
    
// Mostrar productos
echo '<div class="productos-grid">';
while ($producto = $resultado->fetch_assoc()) { ?>
    <div class="producto-card">
        <?php
        $rutaDetalle = basename($_SERVER['PHP_SELF']) === 'catalogo.php'
            ? '/productos/detalle_producto.php?id=' . $producto['producto_id']
            : '/productos/detalle_producto.php?id=' . $producto['producto_id'];
        ?>

        <a href="<?= $rutaDetalle ?>" style="text-decoration: none; color: inherit;">
            <h3 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 0.5rem; color: #b47945;">
                <?php echo $producto['nombre']; ?>
            </h3>
            <div class="producto-img">
                <?php
                $rutaImg = basename($_SERVER['PHP_SELF']) === 'catalogo.php'
                    ? '/' . $producto['img_url']
                    : '/'. $producto['img_url'];
                ?>

                <?php if (!empty($producto['img_url'])): ?>
                    <img src="<?= htmlspecialchars($rutaImg) ?>" 
                        alt="<?= htmlspecialchars($producto['nombre']) ?>">
                <?php else: ?>
                    <i class="bi bi-image" style="font-size: 40px; color: gray;"></i>
                <?php endif; ?>
            </div>
            <p style="color: #b47945; font-weight: bold;">Precio: $<?php echo number_format($producto['precio'], 2); ?></p>
            <p style="color: #666; font-weight: bold;">Stock: <?php echo (int)$producto['stock']; ?></p>
            <?php if ($producto['stock'] <= 0) {
                echo '<p style="color: red; font-weight: bold;">Agotado</p>';
            } ?>
        </a>
    </div>
<?php }
echo '</div>';
?>