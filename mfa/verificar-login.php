<?php
include '../includes/alert.php';
include '../config/config.php'; // Configuración general y sesión
include '../config/db.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = $_POST['codigo'];
    $usuario_id = $_SESSION['mfa_usuario_id'];

    $stmt = $conn->prepare("SELECT mfa_codigo, mfa_expira FROM usuarios WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    if ($codigo == $usuario['mfa_codigo'] && strtotime($usuario['mfa_expira']) > time()) {
        $_SESSION['usuario_id'] = $usuario_id;
        $_SESSION['correo'] = $_SESSION['correo'];

        $conn->query("UPDATE usuarios SET mfa_codigo = NULL, mfa_expira = NULL WHERE usuario_id = $usuario_id");

        $_SESSION['mensaje'] = "Sesión iniciada correctamente";
        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION['mensaje'] = "Código inválido o expirado.";
        header("Location: verificar-login.php");
        exit();
    }
}
    include '../includes/verificacion.php';
?>

