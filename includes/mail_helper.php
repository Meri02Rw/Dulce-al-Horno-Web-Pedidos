<?php
require __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../config/mail_config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarCorreo($destinatario, $asunto, $mensaje)
{
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USER;
        $mail->Password = MAIL_PASS;
        $mail->SMTPSecure = 'tls';
        $mail->Port = MAIL_PORT;

        $mail->setFrom(MAIL_USER, MAIL_FROM_NAME);

        $mail->addAddress($destinatario);

        $mail->Subject = $asunto;
        $mail->Body = $mensaje;

        $mail->send();

        return true;

    } catch (Exception $e) {

        return false;
    }
}