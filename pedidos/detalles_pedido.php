<?php
include __DIR__ . '/../includes/alert.php'; // Incluir alertas
include __DIR__ .  '/../config/config.php'; // Incluye configuración y asegura que la sesión esté iniciada 
include __DIR__ .  '/../config/db.php'; // Incluye la conexión a la base de datos

// Verificamos si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensaje'] = "Debes iniciar sesión para ver los detalles de tu pedido";
    header("Location: ../cuenta.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Verificamos que el ID del pedido esté presente
if (!isset($_GET['pedido_id'])) {
    $_SESSION['mensaje'] = "Pedido no encontrado";
    header("Location: pedidos.php");
    exit();
}

$pedido_id = $_GET['pedido_id'];

// Obtener detalles del pedido
$sql = "SELECT dp.detalle_id, p.nombre, dp.cantidad_producto, dp.precio, p.img_url, (dp.cantidad_producto * dp.precio) AS total
        FROM detallepedido dp
        JOIN productos p ON p.producto_id = dp.producto_id
        WHERE dp.pedido_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $pedido_id);
$stmt->execute();
$result = $stmt->get_result();

$productos = [];
$total = 0;
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
    $total += $row['total'];
}
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Pedido</title>
    <link rel="icon" type="image/x-icon" href="/DulceAlHornoWebPedidos/resources/icon/Icon_DulceAlHorno_2.jpg">  
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/styles-banner-footer.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div>
        <div id="banner-container">
            <?php include '../includes/banner.php'; ?>
        </div>
        <div class="main-container">
            <h2 class="title">Detalles de Pedido #<?= $pedido_id ?></h2>

            <?php if (count($productos) > 0): ?>
                <table>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                    <?php foreach ($productos as $p): ?>
                        <tr>
                            <td>
                                <img src="../<?= $p['img_url'] ?>" alt="<?= $p['nombre'] ?>" width="50">
                                <?= $p['nombre'] ?>
                            </td>
                            <td><?= $p['cantidad_producto'] ?></td>
                            <td>$<?= number_format($p['precio'], 2) ?></td>
                            <td>$<?= number_format($p['total'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <h3>Total del pedido: $<?= number_format($total, 2) ?></h3>
            <?php else: ?>
                <p>No se encontraron detalles para este pedido.</p>
            <?php endif; ?>
        </div>
        <div id="footer-container">
            <?php include '../includes/footer.php'; ?>
        </div>
    </div>
    <script src="js/script-login-registro.js"></script>
    <script src="js/script-alert.js"></script>
</body>
</html>