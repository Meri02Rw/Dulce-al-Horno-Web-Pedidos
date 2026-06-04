<?php
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensaje'] = "Debes iniciar sesión.";
    header("Location: ../../pages/cuenta.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$correo_admin = 'dulcealhorno@gmail.com';

// Verificar si es admin
$sqlAdminCheck = "SELECT correo FROM usuarios WHERE usuario_id = ?";
$stmtCheck = $conn->prepare($sqlAdminCheck);

$stmtCheck->bind_param("i", $usuario_id);
$stmtCheck->execute();

$resultCheck = $stmtCheck->get_result();

$isAdmin = false;

if ($usuario = $resultCheck->fetch_assoc()) {
    $isAdmin = ($usuario['correo'] === $correo_admin);
}

// Si NO es admin, bloquear acceso
if (!$isAdmin) {
    $_SESSION['mensaje'] = "Acceso denegado.";
    header("Location: ../../pages/cuenta.php");
    exit();
}
?>