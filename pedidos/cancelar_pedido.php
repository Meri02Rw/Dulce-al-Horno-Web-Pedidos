<?php
include __DIR__ . '/../includes/alert.php'; // Incluir alertas
include __DIR__ .  '/../config/config.php'; // Incluye configuración y asegura que la sesión esté iniciada 
include __DIR__ .  '/../config/db.php'; // Incluye la conexión a la base de datos
include __DIR__ . '/../includes/cliente_helper.php'; 

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensaje'] = "Debes iniciar sesión para hacer un pedido";
    header("Location: ../pages/cuenta.php");
    exit();
}

$cliente_id = obtenerClienteId($conn, $_SESSION['usuario_id']);


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pedido_id'])) {
    $pedido_id = $_POST['pedido_id'];

    // Verificar que el pedido pertenece al usuario
    $stmt = $conn->prepare("SELECT * FROM pedidos WHERE pedido_id = ? AND cliente_id = ?");
    $stmt->bind_param("ii", $pedido_id, $cliente_id);
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
