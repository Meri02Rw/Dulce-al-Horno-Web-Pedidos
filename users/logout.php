<?php
include 'includes/alert.php';
include '../config/config.php';
session_destroy();

session_start();
$_SESSION['mensaje'] = "Se ha cerrado sesión correctamente";
header("Location: ../index.php");
exit();  
?>