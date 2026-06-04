<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'dulcealhornowebpedidos';

// Crear una conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
