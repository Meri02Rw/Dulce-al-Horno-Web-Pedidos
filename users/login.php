<?php
session_start(); // Inicia sesión

// Conectar a la base de datos
include '../db/db.php';

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
            
            header("Location: ../index.php"); // Redirigir a la página principal
            exit();
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Usuario no encontrado";
    }
    
    $stmt->close();
}
?>
