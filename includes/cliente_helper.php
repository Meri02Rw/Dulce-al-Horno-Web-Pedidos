<?php

function obtenerClienteId($conn, $usuario_id) {
    $stmt = $conn->prepare("
        SELECT cliente_id
        FROM clientes
        WHERE usuario_id = ?
    ");

    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $cliente = $resultado->fetch_assoc();

    return $cliente['cliente_id'] ?? null;
}

?>