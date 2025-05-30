<?php
include '../config/config.php'; // Incluye configuración y asegura que la sesión esté iniciada
include '../config/db.php'; // Incluye la conexión a la base de datos
include '../includes/alert.php'; // Incluir alertas

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = $_POST['codigo'];
    $usuario_id = $_SESSION['registro_usuario_id'];

    $stmt = $conn->prepare("SELECT verificacion_codigo, verificacion_expira FROM usuarios WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    if ($codigo === $usuario['verificacion_codigo'] && strtotime($usuario['verificacion_expira']) > time()) {
        $conn->query("UPDATE usuarios SET verificado = 1, verificacion_codigo = NULL, verificacion_expira = NULL WHERE usuario_id = $usuario_id");
        $_SESSION['mensaje'] = "Correo verificado. Ya puedes iniciar sesión.";
        header("Location: ../cuenta.php");
        exit();
    } else {
        $_SESSION['mensaje'] = "Código inválido o expirado.";
        header("Location: verificar-registro.php");
        exit();
    }
}
include '../includes/verificacion.php';
?>