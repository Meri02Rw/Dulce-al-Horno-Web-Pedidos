<?php
include '../config/config.php';
include '../config/db.php';
include '../includes/alert.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['registro_temp'])) {
        $_SESSION['mensaje'] =
        "Sesión expirada.";
        header(
            "Location: ../pages/cuenta.php"
        );
        exit();
    }

    $codigoIngresado =
    trim($_POST['codigo']);

    $datos =
    $_SESSION['registro_temp'];

    if (
        $codigoIngresado ===
        $datos['codigo']
        &&
        strtotime(
            $datos['expira']
        ) > time()
    ) {
        $conn->begin_transaction();
        try {
            // Insertar usuario
            $sqlUsuarios = "
            INSERT INTO usuarios
            (
                correo,
                contraseña,
                verificacion_codigo,
                verificacion_expira,
                verificado
            )
            VALUES
            (
                ?,
                ?,
                NULL,
                NULL,
                1
            )
            ";
            $stmtUsuarios =
            $conn->prepare(
                $sqlUsuarios
            );
            $stmtUsuarios->bind_param(
                "ss",
                $datos['correo'],
                $datos['contraseña']
            );
            $stmtUsuarios->execute();
            $usuario_id =
            $conn->insert_id;

            // Insertar cliente
            $sqlClientes = "
            INSERT INTO clientes
            (
                usuario_id,
                nombre,
                apellidos
            )
            VALUES
            (
                ?,
                ?,
                ?
            )
            ";
            $stmtClientes =
            $conn->prepare(
                $sqlClientes
            );
            $stmtClientes->bind_param(

                "iss",
                $usuario_id,
                $datos['nombre'],
                $datos['apellidos']
            );
            $stmtClientes->execute();
            $conn->commit();

            unset(
                $_SESSION['registro_temp']
            );

            $_SESSION['mensaje'] =
            "Correo verificado correctamente. Ya puedes acceder.";
            header(
            "Location: /DulceAlHornoWebPedidos/v4 (mejorada)/pages/cuenta.php"
            );
            exit();
        } catch (Exception $e) {
            $conn->rollback();
            $_SESSION['mensaje'] =
            "Error al crear cuenta.";
            header(
            "Location: ../pages/cuenta.php"
            );
            exit();
        }
    } else {
        $_SESSION['mensaje'] =
        "Código inválido o expirado.";
        header(
        "Location: /DulceAlHornoWebPedidos/v4 (mejorada)/mfa/verificar_registro.php"
        );
        exit();
    }
}
include '../includes/verificacion.php';
?>