<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contacto</title>
        <link rel="icon" type="image/x-icon" href="resources/icon/Icon_DulceAlHorno_2.jpg">  
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/styles-includes.css">
        <link rel="stylesheet" href="css/styles-contacto.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    </head>
    <body>

        <div class="container-primary">
            <!-- Incluir el banner con PHP -->
            <div id="banner-container">
                <?php include 'includes/banner.php'; ?>
            </div>

            <div class="main-container">
                <h2 class="title">Contacto</h2>
                <section id="contact" class="container text-center mt-5">
                    <p class="contact-description">Ponte en contacto con nosotros a través de los siguientes medios:</p>
                    <ul class="list-unstyled contact-info">
                        <li><i class="bi bi-envelope-check-fill"></i> <span>Correo: test@gmail.com</span></li>
                        <li><i class="bi bi-telephone-fill"></i> <span>Teléfono: +52 123 456 7890</span></li>
                    </ul>
                    
                    <div class="contact-form-container">
                        <form>
                            <div class="form-group">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" placeholder="Escribe tu nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" placeholder="Tu correo" required>
                            </div>
                            <div class="form-group">
                                <label for="mensaje" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="mensaje" rows="3" placeholder="Escribe tu mensaje" required></textarea>
                            </div>
                            <button type="submit" class="btn">Enviar</button>
                        </form>
                    </div>
                </section>
            </div>

            <!-- Incluir el footer con PHP -->
            <div id="footer-container">
                <?php include 'includes/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
