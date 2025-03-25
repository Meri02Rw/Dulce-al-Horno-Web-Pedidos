<!DOCTYPE html>
<html lang="es-MX">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dulce al Horno</title>
        <link rel="icon" type="image/x-icon" href="resources/icon/Icon_DulceAlHorno_2.jpg">  
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/styles-includes.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <style>
            
            .main-img {
                display: flex;
                gap: 30px;
                transition: transform 0.3s ease;
                padding-top: 15px;
                padding-bottom: 0px;
            }

            .main-container-img {
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 20px;
                padding-bottom: 0;
                gap: 20px;
                position: relative;
                z-index: 1;
                background-color: #d4b58c;
            }

            .img-item {
                transform: rotate(var(--rotate-angle));
                border: 5px solid #ffffff;
                transition: transform 0.3s ease;
            }

            .img-item:hover {
                transform: rotate(calc(var(--rotate-angle) * 1.5)) scale(1.05);
            }

            .separador {
                background-color: #5a3d31;
                height: 50px;
                margin: 0;
            }
            .button-img {
                background-color: #6D4C41;
                color: rgb(255, 255, 255);
                padding: 12px;
                font-size: 18px;
                border: none;
                cursor: pointer;
                position: relative;
                z-index: 2;
                border-radius: 5px;
            }

            .button-img:hover {
                background-color: #866357;
            }
            .div-button-img{
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 20px;
            }
            .a-img {
                text-decoration: none;
                font-family: Arial, Helvetica, sans-serif;
            }
        </style>
    </head>
    <body>
        <div class="container-primary">
            <!-- Incluir el banner con PHP -->
            <div id="banner-container">
                <?php include 'includes/banner.php'; ?>
            </div>

            <!-- Imágenes principales -->
            <a href="catalogo.html" class="a-img">
                <div class="main-container-img">
                    <div class="main-img">
                        <img src="resources/img/galletas_corazon_2.jpg" class="img-item" style="--rotate-angle: 30deg;" alt="galletas corazon">
                        <img src="resources/img/pastel_chico_1.jpg" class="img-item" style="--rotate-angle: -25deg;" alt="pastel chico">
                        <img src="resources/img/rosca.jpg" class="img-item" style="--rotate-angle: -10deg;" alt="rosca">
                        <img src="resources/img/galletas_corazon_5.jpg" class="img-item" style="--rotate-angle: 15deg;" alt="galletas corazon">
                    </div>
                </div>
                <div class="div-button-img" style="background-color: #d4b58c;">
                    <button class="button-img"><p style="font-size: 16px;">Comprar</p></button>
                </div>
            </a>
            <div class="separador"></div>
            <div class="main-container">
                <h1 class="title">Algunos de nuestros productos</h1>
                <div>
                <!-- Aquí van algunos productos -->
                </div>
            </div>
            <!-- Incluir el footer con PHP -->
            <div id="footer-container">
                <?php include 'includes/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
