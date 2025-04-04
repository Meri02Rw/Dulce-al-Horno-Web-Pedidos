<?php
include 'config/db.php'; // Conectar a la base de datos

$sql = "SELECT * FROM productos WHERE estado = 'disponible'";
$resultado = $conn->query($sql);
?>

<?php while ($producto = $resultado->fetch_assoc()) { ?>
    <div class="producto">
        <a href="detalle_producto.php?id=<?php echo $producto['producto_id']; ?>">
            <img src="<?php echo $producto['img_url']; ?>" alt="<?php echo $producto['nombre']; ?>">
            <h2><?php echo $producto['nombre']; ?></h2>
            <p>$<?php echo $producto['precio']; ?></p>
        </a>
    </div>
<?php } ?>
