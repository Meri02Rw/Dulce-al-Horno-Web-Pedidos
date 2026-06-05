<?php
include __DIR__ . '/../../config/config.php';
include __DIR__ . '/../../config/db.php';

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensaje'] =
    "Debes iniciar sesión.";
    header(
        "Location: ../../pages/cuenta.php"
    );
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$correo_admin = 'dulcealhorno@gmail.com';

// Verificar admin
$stmtAdmin = $conn->prepare(
    "SELECT correo
     FROM usuarios
     WHERE usuario_id = ?"
);

$stmtAdmin->bind_param(
    "i",
    $usuario_id
);

$stmtAdmin->execute();

$resultAdmin =
$stmtAdmin->get_result();

$isAdmin = false;

if ($usuario = $resultAdmin->fetch_assoc()) {
    if (
        $usuario['correo']
        ===
        $correo_admin
    ) {
        $isAdmin = true;
    }
}

if (!$isAdmin) {
    $_SESSION['mensaje'] =
    "Acceso denegado.";
    header(
        "Location: ../../pages/cuenta.php"
    );
    exit();
}

// Cancelar pedido
if (
    $_SERVER['REQUEST_METHOD']
    ===
    'POST'
    &&
    isset($_POST['pedido_id'])
) {
    $pedido_id =
    intval($_POST['pedido_id']);

    // Verificar existencia
    $stmtPedido =
    $conn->prepare(
        "SELECT estado
         FROM pedidos
         WHERE pedido_id = ?"
    );
    $stmtPedido->bind_param(
        "i",
        $pedido_id
    );
    $stmtPedido->execute();
    $resultado =
    $stmtPedido->get_result();

    if (
        $resultado->num_rows === 1
    ) {
        $pedido =
        $resultado->fetch_assoc();

        // Evitar cancelar dos veces
        if (
            $pedido['estado']
            ===
            'cancelado'
            ||
            $pedido['estado']
            ===
            'entregado'
        ) {
            $_SESSION['mensaje'] =
            "No se puede cancelar este pedido. El pedido ya estaba cancelado o entregado.";
        } else {
        // Restaurar stock de productos del pedido
        $stmtDetalle = $conn->prepare(
            "SELECT producto_id, cantidad_producto
            FROM detallepedido
            WHERE pedido_id = ?"
        );

        $stmtDetalle->bind_param(
            "i",
            $pedido_id
        );

        $stmtDetalle->execute();

        $detalles =
        $stmtDetalle->get_result();

        while (
            $detalle =
            $detalles->fetch_assoc()
        ) {

            $stmtStock =
            $conn->prepare(
                "UPDATE productos
                SET stock = stock + ?
                WHERE producto_id = ?"
            );

            $stmtStock->bind_param(
                "ii",
                $detalle['cantidad_producto'],
                $detalle['producto_id']
            );

            $stmtStock->execute();
        }

        // Cambiar estado a cancelado
        $update =
        $conn->prepare(
            "UPDATE pedidos
            SET estado = 'cancelado'
            WHERE pedido_id = ?"
        );

        $update->bind_param(
            "i",
            $pedido_id
        );

        $update->execute();

        $_SESSION['mensaje'] =
        "Pedido cancelado correctamente y stock restaurado.";
        }
    } else {
        $_SESSION['mensaje'] =
        "Pedido no encontrado.";
    }
    header(
    "Location: /DulceAlHornoWebPedidos/v4 (mejorada)/admin/pedidos/pedidos_recibidos.php"
    );
    exit();
}
?>