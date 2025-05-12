<?php
$host = 'localhost';
$db = 'login_system';
$user = 'root'; // Cambia según tu configuración
$pass = '';     // Cambia según tu configuración

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
