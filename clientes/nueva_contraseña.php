<?php
session_start();
if (!isset($_SESSION['reset_email'])) {
    header("Location: recuperar_contraseña.php");
    exit;
}

include_once __DIR__ . '/../includes/conexion.php';

$email = $_SESSION['reset_email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nueva = password_hash($_POST['nueva'], PASSWORD_DEFAULT);

    $stmt = $conexion->prepare("UPDATE clientes SET contraseña = ? WHERE email = ?");
    $stmt->bind_param("ss", $nueva, $email);

    if ($stmt->execute()) {
        $mensaje = "Contraseña actualizada correctamente.";
        session_destroy(); // Cerramos sesión de recuperación
    } else {
        $mensaje = "Error al actualizar la contraseña.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Contraseña</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="contenedor">
        <h2>Establecer Nueva Contraseña</h2>
        <?php if (isset($mensaje)) echo "<p>$mensaje</p>"; ?>
        <?php if (!isset($mensaje) || $mensaje !== "Contraseña actualizada correctamente.") : ?>
            <form method="POST">
                <label>Nueva contraseña:</label>
                <input type="password" name="nueva" required><br>
                <button type="submit">Actualizar</button>
            </form>
        <?php endif; ?>
        <p><a href="login_cliente.php">Volver al login</a></p>
    </div>
</body>
</html>
