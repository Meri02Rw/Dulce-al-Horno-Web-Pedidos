<?php
include __DIR__ . '/../includes/alert.php';
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (
        isset($_POST['producto_id']) &&
        isset($_POST['cantidad']) &&
        isset($_SESSION['usuario_id'])
    ) {

        $producto_id = intval($_POST['producto_id']);
        $cantidad = intval($_POST['cantidad']);
        $usuario_id = $_SESSION['usuario_id'];

        if ($cantidad <= 0) {
            $_SESSION['mensaje'] = "Cantidad inválida.";
            header("Location: ../index.php");
            exit();
        }

        // Obtener cliente
        $stmt = $conn->prepare("
            SELECT cliente_id 
            FROM clientes 
            WHERE usuario_id = ?
        ");

        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $cliente = $result->fetch_assoc();

        if (!$cliente) {

            $_SESSION['mensaje'] = "Cliente no encontrado.";

            header("Location: ../pages/cuenta.php");
            exit();
        }

        $cliente_id = $cliente['cliente_id'];

        // Obtener producto + stock
        $stmt = $conn->prepare("
            SELECT precio, stock, estado
            FROM productos
            WHERE producto_id = ?
        ");

        $stmt->bind_param("i", $producto_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $producto = $result->fetch_assoc();

        if (!$producto) {

            $_SESSION['mensaje'] = "Producto no encontrado.";

            header("Location: ../index.php");
            exit();
        }

        if ($producto['estado'] !== 'disponible') {

            $_SESSION['mensaje'] =
                "Producto no disponible.";

            header("Location: ../productos/detalle_producto.php?id=" . $producto_id);
            exit();
        }

        if ($producto['stock'] <= 0) {

            $_SESSION['mensaje'] =
                "Producto agotado.";

            header("Location: ../productos/detalle_producto.php?id=" . $producto_id);
            exit();
        }

        if ($cantidad > $producto['stock']) {

            $_SESSION['mensaje'] =
                "Cantidad mayor al stock disponible.";

            header("Location: ../productos/detalle_producto.php?id=" . $producto_id);
            exit();
        }

        // Buscar carrito
        $stmt = $conn->prepare("
            SELECT carrito_id 
            FROM carrito 
            WHERE cliente_id = ?
        ");

        $stmt->bind_param("i", $cliente_id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 0) {

            $stmt = $conn->prepare("
                INSERT INTO carrito (cliente_id)
                VALUES (?)
            ");

            $stmt->bind_param("i", $cliente_id);
            $stmt->execute();

            $carrito_id = $stmt->insert_id;

        } else {

            $carrito = $result->fetch_assoc();

            $carrito_id = $carrito['carrito_id'];
        }

        // Revisar si ya existe en carrito
        $stmt = $conn->prepare("
            SELECT cantidad_producto
            FROM carrito_productos
            WHERE producto_id = ?
            AND carrito_id = ?
        ");

        $stmt->bind_param(
            "ii",
            $producto_id,
            $carrito_id
        );

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $producto_existente =
                $result->fetch_assoc();

            $nueva_cantidad =
                $producto_existente['cantidad_producto']
                + $cantidad;

            if ($nueva_cantidad > $producto['stock']) {

                $_SESSION['mensaje'] =
                    "No hay suficiente stock disponible.";

                header(
                    "Location: ../productos/detalle_producto.php?id=" .
                    $producto_id
                );

                exit();
            }

            $stmt = $conn->prepare("
                UPDATE carrito_productos
                SET cantidad_producto = ?
                WHERE producto_id = ?
                AND carrito_id = ?
            ");

            $stmt->bind_param(
                "iii",
                $nueva_cantidad,
                $producto_id,
                $carrito_id
            );

            $stmt->execute();

        } else {

            $stmt = $conn->prepare("
                INSERT INTO carrito_productos
                (
                    carrito_id,
                    producto_id,
                    cantidad_producto,
                    precio
                )

                SELECT
                    ?,
                    ?,
                    ?,
                    p.precio

                FROM productos p

                WHERE p.producto_id = ?
            ");

            $stmt->bind_param(
                "iiii",
                $carrito_id,
                $producto_id,
                $cantidad,
                $producto_id
            );

            $stmt->execute();
        }

        $_SESSION['mensaje'] =
            "Producto agregado al carrito.";

        header(
            "Location: ../productos/detalle_producto.php?id=" .
            $producto_id
        );

        exit();
    }
}
?>