<?php
include '../config/config.php';
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $producto_id = $_POST['producto_id'];

    // Obtener el estado actual
    $stmt = $conn->prepare("SELECT estado FROM productos WHERE producto_id = ?");
    $stmt->bind_param("i", $producto_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();

    // Alternar el estado
    $nuevo_estado = ($producto['estado'] == 'disponible') ? 'no disponible' : 'disponible';

    // Actualizar el estado en la base de datos
    $stmt = $conn->prepare("UPDATE productos SET estado = ? WHERE producto_id = ?");
    $stmt->bind_param("si", $nuevo_estado, $producto_id);
    $stmt->execute();

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Se actualizo el estado del producto correctamente.";
    } else {
        $_SESSION['mensaje'] = "Error al actualizar  el estado del producto.";
    }

    header("Location: productos.php");
    exit();
}
?>