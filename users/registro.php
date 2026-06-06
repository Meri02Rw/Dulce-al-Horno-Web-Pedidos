<?php
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../config/db.php';
include __DIR__ . '/../includes/alert.php';
include __DIR__ . '/../includes/mail_helper.php';

$nombre = trim($_POST['nombre']);
$apellidos = !empty($_POST['apellidos']) ? trim($_POST['apellidos']) : NULL;
$correo = trim($_POST['correo']);
$contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);

// Verificar si ya existe el correo
$stmtVerificar = $conn->prepare(
    "SELECT usuario_id 
     FROM usuarios 
     WHERE correo = ?"
);

$stmtVerificar->bind_param("s", $correo);
$stmtVerificar->execute();

$resultado = $stmtVerificar->get_result();

if ($resultado->num_rows > 0) {

    $_SESSION['mensaje'] =
    "El correo ya está registrado.";
    header("Location: /pages/cuenta.php");
    exit();
}

// Generar código
$codigo = str_pad(
    rand(0, 999999),
    6,
    '0',
    STR_PAD_LEFT
);
$expira = date(
    "Y-m-d H:i:s",
    strtotime("+10 minutes")
);
try {
    // Guardar temporalmente
    $_SESSION['registro_temp'] = [
        'nombre' => $nombre,
        'apellidos' => $apellidos,
        'correo' => $correo,
        'contraseña' => $contraseña,
        'codigo' => $codigo,
        'expira' => $expira
    ];

    // Mandar correo
    $enviado = enviarCorreo(
        $correo,
        'Verificación de correo',
        "Tu código de verificación es: $codigo"
    );
    if (!$enviado) {
        throw new Exception(
            "No se pudo enviar el correo."
        );
    }
    $_SESSION['mensaje'] =
    "Código enviado al correo.";
    header(
        "Location: /mfa/verificar_registro.php"
    );
    exit();
} catch (Exception $e) {
    unset($_SESSION['registro_temp']);
    $_SESSION['mensaje'] =
    "Error: " . $e->getMessage();
    $_SESSION['permitir_verificacion'] = true;
    header(
        "Location: /pages/cuenta.php"
    );
    exit();
}
?>