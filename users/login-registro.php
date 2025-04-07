<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dulce al Horno</title>
    <link rel="icon" type="image/x-icon" href="resources/icon/Icon_DulceAlHorno_2.jpg">  
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles-login-registro.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <!-- Modal de Inicio de Sesión / Registro -->
    <div id="modal" class="modal" style="display: none;">
        <div class="modal-contenido">
            <span class="cerrar" id="cerrarModal">&times;</span>

            <!-- Botones para cambiar entre Login y Registro -->
            <div class="botones">
                <button id="btnLogin" class="activo">Iniciar Sesión</button>
                <button id="btnRegistro">Registrarse</button>
            </div>

            <!-- Formulario de Inicio de Sesión -->
            <form id="formLogin" class="formulario" action="users/login.php" method="POST">
                <h2>Iniciar Sesión</h2>
                <input type="email" name="correo" placeholder="Correo electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit">Entrar</button>
            </form>

            <!-- Formulario de Registro (Oculto por defecto) -->
            <form id="formRegistro" class="formulario oculto" action="users/registro.php" method="POST">
                <h2>Registrarse</h2>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre" required>
                <input type="text" name="apellidos" id="apellidos" placeholder="Apellidos">
                <input type="email" name="correo" id="correo" placeholder="Correo electrónico" required>
                <input type="password" name="contraseña" id="contraseña" placeholder="Contraseña" required>
                <button type="submit" id="btnRegistroForm">Registrarse</button>
            </form> 
        </div>
    </div>
</body>
</html>