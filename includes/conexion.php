<?php
$host = 'sjc1.clusters.zeabur.com';
$port = 30308;
$user = 'root';
$password = '953YMoI4cbWOTJjG2uH0yf7l86EN1rzh';
$database = 'zeabur';

$conexion = new mysqli($host, $user, $password, $database, $port);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>

