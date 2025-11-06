<?php
$host = 'sjc1.clusters.zeabur.com';
$port = 30308;
$user = 'root';
$password = '953YMoI4cbWOTJjG2uH0yf7l86EN1rzh';
$database = 'zeabur';

$conexion = new mysqli($host, $user, $password, $database, $port);
if ($conexion->connect_error) {
    error_log("Error de conexión: " . $conexion->connect_error);
    header("Location: /error_conexion.php");
    exit();
}
?>

