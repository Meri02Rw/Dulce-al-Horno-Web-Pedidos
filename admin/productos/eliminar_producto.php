<?php
include __DIR__ . '/../../config/config.php';
include __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $producto_id = $_POST['producto_id'];

    // Obtener imagen antes de eliminar
    $stmt = $conn->prepare("
        SELECT img_url 
        FROM productos 
        WHERE producto_id = ?
    ");

    $stmt->bind_param("i", $producto_id);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $producto = $resultado->fetch_assoc();

    if ($producto) {

        // Ruta física de la imagen
        if (!empty($producto['img_url'])) {

            $rutaImagen = __DIR__ . "/../../" . $producto['img_url'];

            if (file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }
        }

        // Eliminar producto
        $stmtDelete = $conn->prepare("
            DELETE FROM productos 
            WHERE producto_id = ?
        ");

        $stmtDelete->bind_param("i", $producto_id);

        if ($stmtDelete->execute()) {

            $_SESSION['mensaje'] =
                "Producto eliminado correctamente.";

        } else {

            $_SESSION['mensaje'] =
                "Error al eliminar el producto.";
        }

    } else {

        $_SESSION['mensaje'] =
            "Producto no encontrado.";
    }

    header("Location: productos.php");
    exit();
}
?>