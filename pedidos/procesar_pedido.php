<?php
include '../config/config.php';
include '../config/db.php';

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensaje'] = "Debes iniciar sesión para hacer un pedido";
    header("Location: ../cuenta.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$mensajeWhatsApp = "";
$total = 0;

// Obtener carrito y productos
$sql = "SELECT c.carrito_id, cp.producto_id, cp.cantidad_producto, cp.precio, p.nombre
        FROM carrito c
        JOIN carrito_productos cp ON cp.carrito_id = c.carrito_id
        JOIN productos p ON p.producto_id = cp.producto_id
        WHERE c.cliente_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$productos = [];
$carrito_id = null;

while ($row = $result->fetch_assoc()) {
    if (!$carrito_id) {
        $carrito_id = $row['carrito_id'];
    }
    $productos[] = $row;
    $total += $row['precio'] * $row['cantidad_producto'];
}

// Insertar en pedidos
$stmt = $conn->prepare("INSERT INTO pedidos (cliente_id, fecha, total, estado) VALUES (?, NOW(), ?, 'en espera')");
$stmt->bind_param("id", $usuario_id, $total);
$stmt->execute();
$pedido_id = $stmt->insert_id;

// Insertar detalles del pedido
$stmt = $conn->prepare("INSERT INTO detallepedido (pedido_id, producto_id, cantidad_producto, precio) VALUES (?, ?, ?, ?)");

foreach ($productos as $p) {
    $stmt->bind_param("iiid", $pedido_id, $p['producto_id'], $p['cantidad_producto'], $p['precio']);
    $stmt->execute();
    $mensajeWhatsApp .= "- " . $p['nombre'] . " x" . $p['cantidad_producto'] . "\n";
}

// Limpiar el carrito
$conn->query("DELETE FROM carrito_productos WHERE carrito_id = $carrito_id");

// Crear el link de WhatsApp
$mensaje = urlencode("Hola, Dulce al Horno.\nQuiero hacer un pedido:\n\n" . $mensajeWhatsApp . "\nTotal: $" . number_format($total, 2));
$telefono = "5216682216232";
$link = "https://wa.me/$telefono?text=$mensaje";

// Guardar el link en sesión
$_SESSION['mensaje'] = "Tu pedido fue realizado con éxito! Se abrirá WhatsApp automáticamente para que lo envíes.";
$_SESSION['pedido_exitoso'] = true;
$_SESSION['whatsapp_link'] = $link;
header("Location: ../index.php");
exit();
?>
