<?php
include 'includes/alert.php';
include '../config/config.php'; // Configuración general y sesión
include '../config/db.php'; // Conexión a la base de datos

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT usuario_id, correo, contraseña FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        if (password_verify($password, $usuario['contraseña'])) {

            $codigo = rand(100000, 999999);
            $expira = date("Y-m-d H:i:s", strtotime("+5 minutes"));

            $updateStmt = $conn->prepare("UPDATE usuarios SET mfa_codigo = ?, mfa_expira = ? WHERE usuario_id = ?");
            $updateStmt->bind_param("ssi", $codigo, $expira, $usuario['usuario_id']);
            $updateStmt->execute();

            // Enviar correo
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

            // Guardar el usuario en sesión temporal para MFA
            $_SESSION['mfa_usuario_id'] = $usuario['usuario_id'];
            $_SESSION['correo_mfa'] = $usuario['correo'];

            // Redirigir a la página para ingresar el código MFA
            header("Location: ../mfa/verificar-login.php");
            exit();

        } else {
            $_SESSION['mensaje'] = "Correo o contraseña incorrectos.";
            header("Location: ../cuenta.php");
            exit();
        }
    } else {
        $_SESSION['mensaje'] = "Correo o contraseña incorrectos.";
        header("Location: ../cuenta.php");
        exit();
    }
    
    $stmt->close();
}
?>
