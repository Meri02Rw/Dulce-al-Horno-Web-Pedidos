<?php
include '../config/config.php';
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'] ?? '';
    $estado = $_POST['estado'];

    // Manejo de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $nombreImagen = basename($_FILES['imagen']['name']);
        $rutaDestino = '../resources/img/' . $nombreImagen;
        $ruta = 'resources/img/' . $nombreImagen;

        // Mover la imagen al directorio deseado
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            $img_url = $ruta;
        } else {
            $img_url = null;
        }
    } else {
        $img_url = null;
    }

    // Insertar en la base de datos
    $stmt = $conn->prepare("INSERT INTO productos (nombre, precio, descripcion, estado, img_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdsss", $nombre, $precio, $descripcion, $estado, $img_url);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Producto agregado correctamente.";
    } else {
        $_SESSION['mensaje'] = "Error al agregar el producto.";
    }

    header("Location: productos.php");
    exit();
}
?>
