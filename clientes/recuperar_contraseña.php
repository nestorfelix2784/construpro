<?php
session_start();
include_once __DIR__ . '/../includes/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $stmt = $conexion->prepare("SELECT id FROM clientes WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['reset_email'] = $email;
        header("Location: nueva_contraseña.php");
        exit;
    } else {
        $mensaje = "El correo no está registrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="contenedor">
        <h2>Recuperar Contraseña</h2>
        <form method="POST">
            <label>Correo registrado:</label>
            <input type="email" name="email" required><br>
            <button type="submit">Enviar</button>
        </form>
        <?php if (isset($mensaje)) echo "<p style='color:red;'>$mensaje</p>"; ?>
        <p><a href="login_cliente.php">Volver al login</a></p>
    </div>
</body>
</html>
