<?php
// Configuración de conexión a la base de datos
$host = "sjc1.clusters.zeabur.com";
$puerto = "30308";
$usuario = "root";
$contrasena = " 953YMoI4cbWOTJjG2uH0yf7l86EN1rzh";
$base_datos = "zeabur";

// Creacion de la conexión
$conexion = new mysqli($host, $usuario, $contrasena, $base_datos , $puerto);

// Validacion de la conexión
if ($conexion->connect_error) {
    die("❌ Error de conexión con la base de datos: " . $conexion->connect_error);
}


$conexion->set_charset("utf8");
?>
