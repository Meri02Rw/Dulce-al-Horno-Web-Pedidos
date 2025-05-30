<?php
include __DIR__ . '/../includes/alert.php'; // Incluir alertas
include __DIR__ .  '/../config/config.php'; // Incluye configuración y asegura que la sesión esté iniciada 
include __DIR__ .  '/../config/db.php'; // Incluye la conexión a la base de datos

// Verificamos si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensaje'] = "Debes iniciar sesión para ver tus pedidos";
    header("Location: ../cuenta.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener pedidos del usuario
$sql = "SELECT p.pedido_id, p.fecha, p.total, p.estado
        FROM pedidos p
        WHERE p.cliente_id = ? ORDER BY p.fecha DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
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
    <link rel="icon" type="image/x-icon" href="/DulceAlHornoWebPedidos/resources/icon/Icon_DulceAlHorno_2.jpg">  
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/styles-pedidos.css">
    <link rel="stylesheet" href="../css/styles-banner-footer.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div>
        
        <!-- Incluir el banner con PHP -->
        <div id="banner-container">
            <?php include '../includes/banner.php'; ?>
        </div>
        <div class="main-container">
            <h2 class="title">Mis Pedidos</h2>

            <?php if (count($pedidos) > 0): ?>
                <table class="tabla-pedidos">
                    <tr>
                        <th>Pedido ID</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Ver Detalles</th>
                    </tr>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
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
            <?php include '../includes/footer.php'; ?>
        </div>
    </div>
    <script src="js/script-login-registro.js"></script>
    <script src="js/script-alert.js"></script>
    <script>
    function confirmarCancelacion() {
        return confirm("¿Estás seguro de que deseas cancelar este pedido?");
    }
    </script>
</body>
</html>
