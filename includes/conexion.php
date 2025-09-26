<?php
// Configuración de conexión a la base de datos
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "construpro";

// Crear conexión
$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

// Validar conexión
if ($conexion->connect_error) {
    die("❌ Error de conexión con la base de datos: " . $conexion->connect_error);
}

// Opcional: establecer el charset a UTF-8 para evitar problemas con acentos o caracteres especiales
$conexion->set_charset("utf8");
?>
