<?php
include __DIR__ . '/../includes/alert.php';
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../config/db.php';

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensaje'] = "Debes iniciar sesión para ver los pedidos";
    header("Location: ../cuenta.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$correo_admin = 'dulcealhorno@gmail.com';

$isAdmin = false;
$sqlAdminCheck = "SELECT correo FROM usuarios WHERE usuario_id = ?";
$stmtCheck = $conn->prepare($sqlAdminCheck);
$stmtCheck->bind_param("i", $usuario_id);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();
if ($usuario = $resultCheck->fetch_assoc()) {
    if ($usuario['correo'] === $correo_admin) {
        $isAdmin = true;
    }
}

// Si es admin, obtiene todos los pedidos
if ($isAdmin) {
    $sql = "SELECT p.pedido_id, p.fecha, p.total, p.estado, c.nombre, c.apellidos 
            FROM pedidos p 
            INNER JOIN clientes c ON p.cliente_id = c.usuario_id
            ORDER BY p.fecha DESC";
    $stmt = $conn->prepare($sql);
} else {
    $_SESSION['mensaje'] = "Acceso denegado.";
    header("Location: ../cuenta.php");
    exit();
}

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
        <title>Pedidos Recibidos</title>
        <link rel="icon" type="image/x-icon" href="/DulceAlHornoWebPedidos/resources/icon/Icon_DulceAlHorno_2.jpg">  
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/styles-pedidos.css">
        <link rel="stylesheet" href="../css/styles-banner-footer.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    </head>
    <body>
        <div>
            <div id="banner-container">
                <?php include '../includes/banner.php'; ?>
            </div>
            <div class="main-container">
                <h2 class="title">Pedidos Recibidos</h2>
                <?php if (count($pedidos) > 0): ?>
                    <div class="cards-container">
                        <?php foreach ($pedidos as $pedido): ?>
                            <div class="pedido-card">
                                <h3>Pedido #<?= $pedido['pedido_id'] ?> - <?= htmlspecialchars($pedido['nombre'] . ' ' . $pedido['apellidos']) ?></h3>
                                <p><strong>Fecha:</strong> <?= date("d/m/Y", strtotime($pedido['fecha'])) ?></p>
                                <p><strong>Total:</strong> $<?= number_format($pedido['total'], 2) ?></p>
                                <p><strong>Estado actual:</strong> <?= ucfirst($pedido['estado']) ?></p>

                                <div class="card-buttons">
                                    <!-- Cambiar estado -->
                                    <form method="POST" action="cambiar_estado.php" onsubmit="return confirmarCambioEstado();">
                                        <input type="hidden" name="pedido_id" value="<?= $pedido['pedido_id'] ?>">
                                        <select name="nuevo_estado">
                                            <?php
                                            $estados = ['en espera', 'entregado', 'no entregado', 'cancelado'];
                                            foreach ($estados as $estado) {
                                                $selected = ($pedido['estado'] == $estado) ? "selected" : "";
                                                echo "<option value='$estado' $selected>" . ucfirst($estado) . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <button type="submit">Actualizar</button>
                                    </form>

                                    <!-- Cancelar pedido -->
                                    <?php if ($pedido['estado'] == 'en espera'): ?>
                                        <form method="POST" action="cancelar_pedido.php" onsubmit="return confirmarCancelacion();">
                                            <input type="hidden" name="pedido_id" value="<?= $pedido['pedido_id'] ?>">
                                            <button type="submit" class="cancelar">Cancelar</button>
                                        </form>
                                    <?php endif; ?>

                                    <!-- Ver detalles -->
                                    <a href="detalles_pedido.php?pedido_id=<?= $pedido['pedido_id'] ?>">Ver Detalles</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No hay pedidos registrados.</p>
                <?php endif; ?>

            </div>
            <div id="footer-container">
                <?php include '../includes/footer.php'; ?>
            </div>

        </div>
        <script>
        function confirmarCancelacion() {
            return confirm("¿Estás seguro de que deseas cancelar este pedido?");
        }
        function confirmarCambioEstado() {
            return confirm("¿Estás seguro de que deseas cambiar el estado de este pedido?");
        }
        </script>
    </body>
</html>
