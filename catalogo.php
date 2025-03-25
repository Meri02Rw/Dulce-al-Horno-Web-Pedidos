<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link rel="icon" type="image/x-icon" href="resources/icon/Icon_DulceAlHorno_2.jpg">  
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles-includes.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .producto {
            padding: 50px;
        }
    </style>
</head>
<body>
    <div>
        <!-- Incluir el banner con PHP -->
        <div id="banner-container">
            <?php include 'includes/banner.php'; ?>
        </div>
        <div class="main-container">
            <h1 class="title">Catálogo</h1>
            <div>
            <!-- Aquí van algunos productos -->
                <?php
                include 'db/db.php';  // Incluye la conexión a la base de datos

                // Realizar la consulta SQL para obtener productos
                $query = "SELECT nombre, img_url, precio FROM productos";
                $result = $conn->query($query);

                // Verificar si hay productos
                if ($result->num_rows > 0) {
                    // Mostrar productos
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='producto'>";
                        echo "<img src='" . $row['img_url'] . "' alt='" . $row['nombre'] . "' class='producto-img'>";
                        echo "<p>" . $row['nombre'] . "</p>";
                        echo "<p>$" . $row['precio'] . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "No hay productos disponibles.";
                }

                // Cerrar la conexión
                $conn->close();
                ?>
            </div>
        </div>
        <!-- Incluir el footer con PHP -->
        <div id="footer-container">
            <?php include 'includes/footer.php'; ?>
        </div>
    </div>
</body>
</html>