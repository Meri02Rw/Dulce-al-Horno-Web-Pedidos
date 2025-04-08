<?php
include __DIR__ . '/../includes/alert.php'; // Incluir alertas
include __DIR__ .  '/../config/config.php'; // Incluye configuración y asegura que la sesión esté iniciada 
include __DIR__ .  '/../config/db.php'; // Incluye la conexión a la base de datos

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensaje'] = "Debes iniciar sesión para confirmar tu pedido.";
    header("Location: ../cuenta.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener el carrito del usuario
$stmt = $conn->prepare("SELECT carrito_id FROM carrito WHERE cliente_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$carrito = $result->fetch_assoc();

if (!$carrito) {
    $_SESSION['mensaje'] = "Tu carrito está vacío.";
    header("Location: carrito.php");
    exit();
}

$carrito_id = $carrito['carrito_id'];

// Obtener los productos del carrito
$stmt = $conn->prepare("SELECT p.producto_id, p.nombre, cp.cantidad_producto, p.precio, p.img_url
                        FROM carrito_productos cp
                        JOIN productos p ON p.producto_id = cp.producto_id
                        WHERE cp.carrito_id = ?");
$stmt->bind_param("i", $carrito_id);
$stmt->execute();
$result = $stmt->get_result();

$productos = [];
$total = 0;

while ($producto = $result->fetch_assoc()) {
    $producto['subtotal'] = $producto['precio'] * $producto['cantidad_producto'];
    $total += $producto['subtotal'];
    $productos[] = $producto;
}

?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="icon" type="image/x-icon" href="/DulceAlHornoWebPedidos/resources/icon/Icon_DulceAlHorno_2.jpg">  
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/styles-banner-footer.css">
    <link rel="stylesheet" href="../css/styles-confirmar-pedido.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div>
        <!-- Incluir el banner con PHP -->
        <div id="banner-container">
            <?php include '../includes/banner.php'; ?>
        </div>
        
        <div class="main-container">
            <h2 class="title">Confirmación de Pedido</h2>
            <?php if (!empty($productos)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td>
                                    <img src="../<?= $producto['img_url'] ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" width="50"><br>
                                    <?= htmlspecialchars($producto['nombre']) ?>
                                </td>
                                <td><?= $producto['cantidad_producto'] ?></td>
                                <td>$<?= number_format($producto['precio'], 2) ?></td>
                                <td>$<?= number_format($producto['subtotal'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <h3>Total: $<?= number_format($total, 2) ?></h3>

                <form action="procesar_pedido.php" method="POST">
                    <input type="hidden" name="carrito_id" value="<?= $carrito_id ?>">
                
                    <div class="checkbox-container">
                        <input type="checkbox" id="aceptar" required>
                        <label for="aceptar">Acepto enviar mi pedido por WhatsApp.</label>
                    </div>
                
                    <button type="submit" id="btnConfirmar" disabled>Confirmar Pedido</button>
                </form>
                
                <script>
                    document.getElementById('aceptar').addEventListener('change', function() {
                        document.getElementById('btnConfirmar').disabled = !this.checked;
                    });
                </script>

            <?php else: ?>
                <p>No hay productos en tu carrito.</p>
            <?php endif; ?>

        </div>
        <!-- Incluir el footer con PHP -->
        <div id="footer-container">
            <?php include '../includes/footer.php'; ?>
        </div>
    </div>
    <script src="js/script-alert.js"></script>
</body>
</html>