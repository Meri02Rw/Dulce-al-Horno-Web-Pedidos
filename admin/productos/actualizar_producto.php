<?php
include __DIR__ . '/../../config/config.php';
include __DIR__ . '/../../config/db.php';
include __DIR__ . '/../../includes/alert.php';
include __DIR__ . '/../../includes/auth_admin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $producto_id = $_POST['producto_id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $descripcion = $_POST['descripcion'] ?? '';
    $estado = $_POST['estado'];

    // Obtener imagen actual
    $stmt = $conn->prepare("
        SELECT img_url 
        FROM productos 
        WHERE producto_id = ?
    ");

    $stmt->bind_param("i", $producto_id);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $producto = $resultado->fetch_assoc();

    $img_url = $producto['img_url'];

    // Nueva imagen
    if (
        isset($_FILES['imagen']) &&
        $_FILES['imagen']['error'] == 0
    ) {

        $nombreImagen =
            time() . "_" .
            basename($_FILES['imagen']['name']);

        $rutaDestino =
            '../../resources/img/' .
            $nombreImagen;

        $rutaGuardar =
            'resources/img/' .
            $nombreImagen;

        if (
            move_uploaded_file(
                $_FILES['imagen']['tmp_name'],
                $rutaDestino
            )
        ) {

            // Eliminar imagen anterior
            if (!empty($img_url)) {

                $rutaVieja =
                    "../../" . $img_url;

                if (file_exists($rutaVieja)) {
                    unlink($rutaVieja);
                }
            }

            $img_url = $rutaGuardar;
        }
    }

    // Actualizar BD
    $stmtUpdate = $conn->prepare("
        UPDATE productos
        SET nombre = ?,
            precio = ?,
            stock = ?,
            descripcion = ?,
            estado = ?,
            img_url = ?
        WHERE producto_id = ?
    ");

    $stmtUpdate->bind_param(
        "sdisssi",
        $nombre,
        $precio,
        $stock,
        $descripcion,
        $estado,
        $img_url,
        $producto_id
    );

    if ($stmtUpdate->execute()) {

        $_SESSION['mensaje'] =
            "Producto actualizado correctamente.";

    } else {

        $_SESSION['mensaje'] =
            "Error al actualizar el producto.";
    }

    header("Location: productos.php");
    exit();
}
?>