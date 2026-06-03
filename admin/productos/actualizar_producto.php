<?php
include '../config/config.php';
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $producto_id = $_POST['producto_id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'] ?? '';
    $estado = $_POST['estado'];

    // Obtener la imagen actual
    $stmt = $conn->prepare("SELECT img_url FROM productos WHERE producto_id = ?");
    $stmt->bind_param("i", $producto_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();
    $img_url = $producto['img_url'];

    // Manejo de la nueva imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $nombreImagen = basename($_FILES['imagen']['name']);
        $rutaDestino = '../resources/img/' . $nombreImagen;
        $ruta = 'resources/img/' . $nombreImagen;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            $img_url = $ruta;
        }
    }

    // Actualizar en la base de datos
    $stmt = $conn->prepare("UPDATE productos SET nombre = ?, precio = ?, descripcion = ?, estado = ?, img_url = ? WHERE producto_id = ?");
    $stmt->bind_param("sdsssi", $nombre, $precio, $descripcion, $estado, $img_url, $producto_id);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Producto actualizado correctamente.";
    } else {
        $_SESSION['mensaje'] = "Error al actualizar el producto.";
    }

    header("Location: productos.php");
    exit();
}
?>