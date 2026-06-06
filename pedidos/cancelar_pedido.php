<?php
include __DIR__ . '/../includes/alert.php';
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../config/db.php';
include __DIR__ . '/../includes/cliente_helper.php';

if (!isset($_SESSION['usuario_id'])) {

    $_SESSION['mensaje'] =
    "Debes iniciar sesión.";

    header(
        "Location: /pages/cuenta.php"
    );

    exit();
}

$cliente_id =
obtenerClienteId(
    $conn,
    $_SESSION['usuario_id']
);

if (
    $_SERVER['REQUEST_METHOD']
    ===
    'POST'
    &&
    isset($_POST['pedido_id'])
) {

    $pedido_id =
    intval($_POST['pedido_id']);

    // Verificar pedido
    $stmt =
    $conn->prepare(
        "SELECT estado
         FROM pedidos
         WHERE pedido_id = ?
         AND cliente_id = ?"
    );

    $stmt->bind_param(
        "ii",
        $pedido_id,
        $cliente_id
    );

    $stmt->execute();

    $resultado =
    $stmt->get_result();

    if (
        $resultado->num_rows !== 1
    ) {

        $_SESSION['mensaje'] =
        "No se pudo cancelar el pedido.";

        header(
            "Location: /pedidos/pedidos.php"
        );

        exit();
    }

    $pedido =
    $resultado->fetch_assoc();

    // Validaciones
    if (
        $pedido['estado']
        ===
        'cancelado'
    ) {

        $_SESSION['mensaje'] =
        "Este pedido ya estaba cancelado.";

        header(
            "Location: /pedidos/pedidos.php"
        );

        exit();
    }

    if (
        $pedido['estado']
        ===
        'entregado'
    ) {

        $_SESSION['mensaje'] =
        "No puedes cancelar un pedido entregado.";

        header(
            "Location: /pedidos/pedidos.php"
        );

        exit();
    }

    if (
        $pedido['estado']
        ===
        'no entregado'
    ) {

        $_SESSION['mensaje'] =
        "El pedido ya está cerrado.";

        header(
            "Location: /pedidos/pedidos.php"
        );

        exit();
    }

    // Restaurar stock
    $stmtDetalle =
    $conn->prepare(
        "SELECT producto_id,
                cantidad_producto
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

    // Cancelar pedido
    $update =
    $conn->prepare(
        "UPDATE pedidos
        SET estado = 'cancelado'
        WHERE pedido_id = ?
        AND estado = 'en espera'"
    );

    $update->bind_param(
        "i",
        $pedido_id
    );

    $update->execute();

    if (
        $update->affected_rows === 0
    ) {

        $_SESSION['mensaje'] =
        "El pedido ya fue cancelado o cambió de estado.";

        header(
            "Location: /pedidos/pedidos.php"
        );

        exit();
    }

    $_SESSION['mensaje'] =
    "Pedido cancelado correctamente.";

    header(
        "Location: /pedidos/pedidos.php"
    );

    exit();
}
?>