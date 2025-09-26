<?php
session_start();
include('../includes/conexion.php');

if (!isset($_SESSION['cliente_id'])) {
    header('Location: login_cliente.php');
    exit();
}

$cliente_id = $_SESSION['cliente_id'];
$profesional_id = $_POST['profesional_id'];
$estrellas = intval($_POST['estrellas']);

// Insertar o actualizar la calificación
$check = $conexion->prepare("SELECT id FROM calificaciones WHERE cliente_id = ? AND profesional_id = ?");
$check->bind_param("ii", $cliente_id, $profesional_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    $sql = $conexion->prepare("UPDATE calificaciones SET estrellas = ? WHERE cliente_id = ? AND profesional_id = ?");
    $sql->bind_param("iii", $estrellas, $cliente_id, $profesional_id);
} else {
    $sql = $conexion->prepare("INSERT INTO calificaciones (cliente_id, profesional_id, estrellas) VALUES (?, ?, ?)");
    $sql->bind_param("iii", $cliente_id, $profesional_id, $estrellas);
}
$sql->execute();

header("Location: ver_profesional.php?id=$profesional_id");
exit();
