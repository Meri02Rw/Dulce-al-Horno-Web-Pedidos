<?php 
include 'config/config.php'; // Incluye configuración y asegura que la sesión esté iniciada
include 'config/db.php'; // Incluye la conexión a la base de datos
include 'users/login-registro.php'; // Incluir el modal login-registro
include 'includes/alert.php'; // Incluir alertas
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta</title>
    <link rel="icon" type="image/x-icon" href="resources/icon/Icon_DulceAlHorno_2.jpg">  
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles-banner-footer.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div>
        
        <!-- Incluir el banner con PHP -->
        <div id="banner-container">
            <?php include 'includes/banner.php'; ?>
        </div>
        <div class="main-container">
            <h2 class="title">Cuenta</h2>
            <?php
            if (isset($_SESSION['usuario_id'])) {
                $usuario_id = $_SESSION['usuario_id'];
            
                // Obtener datos del cliente
                $sql = ("SELECT c.nombre, c.apellidos, u.correo 
                         FROM clientes c
                         JOIN usuarios u ON c.usuario_id = u.usuario_id
                         WHERE c.usuario_id = $usuario_id");
                $resultado = $conn->query($sql);
                $usuario = $resultado->fetch_assoc();

                $nombre = $usuario['nombre'];
                $apellidos = isset($usuario['apellidos']) ? $usuario['apellidos'] : '';
                $correo = $usuario['correo'];

                // Mostrar datos del usuario
                echo '<p><strong>Nombre:</strong> ' . $nombre . ' ' . $apellidos . '</p>';
                echo '<p><strong>Correo:</strong> ' . $correo . '</p>';
                
                // Botón para ver los pedidos
                echo '<form action="pedidos/pedidos.php" method="get">
                        <button type="submit" class="view-orders-button">Ver mis pedidos</button>
                    </form>';

                // Botón para cerrar sesión
                echo '<form action="users/logout.php" method="get">
                        <button type="submit" class="logout-button">Cerrar Sesión</button>
                    </form>';
            } else {
                // Si no está logueado, mostrar botón de iniciar sesión
                echo '<button id="btnAbrirModal">Acceder</button>'; // Botón para abrir el modal
            }
            ?>
        </div>
        <!-- Incluir el footer con PHP -->
        <div id="footer-container">
            <?php include 'includes/footer.php'; ?>
        </div>
    </div>
    <script src="js/script-login-registro.js"></script>
    <script src="js/script-alert.js"></script>
</body>
</html>