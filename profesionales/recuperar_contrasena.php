<?php
include_once '../includes/conexion.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $nueva_contraseña = $_POST['nueva_contraseña'] ?? '';

    if (!empty($email) && !empty($nueva_contraseña)) {
        $check = $conexion->prepare("SELECT id FROM profesionales WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $resultado = $check->get_result();

        if ($resultado->num_rows === 1) {
            $hash = password_hash($nueva_contraseña, PASSWORD_DEFAULT);
            $update = $conexion->prepare("UPDATE profesionales SET contraseña = ? WHERE email = ?");
            $update->bind_param("ss", $hash, $email);

            if ($update->execute()) {
                $mensaje = "<p class='success'>Contraseña actualizada correctamente. <a href='login_profesional.php'>Iniciar sesión</a></p>";
            } else {
                $mensaje = "<p class='error'>Error al actualizar la contraseña. Intenta de nuevo.</p>";
            }
        } else {
            $mensaje = "<p class='error'>Correo no encontrado.</p>";
        }
    } else {
        $mensaje = "<p class='error'>Completa todos los campos.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <style>
        body { font-family: sans-serif; background: #f8f9fa; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .card { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        input, button { width: 100%; padding: 0.75rem; margin-bottom: 1rem; border-radius: 5px; border: 1px solid #ccc; }
        button { background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        .success { background: #d4edda; color: #155724; padding: 0.75rem; border-radius: 5px; margin-bottom: 1rem; }
        .error { background: #f8d7da; color: #721c24; padding: 0.75rem; border-radius: 5px; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="card">
        <h2>🔑 Restablecer Contraseña</h2>
        <?php echo $mensaje; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="nueva_contraseña" placeholder="Nueva contraseña" required>
            <button type="submit">Actualizar contraseña</button>
        </form>
    </div>
</body>
</html>
