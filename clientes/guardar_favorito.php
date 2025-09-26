<?php
session_start();
include('../includes/conexion.php');

if (!isset($_SESSION['cliente_id'])) {
    header('Location: login_cliente.php');
    exit();
}

$cliente_id = $_SESSION['cliente_id'];
$profesional_id = $_POST['profesional_id'] ?? null;

if ($profesional_id) {
    // Verificamos si ya existe
    $check = $conexion->prepare("SELECT id FROM favoritos WHERE id_cliente = ? AND id_profesional = ?");
    $check->bind_param("ii", $cliente_id, $profesional_id);
    $check->execute();
    $res = $check->get_result();
    
    if ($res->num_rows == 0) {
        $sql = $conexion->prepare("INSERT INTO favoritos (id_cliente, id_profesional) VALUES (?, ?)");
        $sql->bind_param("ii", $cliente_id, $profesional_id);
        $sql->execute();
    }
}

header("Location: ver_profesional.php?id=$profesional_id");
exit();
