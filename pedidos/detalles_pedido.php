<?php
include __DIR__ . '/../includes/alert.php'; // Incluir alertas
include __DIR__ . '/../config/config.php'; // Incluye configuración y asegura que la sesión esté iniciada 
include __DIR__ . '/../config/db.php'; // Incluye la conexión a la base de datos
include __DIR__ . '/../includes/cliente_helper.php'; 


// Verificamos si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensaje'] = "Debes iniciar sesión para ver los detalles de tu pedido";
    header("Location: /pages/cuenta.php");
    exit();
}

$cliente_id = obtenerClienteId($conn, $_SESSION['usuario_id']);
$correo_admin = 'dulcealhorno@gmail.com';

$isAdmin = false;
$sqlAdminCheck = "SELECT correo FROM usuarios WHERE usuario_id = ?";
$stmtCheck = $conn->prepare($sqlAdminCheck);
$stmtCheck->bind_param("i", $_SESSION['usuario_id']);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();
if ($usuario = $resultCheck->fetch_assoc()) {
    if ($usuario['correo'] === $correo_admin) {
        $isAdmin = true;
    }
}

// Verificamos que el ID del pedido esté presente
if (!isset($_GET['pedido_id'])) {
    $_SESSION['mensaje'] = "Pedido no encontrado";
    header("Location: pedidos.php");
    exit();
}
$pedido_id = $_GET['pedido_id'];
    // Verificar que el pedido pertenece al usuario
    $stmt = $conn->prepare("SELECT * FROM pedidos WHERE pedido_id = ? AND cliente_id = ?");
    $stmt->bind_param("ii", $pedido_id, $cliente_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1 || $isAdmin) {
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
    } else {
        $_SESSION['mensaje'] = "Este pedido no te pertenece.";
        header("Location: /pedidos/pedidos.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Pedido</title>
    <link rel="icon" type="image/x-icon" href="/resources/icon/Icon_DulceAlHorno_2.jpg">  
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/styles-banner-footer.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div>
        <div id="banner-container">
            <?php include __DIR__ . '/../includes/banner.php'; ?>
        </div>
        <div class="main-container">
            <h2 class="title">Detalles de Pedido #<?= $pedido_id ?></h2>

            <?php if (count($productos) > 0): ?>
                <table class="tabla-pedidos" style="width: 100%; font-family: Arial, sans-serif; font-size: 16px; color: #333; box-shadow: 0 2px 5px rgba(0,0,0,0.1); background-color: #fff; border-radius: 5px; overflow: hidden; border: 1px solid #ddd; margin-top: 20px;">
                    <tr style="background-color: #f2f2f2; font-weight: bold;">
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                    <?php foreach ($productos as $p): ?>
                        <tr style="border-bottom: 1px solid #ddd;" onmouseover="this.style.backgroundColor='#f9f9f9';" onmouseout="this.style.backgroundColor='white';">
                            <td>
                                <img src="<?= $p['img_url'] ?>" alt="<?= $p['nombre'] ?>" width="50">
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
            <?php include __DIR__ . '/../includes/footer.php'; ?>
        </div>
    </div>
    <script src="/assets/js/script.js"></script>
    <script src="/assets/js/script-alert.js"></script>
</body>
</html>