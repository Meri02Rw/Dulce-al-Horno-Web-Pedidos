<?php
// Incluir la conexión a la base de datos
include '../db/db.php';

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
    echo "Registro exitoso";
    echo "<div>";
    echo "<a href='/DulceAlHornoWebPedidos/index.php'><button>Inicio</button></a>";
    echo "</div>";

} catch (Exception $e) {
    // Si hay un error, deshacer la transacción
    $conn->rollback();
    echo "Error en el registro: " . $e->getMessage();
}

// Cerrar conexiones
$stmtUsuarios->close();
$stmtClientes->close();
$conn->close();
?>
