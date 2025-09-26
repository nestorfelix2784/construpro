<?php
$conexion = new mysqli("127.0.0.1", "root", "", "construpro");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
echo "Conexión exitosa a la base de datos.";
?>
