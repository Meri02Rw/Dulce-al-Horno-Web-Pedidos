<?php
include '../config/config.php'; // Incluye configuración y asegura que la sesión esté iniciada
include '../config/db.php'; // Conectar a la base de datos

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$correo = $_POST['correo'];
$contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT); // Encriptar contraseña

// Iniciar transacción
$conn->begin_transaction();

try {
    // Insertar en la tabla usuarios
    $sqlUsuarios = "INSERT INTO usuarios (correo, contraseña, google_id) VALUES (?, ?, NULL)";
    $stmtUsuarios = $conn->prepare($sqlUsuarios);
    $stmtUsuarios->bind_param("ss", $correo, $contraseña);
    $stmtUsuarios->execute();

    // Obtener el ID del usuario recién insertado
    $usuarios_id = $conn->insert_id;

    // Insertar en la tabla clientes
    if (empty($apellidos)) {
        $apellidos = NULL;
    }

    $sqlClientes = "INSERT INTO clientes (usuario_id, nombre, apellidos) VALUES (?, ?, ?)";
    $stmtClientes = $conn->prepare($sqlClientes);
    $stmtClientes->bind_param("iss", $usuarios_id, $nombre, $apellidos);
    $stmtClientes->execute();

    // Confirmar transacción
    $conn->commit();
    $_SESSION['mensaje'] = "Registro exitoso. Ahora puedes iniciar sesión.";
    header("Location: ../cuenta.php");

} catch (Exception $e) {
    // Si hay un error, deshacer la transacción
    $conn->rollback();
    $_SESSION['mensaje'] = "Error al registrar usuario.";
    header("Location: ../cuenta.php");
}

// Cerrar conexiones
$stmtUsuarios->close();
$stmtClientes->close();
$conn->close();
?>
