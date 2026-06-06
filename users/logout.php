<?php
include __DIR__ . '/../includes/alert.php';
include __DIR__ . '/../config/config.php';
session_destroy();

session_start();
$_SESSION['mensaje'] = "Se ha cerrado sesión correctamente";
header("Location: /index.php");
exit();  
