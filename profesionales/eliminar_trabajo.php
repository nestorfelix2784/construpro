<?php
session_start();
if (!isset($_SESSION['profesional_id'])) {
    header("Location: login_profesional.php");
    exit();
}

include_once '../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_trabajo = $_POST['id_trabajo'];
    $profesional_id = $_SESSION['profesional_id'];

    // Eliminar fotos físicas
    $stmt = $conexion->prepare("SELECT nombre_archivo FROM fotos_trabajo WHERE trabajo_id = ?");
    $stmt->bind_param("i", $id_trabajo);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $ruta = "../uploads/trabajos/$profesional_id/$id_trabajo/" . $row['nombre_archivo'];
        if (file_exists($ruta)) {
            unlink($ruta);
        }
    }

    // Eliminar registros
    $conexion->query("DELETE FROM fotos_trabajo WHERE trabajo_id = $id_trabajo");
    $conexion->query("DELETE FROM trabajos WHERE id = $id_trabajo AND id_profesional = $profesional_id");

    $_SESSION['mensaje_eliminado'] = "✅ Trabajo eliminado correctamente.";
    header("Location: perfil.php");
    exit;
}
?>

