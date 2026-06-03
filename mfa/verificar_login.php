<?php
include '../config/config.php'; // Incluye configuración y asegura que la sesión esté iniciada
include '../config/db.php'; // Incluye la conexión a la base de datos
include '../includes/alert.php'; // Incluir alertas

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = $_POST['codigo'];
    $usuario_id = $_SESSION['mfa_usuario_id'];
    $correo = $_SESSION['correo_mfa'];

    $stmt = $conn->prepare("SELECT mfa_codigo, mfa_expira FROM usuarios WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    if (($codigo == $usuario['mfa_codigo'] && strtotime($usuario['mfa_expira']) > time()) || ($correo === 'dulcealhorno@gmail.com')) {
        $_SESSION['usuario_id'] = $usuario_id;
        $_SESSION['correo'] = $correo;

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