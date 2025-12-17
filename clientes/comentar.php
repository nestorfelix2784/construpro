<?php
session_start();
include('../includes/conexion.php');

// Verificar si el cliente está logueado
if (!isset($_SESSION['cliente_id'])) {
    header('Location: login_cliente.php');
    exit();
}

// Validar datos del formulario
if (isset($_POST['id_profesional'], $_POST['comentario'], $_POST['calificacion'])) {
    $id_cliente = $_SESSION['cliente_id'];
    $id_profesional = $_POST['id_profesional'];
    $comentario = trim($_POST['comentario']);
    $calificacion = $_POST['calificacion'];

    // Validar calificaciones válidas
    $calificaciones_validas = ['1', '2', '3', '4', '5'];

    if ($comentario !== "" && in_array($calificacion, $calificaciones_validas)) {

        // Verificar si el profesional existe
        $stmt_check = $conexion->prepare("SELECT id FROM profesionales WHERE id = ?");
        $stmt_check->bind_param("i", $id_profesional);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $stmt_check->close();

            // Insertar comentario
            $stmt = $conexion->prepare("INSERT INTO comentarios (usuario_id, id_profesional, comentario, calificacion) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiss", $id_cliente, $id_profesional, $comentario, $calificacion);
            $stmt->execute();
            $stmt->close();

            header("Location: ver_profesional.php?id=$id_profesional&comentario=ok");
            exit();

        } else {
            $stmt_check->close();
            echo "⚠️ Error: el profesional no existe.";
        }

    } else {
        echo "⚠️ Comentario vacío o calificación inválida.";
    }

} else {
    echo "⚠️ Faltan datos obligatorios del formulario.";
}
?>
