<?php
include '../config/config.php'; 
include '../config/db.php'; 
include '../includes/alert.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

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
            header("Location: ../cuenta.php");
            exit();
        }

        if (!password_verify($password, $usuario['contraseña'])) {
            $_SESSION['mensaje'] = "Correo o contraseña incorrectos.";
            header("Location: ../cuenta.php");
            exit();
        }

        // ADMIN sin MFA
        if ($correo === 'dulcealhorno@gmail.com') {
            $_SESSION['mfa_usuario_id'] = $usuario['usuario_id'];
            $_SESSION['correo_mfa'] = $usuario['correo'];
            $_SESSION['mensaje'] = "Usuario ADMIN. Escriba cualquier numero y presione el botón verificar.";
            header("Location: ../mfa/verificar-login.php");
            exit();
        }

        // MFA normal
        $codigo = rand(100000, 999999);
        $expira = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        $updateStmt = $conn->prepare("UPDATE usuarios SET mfa_codigo = ?, mfa_expira = ? WHERE usuario_id = ?");
        $updateStmt->bind_param("ssi", $codigo, $expira, $usuario['usuario_id']);
        $updateStmt->execute();

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'correo.0102@gmail.com';
            $mail->Password = 'ilwkbpjhejumfhbl';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('correo.0102@gmail.com', 'Dulce al Horno');
            $mail->addAddress($usuario['correo']);
            $mail->Subject = 'Tu código de verificación';
            $mail->Body = 'Tu código es: ' . $codigo;

            $mail->send();
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
            exit();
        }

        $_SESSION['mfa_usuario_id'] = $usuario['usuario_id'];
        $_SESSION['correo_mfa'] = $usuario['correo'];
        $_SESSION['mensaje'] = "Se envió un código a tu correo para iniciar sesión.";
        header("Location: ../mfa/verificar-login.php");
        exit();
    } else {
        $_SESSION['mensaje'] = "Usuario no registrado. Regístrate para poder iniciar sesión.";
        header("Location: ../cuenta.php");
        exit();
    }
}
?>