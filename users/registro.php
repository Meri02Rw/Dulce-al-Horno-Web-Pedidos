<?php
include '../config/config.php'; // Incluye configuración y asegura que la sesión esté iniciada
include '../config/db.php'; // Incluye la conexión a la base de datos
include '../includes/alert.php'; // Incluir alertas
include '../includes/mail_helper.php'; // Incluir helper de correo

$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'] ?: NULL;
$correo = $_POST['correo'];
$contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);

// Validar si el correo ya está registrado
$stmtVerificar = $conn->prepare("SELECT usuario_id FROM usuarios WHERE correo = ?");
$stmtVerificar->bind_param("s", $correo);
$stmtVerificar->execute();
$resultado = $stmtVerificar->get_result();

if ($resultado->num_rows > 0) {
    $_SESSION['mensaje'] = "El correo ya está registrado. Intenta con otro.";
    header("Location: ../pages/cuenta.php");
    exit();
}

// Generar código de verificación y expiración
$codigo = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
$expira = date("Y-m-d H:i:s", strtotime("+10 minutes"));

$conn->begin_transaction();

try {
    $sqlUsuarios = "INSERT INTO usuarios (correo, contraseña, verificacion_codigo, verificacion_expira) VALUES (?, ?, ?, ?)";
    $stmtUsuarios = $conn->prepare($sqlUsuarios);
    $stmtUsuarios->bind_param("ssss", $correo, $contraseña, $codigo, $expira);
    $stmtUsuarios->execute();
    $usuarios_id = $conn->insert_id;

    $sqlClientes = "INSERT INTO clientes (usuario_id, nombre, apellidos) VALUES (?, ?, ?)";
    $stmtClientes = $conn->prepare($sqlClientes);
    $stmtClientes->bind_param("iss", $usuarios_id, $nombre, $apellidos);
    $stmtClientes->execute();

    // Enviar correo
    $enviado = enviarCorreo(
        $correo,
        'Verificación de correo',
        "Tu código de verificación es: $codigo"
    );

    if (!$enviado) {
        throw new Exception("No se pudo enviar el correo.");
    }

    $conn->commit();
    $_SESSION['registro_usuario_id'] = $usuarios_id;
    $_SESSION['mensaje'] = "Se envió un código a tu correo para verificar tu cuenta.";
    header("Location: ../mfa/verificar_registro.php");

} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['mensaje'] = "Error al registrar: " . $e->getMessage();
    header("Location: ../pages/cuenta.php");
}
$stmtUsuarios->close();
$stmtClientes->close();
$conn->close();
?>
