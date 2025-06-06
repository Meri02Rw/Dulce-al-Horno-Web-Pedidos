<?php
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../config/db.php';

// Asegúrate de que el usuario esté logueado
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensaje'] = "Debes iniciar sesión para realizar esta acción.";
    header("Location: ../cuenta.php");
    exit();
}

// Solo el admin puede cambiar estados
$usuario_id = $_SESSION['usuario_id'];
$correo_admin = 'dulcealhorno@gmail.com';

$sqlAdminCheck = "SELECT correo FROM usuarios WHERE usuario_id = ?";
$stmtCheck = $conn->prepare($sqlAdminCheck);
$stmtCheck->bind_param("i", $usuario_id);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if (!$usuario = $resultCheck->fetch_assoc() || $usuario['correo'] !== $correo_admin) {
    $_SESSION['mensaje'] = "No tienes permiso para cambiar el estado del pedido.";
    header("Location: ../cuenta.php");
    exit();
}

// Validar datos del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['pedido_id'], $_POST['nuevo_estado'])) {
    $pedido_id = intval($_POST['pedido_id']);
    $nuevo_estado = trim($_POST['nuevo_estado']);

    $estados_validos = ['en espera', 'entregado', 'no entregado', 'cancelado'];

    if (!in_array($nuevo_estado, $estados_validos)) {
        $_SESSION['mensaje'] = "Estado inválido.";
        header("Location: pedidos_recibidos.php");
        exit();
    }

    // Actualizar estado en la base de datos
    $sql = "UPDATE pedidos SET estado = ? WHERE pedido_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nuevo_estado, $pedido_id);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Estado del pedido actualizado correctamente.";
    } else {
        $_SESSION['mensaje'] = "Error al actualizar el estado del pedido.";
    }

    header("Location: pedidos_recibidos.php");
    exit();
} else {
    $_SESSION['mensaje'] = "Datos incompletos.";
    header("Location: pedidos_recibidos.php");
    exit();
}
?>