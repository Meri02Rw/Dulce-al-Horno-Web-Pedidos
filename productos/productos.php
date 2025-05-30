<?php
include 'config/db.php'; // Conectar a la base de datos

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
    echo "<p>No se encontraron productos.</p>";
}

// Mostrar productos
echo '<div class="productos-grid">';
while ($producto = $resultado->fetch_assoc()) { ?>
    <div class="producto-card">
        <a href="productos/detalle_producto.php?id=<?php echo $producto['producto_id']; ?>">
            <div class="producto-img">
                <?php if (!empty($producto['img_url'])): ?>
                    <img src="<?= $producto['img_url'] ?>" alt="<?= $producto['nombre'] ?>">
                <?php else: ?>
                    <i class="bi bi-image" style="font-size: 40px; color: gray;"></i>
                <?php endif; ?>
            </div>
            <h3><?php echo $producto['nombre']; ?></h3>
            <p>$<?php echo number_format($producto['precio'], 2); ?></p>
        </a>
    </div>
<?php }
echo '</div>';
?>