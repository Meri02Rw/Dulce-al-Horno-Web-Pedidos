<?php
include '../config/config.php';
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pedido_id'])) {
    $pedido_id = $_POST['pedido_id'];
    $usuario_id = $_SESSION['usuario_id'];

    // Verificar que el pedido pertenece al usuario
    $stmt = $conn->prepare("SELECT * FROM pedidos WHERE pedido_id = ? AND cliente_id = ?");
    $stmt->bind_param("ii", $pedido_id, $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $update = $conn->prepare("UPDATE pedidos SET estado = 'cancelado' WHERE pedido_id = ?");
        $update->bind_param("i", $pedido_id);
        $update->execute();
        $_SESSION['mensaje'] = "El pedido ha sido cancelado.";
    } else {
        $_SESSION['mensaje'] = "No se pudo cancelar el pedido.";
    }

    header("Location: ../pedidos/pedidos.php");
    exit();
}
?>
