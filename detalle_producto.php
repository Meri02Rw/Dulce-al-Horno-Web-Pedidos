<?php
session_start();
include 'db/db.php'; // Incluye la conexión a la base de datos

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
    <!-- Incluir el banner con PHP -->
    <div id="banner-container">
        <?php include 'includes/banner.php'; ?>
    </div>

    <div class="main-container">
        <h1><?php echo $producto["nombre"]; ?></h1>
        <img src="<?php echo $producto["img_url"]; ?>" alt="<?php echo $producto["nombre"]; ?>">
        <p>Precio: $<?php echo $producto["precio"]; ?></p>
        <p><?php echo $producto["descripcion"]; ?></p>

        <?php if ($usuario_logueado) { ?>
            <form action="carrito.php" method="POST">
                <input type="hidden" name="producto_id" value="<?php echo $producto_id; ?>">
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
</body>
</html>

<script>
function abrirModal() {
    document.getElementById('modal').style.display = 'block';
}
</script>
