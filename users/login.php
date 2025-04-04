<?php
include 'includes/alert.php';
include '../config/config.php'; // Incluye configuración y asegura que la sesión esté iniciada
include '../config/db.php'; // Conectar a la base de datos

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
            // Iniciar sesión y guardar el usuario en la variable de sesión
            $_SESSION['usuario_id'] = $usuario['usuario_id'];
            $_SESSION['correo'] = $usuario['correo'];
            
            $_SESSION['mensaje'] = "Se ha iniciado sesión correctamente";
            header("Location: ../index.php");
            exit();            
        } else {
            $_SESSION['mensaje'] = "Contraseña incorrecta";
            header("Location: ../cuenta.php");
            exit();
        }
    } else {
        $_SESSION['mensaje'] = "Usuario no encontrado";
        header("Location: ../cuenta.php");
        exit();
    }
    
    $stmt->close();
}
?>
