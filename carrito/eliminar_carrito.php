<?php
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../config/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: /pages/cuenta.php");
    exit();
}

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

if (!$cliente) {
    $_SESSION['mensaje'] = "Cliente no encontrado.";
    header("Location: /pages/carrito.php");
    exit();
}

$cliente_id = $cliente['cliente_id'];

if (isset($_GET['producto_id'])) {

    $producto_id = $_GET['producto_id'];

    // Obtener carrito del cliente
    $stmt = $conn->prepare("
        SELECT carrito_id
        FROM carrito
        WHERE cliente_id = ?
    ");

    $stmt->bind_param("i", $cliente_id);
    $stmt->execute();

    $carrito = $stmt->get_result()->fetch_assoc();

    if ($carrito) {

        $carrito_id = $carrito['carrito_id'];

        $stmt = $conn->prepare("
            DELETE FROM carrito_productos
            WHERE carrito_id = ?
            AND producto_id = ?
        ");

        $stmt->bind_param(
            "ii",
            $carrito_id,
            $producto_id
        );

        $stmt->execute();

        $_SESSION['mensaje'] = "Producto eliminado correctamente.";
    }
}

header("Location: /pages/carrito.php");
exit();
?>