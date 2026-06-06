<?php
include __DIR__ . '/../includes/alert.php'; // Incluir alertas
include __DIR__ . '/../config/config.php'; // Incluye configuración y asegura que la sesión esté iniciada 
include __DIR__ . '/../config/db.php'; // Incluye la conexión a la base de datos
include __DIR__ . '/../includes/cliente_helper.php';

// Verificamos si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensaje'] = "Debes iniciar sesión para ver tus pedidos";
    header("Location: /pages/cuenta.php");
    exit();
}

$cliente_id = obtenerClienteId($conn, $_SESSION['usuario_id']);

if (!$cliente_id) {
    $_SESSION['mensaje'] = "Cliente no encontrado.";
    header("Location: /pages/carrito.php");
    exit();
}

// Obtener pedidos del usuario
$sql = "SELECT p.pedido_id, p.fecha, p.total, p.estado
        FROM pedidos p
        WHERE p.cliente_id = ? ORDER BY p.fecha DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cliente_id);
$stmt->execute();
$result = $stmt->get_result();

$pedidos = [];
while ($row = $result->fetch_assoc()) {
    $pedidos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <link rel="icon" type="image/x-icon" href="/resources/icon/Icon_DulceAlHorno_2.jpg">  
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/styles-pedidos.css">
    <link rel="stylesheet" href="/assets/css/styles-banner-footer.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div>
        
        <!-- Incluir el banner con PHP -->
        <div id="banner-container">
            <?php include __DIR__ . '/../includes/banner.php'; ?>
        </div>
        <div class="main-container">
            <h2 class="title">Mis Pedidos</h2>

            <?php if (count($pedidos) > 0): ?>
                <table class="tabla-pedidos" style="width: 100%; font-family: Arial, sans-serif; font-size: 16px; color: #333; box-shadow: 0 2px 5px rgba(0,0,0,0.1); background-color: #fff; border-radius: 5px; overflow: hidden; border: 1px solid #ddd; margin-top: 20px;">
                    <tr style="background-color: #f2f2f2; font-weight: bold;">
                        <th>Pedido ID</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Ver Detalles</th>
                    </tr>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr style="border-bottom: 1px solid #ddd;" onmouseover="this.style.backgroundColor='#f9f9f9';" onmouseout="this.style.backgroundColor='white';">
                            <td><?= $pedido['pedido_id'] ?></td>
                            <td><?= date("d/m/Y", strtotime($pedido['fecha'])) ?></td>
                            <td>$<?= number_format($pedido['total'], 2) ?></td>
                            <td>
                                <?= ucfirst($pedido['estado']) ?>
                                <?php if ($pedido['estado'] == 'en espera'): ?>
                                    <form method="POST" action="cancelar_pedido.php" onsubmit="return confirmarCancelacion();" style="display:inline-block; margin-left: 10px;">
                                        <input type="hidden" name="pedido_id" value="<?= $pedido['pedido_id'] ?>">
                                        <button type="submit" style="background-color: #e74c3c; color: white; border: none; padding: 5px 10px; cursor: pointer; font-size: 0.85em;">Cancelar</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                            <td><a href="detalles_pedido.php?pedido_id=<?= $pedido['pedido_id'] ?>">Ver Detalles</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No tienes pedidos.</p>
            <?php endif; ?>
        </div>
        <!-- Incluir el footer con PHP -->
        <div id="footer-container">
            <?php include __DIR__ . '/../includes/footer.php'; ?>
        </div>
    </div>
    <script src="/assets/js/script.js"></script>
    <script src="/assets/js/script-alert.js"></script>
    <script>
    function confirmarCancelacion() {
        return confirm("¿Estás seguro de que deseas cancelar este pedido?");
    }
    </script>
</body>
</html>
