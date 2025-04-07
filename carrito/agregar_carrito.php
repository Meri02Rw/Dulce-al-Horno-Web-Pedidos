<?php
include __DIR__ . '/../includes/alert.php'; // Incluir alertas
include __DIR__ .  '/../config/config.php'; // Incluye configuración y asegura que la sesión esté iniciada 
include __DIR__ .  '/../config/db.php'; // Incluye la conexión a la base de datos

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['producto_id']) && isset($_POST['cantidad']) && isset($_SESSION['usuario_id'])) {
        $producto_id = $_POST['producto_id'];
        $cantidad = $_POST['cantidad'];
        $usuario_id = $_SESSION['usuario_id']; // El usuario debe estar logueado

        // Consultamos el precio del producto
        $stmt = $conn->prepare("SELECT precio FROM productos WHERE producto_id = ?");
        $stmt->bind_param("i", $producto_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $producto = $result->fetch_assoc();

        if ($producto) {
            // Verificar si el usuario ya tiene un carrito
            $stmt = $conn->prepare("SELECT carrito_id FROM carrito WHERE cliente_id = ?");
            $stmt->bind_param("i", $usuario_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // Si no tiene un carrito, lo creamos
            if ($result->num_rows == 0) {
                // Crear un carrito para el usuario
                $stmt = $conn->prepare("INSERT INTO carrito (cliente_id) VALUES (?)");
                $stmt->bind_param("i", $usuario_id);
                $stmt->execute();
                $carrito_id = $stmt->insert_id; // Obtenemos el ID del nuevo carrito
            } else {
                // Si ya tiene un carrito, obtenemos su carrito_id
                $carrito = $result->fetch_assoc();
                $carrito_id = $carrito['carrito_id'];
            }

            // Verificar si el producto ya está en el carrito
            $stmt = $conn->prepare("SELECT cantidad_producto FROM carrito_productos WHERE producto_id = ? AND carrito_id = ?");
            $stmt->bind_param("ii", $producto_id, $carrito_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Si el producto ya está en el carrito, actualizamos la cantidad
                $producto_existente = $result->fetch_assoc();
                $nueva_cantidad = $producto_existente['cantidad_producto'] + $cantidad;

                // Actualizamos la cantidad en el carrito
                $stmt = $conn->prepare("UPDATE carrito_productos SET cantidad_producto = ? WHERE producto_id = ? AND carrito_id = ?");
                $stmt->bind_param("iii", $nueva_cantidad, $producto_id, $carrito_id);
                $stmt->execute();
            } else {
                // Si el producto no está en el carrito, lo insertamos
                $stmt = $conn->prepare("INSERT INTO carrito_productos (carrito_id, producto_id, cantidad_producto, precio) 
                SELECT ?, ?, ?, p.precio FROM productos p WHERE p.producto_id = ?");
                $stmt->bind_param("iiii", $carrito_id, $producto_id, $cantidad, $producto_id);
                $stmt->execute();
            }

            $_SESSION['mensaje'] = "Producto agregado al carrito.";
        } else {
            $_SESSION['mensaje'] = "Producto no encontrado.";
        }

        // Redirigir al producto para que el mensaje sea visible
        header("Location: ../productos/detalle_producto.php?id=" . $producto_id);
        exit();
    }
}
?>
