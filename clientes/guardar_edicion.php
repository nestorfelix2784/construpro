<?php
session_start();
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login_cliente.php");
    exit();
}

include_once __DIR__ . '/../includes/conexion.php';

// Validar datos
$cliente_id = $_SESSION['cliente_id'];
$nombre     = trim($_POST['nombre'] ?? '');
$email      = trim($_POST['email'] ?? '');
$telefono   = trim($_POST['telefono'] ?? '');
$direccion  = trim($_POST['direccion'] ?? '');

// Podés agregar validaciones adicionales si querés (email válido, etc.)

$stmt = $conexion->prepare("
  UPDATE clientes
  SET nombre = ?, email = ?, telefono = ?, direccion = ?
  WHERE id = ?
");
$stmt->bind_param("ssssi", $nombre, $email, $telefono, $direccion, $cliente_id);
$stmt->execute();

// Redirigir de nuevo al perfil
header("Location: perfil.php?actualizado=1");
exit();
