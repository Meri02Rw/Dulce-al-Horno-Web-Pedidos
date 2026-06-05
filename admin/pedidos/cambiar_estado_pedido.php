<?php
include __DIR__ . '/../../config/config.php';
include __DIR__ . '/../../config/db.php';

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensaje'] =
    "Debes iniciar sesión para realizar esta acción.";

    header("Location: ../../pages/cuenta.php");
    exit();
}

// Verificar admin
$usuario_id = $_SESSION['usuario_id'];
$correo_admin = 'dulcealhorno@gmail.com';

$sqlAdminCheck =
"SELECT correo
 FROM usuarios
 WHERE usuario_id = ?";

$stmtCheck =
$conn->prepare($sqlAdminCheck);

$stmtCheck->bind_param(
    "i",
    $usuario_id
);

$stmtCheck->execute();

$resultCheck =
$stmtCheck->get_result();

$usuario =
$resultCheck->fetch_assoc();

if (
    !$usuario
    ||
    $usuario['correo']
    !==
    $correo_admin
) {

    $_SESSION['mensaje'] =
    "No tienes permiso.";

    header("Location: ../../pages/cuenta.php");
    exit();
}

// Validar POST
if (
    $_SERVER["REQUEST_METHOD"]
    ===
    "POST"
    &&
    isset(
        $_POST['pedido_id'],
        $_POST['nuevo_estado']
    )
) {

    $pedido_id =
    intval($_POST['pedido_id']);

    $nuevo_estado =
    trim($_POST['nuevo_estado']);

    $estados_validos = [
        'en espera',
        'entregado',
        'no entregado',
        'cancelado'
    ];

    if (
        !in_array(
            $nuevo_estado,
            $estados_validos
        )
    ) {

        $_SESSION['mensaje'] =
        "Estado inválido.";

        header(
            "Location: pedidos_recibidos.php"
        );

        exit();
    }

    // Obtener estado actual
    $stmtEstado =
    $conn->prepare(
        "SELECT estado
         FROM pedidos
         WHERE pedido_id = ?"
    );

    $stmtEstado->bind_param(
        "i",
        $pedido_id
    );

    $stmtEstado->execute();

    $resultadoEstado =
    $stmtEstado->get_result();

    $pedido =
    $resultadoEstado->fetch_assoc();

    if (!$pedido) {

        $_SESSION['mensaje'] =
        "Pedido no encontrado.";

        header(
            "Location: pedidos_recibidos.php"
        );

        exit();
    }

    $estado_actual =
    $pedido['estado'];

    // Bloquear cambios inválidos
    if (
        $estado_actual
        ===
        'entregado'
        &&
        (
            $nuevo_estado === 'cancelado'
            ||
            $nuevo_estado === 'no entregado'
        )
    ) {

        $_SESSION['mensaje'] =
        "No puedes modificar un pedido entregado.";

        header(
            "Location: pedidos_recibidos.php"
        );

        exit();
    }

    if (
        (
            $estado_actual === 'cancelado'
            ||
            $estado_actual === 'no entregado'
        )
        &&
        (
            $nuevo_estado === 'entregado'
            ||
            $nuevo_estado === 'en espera'
        )
    ) {

        $_SESSION['mensaje'] =
        "No puedes reabrir un pedido cerrado.";

        header(
            "Location: pedidos_recibidos.php"
        );

        exit();
    }

    // Restaurar stock
    if (
        (
            $nuevo_estado === 'cancelado'
            ||
            $nuevo_estado === 'no entregado'
        )
        &&
        $estado_actual !== 'cancelado'
        &&
        $estado_actual !== 'no entregado'
    ) {

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
    }

    // Actualizar estado
    $stmt =
    $conn->prepare(
        "UPDATE pedidos
         SET estado = ?
         WHERE pedido_id = ?"
    );

    $stmt->bind_param(
        "si",
        $nuevo_estado,
        $pedido_id
    );

    if ($stmt->execute()) {

        $_SESSION['mensaje'] =
        "Estado actualizado correctamente.";

    } else {

        $_SESSION['mensaje'] =
        "Error al actualizar estado.";
    }

    header(
        "Location: pedidos_recibidos.php"
    );

    exit();

} else {

    $_SESSION['mensaje'] =
    "Datos incompletos.";

    header(
        "Location: pedidos_recibidos.php"
    );

    exit();
}
?>