<?php
session_start();
include_once '../includes/conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    $stmt = $conexion->prepare("SELECT * FROM profesionales WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($contraseña, $usuario['contraseña'])) {
            $_SESSION['profesional_id'] = $usuario['id'];
            header('Location: perfil.php');
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Correo no registrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Profesional</title>
    <style>
        body { font-family: sans-serif; background: #f0f0f0; display: flex; justify-content: center; align-items: center; height: 100vh; }
            .contenedor {
        padding: 20% 35%;
        color: #0056b3;
        background-image: url("../img/fondo.png");
        background-size: cover;
        background-position: center;
        text-align: center;
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
        font-family: sans-serif;
        font-size: medium;
    }
        .logo {
            width: 15%;
            position: absolute;
            top: 0;
            left: 0 ;
            margin: 10px;
            box-shadow: 0 4px 10px #000;

        }
        .card { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h2 { text-align: center; margin-bottom: 1.5rem; }
        input, button { width: 100%; padding: 0.75rem; margin-bottom: 1rem; border-radius: 5px; border: 1px solid #ccc; }
        button { background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        .links { text-align: center; margin-top: 1rem; }
        .links a { display: inline-block; margin: 0 0.5rem; color: #007bff; text-decoration: none; }
        .links a:hover { text-decoration: underline; }
        .error { color: red; text-align: center; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="contenedor">
        <img src="../img/logo.png" alt="Logo" class="logo">
    <div class="card">
        <h2>👷 Ingreso Profesional</h2>

        <?php if (!empty($error)) echo "<div class='error'>" . htmlspecialchars($error) . "</div>"; ?>

        <form method="POST">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="mail-ejemplo@gmail.co" required>
            <label for="contraseña">Contraseña</label>
            <input type="contraseña" name="contraseña" placeholder="aqui tu Contraseña" required>
            <button type="submit">Iniciar Sesión</button>
        </form>

       <!-- <div class="links">
            <a href="registro_profesional.php">Registrarme</a>
            <a href="recuperar_contrasena.php">Olvidé mi contraseña</a>
            <a href="../index.php">volver al inicio</a>
        </div>-->
          <p><a href="registro_profesional.php">¿No tienes cuenta? Regístrate</a></p>
                        <p><a href="recuperar_contraseña.php">¿Olvidaste tu contraseña?</a></p>
                        <p> <a href="../index.php">volver al inicio</a></p>
    </div>

    </div>
</body>
</html>

