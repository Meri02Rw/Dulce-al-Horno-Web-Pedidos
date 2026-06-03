<?php
include '../config/config.php';
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $producto_id = $_POST['producto_id'];

    // Eliminar el producto de la base de datos
    $stmt = $conn->prepare("DELETE FROM productos WHERE producto_id = ?");
    $stmt->bind_param("i", $producto_id);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Producto eliminado correctamente.";
    } else {
        $_SESSION['mensaje'] = "Error al eliminar el producto.";
    }

    header("Location: productos.php");
    exit();
}
?>