<?php
include 'config/config.php'; // Incluye configuración y asegura que la sesión esté iniciada
include 'config/db.php'; // Incluye la conexión a la base de datos
include 'includes/alert.php'; // Incluir alertas

if (!isset($_GET["id"])) {
    die("Producto no encontrado.");
}

$producto_id = $_GET["id"];
$sql = "SELECT * FROM productos WHERE producto_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $producto_id);
$stmt->execute();
$resultado = $stmt->get_result();
$producto = $resultado->fetch_assoc();

if (!$producto) {
    die("Producto no encontrado.");
}

$usuario_logueado = isset($_SESSION["usuario_id"]);
?>


<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $producto["nombre"]; ?></title>
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
            <h2 class="title"><?= htmlspecialchars($producto['nombre']) ?></h2>
            <img src="<?= htmlspecialchars($producto['img_url']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" width="200">
            <p>Precio: $<?= number_format($producto['precio'], 2) ?></p>
            <p><?= nl2br(htmlspecialchars($producto['descripcion'])) ?></p>


            <?php if ($usuario_logueado) { ?>
                <form action="carrito/agregar_carrito.php" method="POST">
                    <input type="hidden" name="producto_id" value="<?= $producto_id ?>">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" id="cantidad" name="cantidad" value="1" min="1" required>
                    <button type="submit">Agregar al carrito</button>
                </form>
            <?php } else { ?>
                <p>Debes <a href="cuenta.php" onclick="abrirModal()">iniciar sesión</a> para comprar.</p>
            <?php } ?>

        </div>
        <!-- Incluir el footer con PHP -->
        <div id="footer-container">
            <?php include 'includes/footer.php'; ?>
        </div>
    </div>
    <script src="js/script-login-registro.js"></script>
</body>
</html>
<script>
function abrirModal() {
    document.getElementById('modal-productos').style.display = 'block';
}
</script>