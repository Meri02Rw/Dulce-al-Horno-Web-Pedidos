<?php
include '../config/config.php'; // Incluye configuración y asegura que la sesión esté iniciada
include '../config/db.php'; // Conexión a la base de datos

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../cuenta.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener el carrito_id del usuario
$stmt = $conn->prepare("SELECT carrito_id FROM carrito WHERE cliente_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo "Error: No se encontró el carrito del usuario.";
    exit();
}

$carrito_id = $row['carrito_id'];

// Verificar si se enviaron cantidades
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cantidad'])) {
    foreach ($_POST['cantidad'] as $producto_id => $cantidad) {
        if ($cantidad > 0) {
            $stmt = $conn->prepare("UPDATE carrito_productos SET cantidad_producto = ? WHERE carrito_id = ? AND producto_id = ?");
            $stmt->bind_param("iii", $cantidad, $carrito_id, $producto_id);
            $stmt->execute();
        }
    }
}

header("Location: ../carrito.php");
exit();
?>
