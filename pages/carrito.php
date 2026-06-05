<?php
include '../config/config.php';
include '../config/db.php';
include '../users/login_registro.php';
include '../includes/alert.php';
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="icon" type="image/x-icon" href="/DulceAlHornoWebPedidos/v4 (mejorada)/resources/icon/Icon_DulceAlHorno_2.jpg"> 
    <link rel="stylesheet" href="/DulceAlHornoWebPedidos/v4 (mejorada)/assets/css/styles.css">
    <link rel="stylesheet" href="/DulceAlHornoWebPedidos/v4 (mejorada)/assets/css/styles-banner-footer.css">
    <link rel="stylesheet" href="/DulceAlHornoWebPedidos/v4 (mejorada)/assets/css/styles-carrito.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div>
        <div id="banner-container">
            <?php include __DIR__ . '/../includes/banner.php'; ?>
        </div>
        <div class="main-container">
            <h2 class="title">Carrito de Compras</h2>
            <div>
                <i class="bi bi-cart-fill" style="color: rgba(53,59,59,0.113); font-size:300px;"></i>
            </div>
            <?php
            if (isset($_SESSION['usuario_id'])) {
                $usuario_id = $_SESSION['usuario_id'];

                // Obtener cliente_id
                $stmtCliente = $conn->prepare("
                    SELECT cliente_id 
                    FROM clientes 
                    WHERE usuario_id = ?
                ");
                $stmtCliente->bind_param("i", $usuario_id);
                $stmtCliente->execute();
                $cliente = $stmtCliente->get_result()->fetch_assoc();

                if ($cliente) {
                    $cliente_id = $cliente['cliente_id'];
                    $stmt = $conn->prepare("
                        SELECT 
                            p.producto_id,
                            p.nombre,
                            cp.cantidad_producto,
                            p.precio,
                            p.img_url
                        FROM carrito_productos cp
                        JOIN productos p 
                            ON p.producto_id = cp.producto_id
                        WHERE cp.carrito_id = (
                            SELECT carrito_id
                            FROM carrito
                            WHERE cliente_id = ?
                        )
                    ");
                    $stmt->bind_param("i", $cliente_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        echo '<form action="../carrito/actualizar_carrito.php" method="POST">';
                        echo '<table>';
                        echo '
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>';
                        echo '<tbody>';
                        while ($producto = $result->fetch_assoc()) {
                            $total = $producto['precio'] * $producto['cantidad_producto'];
                            echo '<tr>';
                            echo '<td>
                                <img src="../' . $producto['img_url'] . '" width="50">
                                <br>
                                ' . htmlspecialchars($producto['nombre']) . '
                            </td>';
                            echo '<td>
                                <form action="../carrito/actualizar_carrito.php" method="POST">
                                    <input 
                                    type="hidden"
                                    name="producto_id"
                                    value="' . $producto['producto_id'] . '">
                                    <input 
                                    type="number"
                                    name="cantidad"
                                    value="' . $producto['cantidad_producto'] . '"
                                    min="1"
                                    required>
                            </td>';
                            echo '<td>$' . number_format($producto['precio'], 2) . '</td>';
                            echo '<td>$' . number_format($total, 2) . '</td>';
                            echo '<td style="display:flex; gap:10px;">
                                    <button
                                    type="submit"
                                    class="btn-actualizar">
                                        Actualizar
                                    </button>
                                </form>
                                <form 
                                action="../carrito/eliminar_carrito.php" 
                                method="GET"
                                onsubmit="return confirm(\'¿Eliminar este producto?\')">
                                    <input
                                    type="hidden"
                                    name="producto_id"
                                    value="' . $producto['producto_id'] . '">
                                    <button
                                    type="submit"
                                    class="btn-eliminar">
                                        Eliminar
                                    </button>
                                </form>
                            </td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '</form>';
                        echo '
                        <form action="/DulceAlHornoWebPedidos/v4 (mejorada)/pedidos/confirmar_pedido.php" method="GET">
                            <button type="submit">
                                Confirmar compra
                            </button>
                        </form>';
                    } else {
                        echo '<p>No hay productos en el carrito.</p>';
                    }
                }
            } else {
                echo '<p>Para acceder al carrito, por favor <button id="btnAbrirModal">inicia sesión</button>.</p>';
            }
            ?>
        </div>
        <div id="footer-container">
            <?php include __DIR__ . '/../includes/footer.php'; ?>
        </div>
    </div>

    <script src="/DulceAlHornoWebPedidos/v4 (mejorada)/assets/js/script-login-registro.js"></script>
    <script src="/DulceAlHornoWebPedidos/v4 (mejorada)/assets/js/script-alert.js"></script>

</body>
</html>