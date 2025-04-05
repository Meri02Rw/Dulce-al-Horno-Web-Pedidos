<?php
include 'config/config.php'; // Incluye configuración y asegura que la sesión esté iniciada
include 'config/db.php'; // Incluye la conexión a la base de datos
include 'includes/login-registro.php'; // Incluir el modal login-registro
include 'includes/alert.php'; // Incluir alertas
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="icon" type="image/x-icon" href="resources/icon/Icon_DulceAlHorno_2.jpg">  
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles-banner-footer.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div>
        <!-- Incluir el banner con PHP -->
        <div id="banner-container">
            <?php include 'includes/banner.php'; ?>
        </div>
        
        <div class="main-container">
            <h2 class="title">Carrito de Compras</h2>
            <div>
                <i class="bi bi-cart-fill" style="color: rgba(53, 59, 59, 0.113); font-size: 300px;"></i>
            </div>

            <?php
            // Verificar si el usuario está logueado
            if (isset($_SESSION['usuario_id'])) {
                $usuario_id = $_SESSION['usuario_id']; // El usuario debe estar logueado

                // Consultar los productos en el carrito
                $stmt = $conn->prepare("SELECT p.producto_id, p.nombre, cp.cantidad_producto, p.precio, p.img_url
                                        FROM carrito_productos cp
                                        JOIN productos p ON p.producto_id = cp.producto_id
                                        WHERE cp.carrito_id = (SELECT carrito_id FROM carrito WHERE cliente_id = ?)");
                $stmt->bind_param("i", $usuario_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo '<form action="carrito/actualizar_carrito.php" method="POST">';
                    echo '<table>';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>Producto</th>';
                    echo '<th>Cantidad</th>';
                    echo '<th>Precio</th>';
                    echo '<th>Total</th>';
                    echo '<th>Acciones</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    while ($producto = $result->fetch_assoc()) {
                        $total = $producto['precio'] * $producto['cantidad_producto'];
                        echo '<tr>';
                        echo '<td>';
                        echo '<img src="' . $producto['img_url'] . '" alt="' . $producto['nombre'] . '" width="50">';
                        echo $producto['nombre'];
                        echo '<td>';
                        echo '<td><input type="number" name="cantidad[' . $producto['producto_id'] . ']" value="' . $producto['cantidad_producto'] . '" min="1" required></td>';
                        echo '<td>' . "$" . number_format($producto['precio'], 2) . '</td>';
                        echo '<td>' . "$" . number_format($total, 2) . '</td>';
                        echo '<td>';
                        echo '<button type="submit" name="actualizar[' . $producto['producto_id'] . ']">Actualizar</button>';
                        echo '<a href="carrito/eliminar_carrito.php?producto_id=' . $producto['producto_id'] . '" onclick="return confirm(\'¿Seguro que quieres eliminar este producto?\')">Eliminar</a>';
                        echo '</td>';                        
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                    echo '</form>';

                    echo '<form action="confirmar_pedido.php" method="POST">';
                    echo '<button type="submit" name="confirmar_compra">Confirmar compra</button>';
                    echo '</form>';
                } else {
                    echo '<p>No hay productos en el carrito.</p>';
                }
            } else {
                echo '<p>Para acceder al carrito, por favor <button id="btnAbrirModal">inicia sesión</button>.</p> ';
            }
            ?>

        </div>
        <!-- Incluir el footer con PHP -->
        <div id="footer-container">
            <?php include 'includes/footer.php'; ?>
        </div>
    </div>
    <script src="js/script-login-registro.js"></script>
</body>
</html>