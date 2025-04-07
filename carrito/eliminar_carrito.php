<?php
include '../config/config.php'; // Incluye configuración y asegura que la sesión esté iniciada
include '../config/db.php'; // Conexión a la base de datos

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../cuenta.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

if (isset($_GET['producto_id'])) {
    $producto_id = $_GET['producto_id'];

    // Obtener carrito_id del usuario
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

    // Eliminar el producto del carrito
    $stmt = $conn->prepare("DELETE FROM carrito_productos WHERE carrito_id = ? AND producto_id = ?");
    $stmt->bind_param("ii", $carrito_id, $producto_id);
    $stmt->execute();

    $_SESSION['mensaje'] = "Producto eliminado correctamente.";
}

header("Location: ../carrito.php");
exit();
?>
