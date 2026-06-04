<?php
include '../config/config.php'; 
include '../config/db.php'; 
include '../includes/alert.php'; 
include '../includes/mail_helper.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        if ($usuario['verificado'] != 1) {
            $_SESSION['mensaje'] = "Correo no verificado. Verifícalo para poder iniciar sesión.";
            header("Location: /DulceAlHornoWebPedidos/v4 (mejorada)/cuenta.php");
            exit();
        }

        if (!password_verify($password, $usuario['contraseña'])) {
            $_SESSION['mensaje'] = "Correo o contraseña incorrectos.";
            header("Location: /DulceAlHornoWebPedidos/v4 (mejorada)/cuenta.php");
            exit();
        }

        // ADMIN sin MFA
        if ($correo === 'dulcealhorno@gmail.com') {
            $_SESSION['mfa_usuario_id'] = $usuario['usuario_id'];
            $_SESSION['correo_mfa'] = $usuario['correo'];
            $_SESSION['mensaje'] = "Usuario ADMIN. Escriba cualquier numero y presione el botón verificar.";
            header("Location: /DulceAlHornoWebPedidos/v4 (mejorada)/mfa/verificar_login.php");
            exit();
        }

        // MFA normal
        $codigo = rand(100000, 999999);
        $expira = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        $updateStmt = $conn->prepare("UPDATE usuarios SET mfa_codigo = ?, mfa_expira = ? WHERE usuario_id = ?");
        $updateStmt->bind_param("ssi", $codigo, $expira, $usuario['usuario_id']);
        $updateStmt->execute();

        $enviado = enviarCorreo(
            $correo,
            'Verificación de correo',
            "Tu código de verificación es: $codigo"
        );
        if (!$enviado) {
            $_SESSION['mensaje'] = "No se pudo enviar el correo de verificación.";
            header("Location: /DulceAlHornoWebPedidos/v4 (mejorada)/pages/cuenta.php");
            exit();
        }

        $_SESSION['mfa_usuario_id'] = $usuario['usuario_id'];
        $_SESSION['correo_mfa'] = $usuario['correo'];
        $_SESSION['mensaje'] = "Se envió un código a tu correo para iniciar sesión.";
        header("Location: /DulceAlHornoWebPedidos/v4 (mejorada)/mfa/verificar_login.php");
        exit();
    } else {
        $_SESSION['mensaje'] = "Usuario no registrado. Regístrate para poder iniciar sesión.";
        header("Location: /DulceAlHornoWebPedidos/v4 (mejorada)/pages/cuenta.php");
        exit();
    }
}
?>