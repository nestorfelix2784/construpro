<?php
include_once '../includes/conexion.php';

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
    $telefono = $_POST['telefono'];
    $provincia = $_POST['provincia'];
    $partido = $_POST['partido'];
    $localidad = $_POST['localidad'];
    $direccion = $_POST['direccion'];

    $stmt = $conexion->prepare("INSERT INTO clientes (nombre, email, contraseña, telefono, provincia, partido, localidad, direccion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nombre, $email, $contraseña, $telefono, $provincia, $partido, $localidad, $direccion);
    
    if ($stmt->execute()) {
        header("Location: login_cliente.php");
        exit();
    } else {
        $mensaje = "Error al registrar cliente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro Cliente - Construpro</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <style>
        body {
            background-image: url('../img/fondo-ladrillos.jpg');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            color: #fff;
            text-align: center;
            padding-top: 50px;
        }

        .contenedor {
            background-color: rgba(0,0,0,0.7);
            padding: 30px;
            display: inline-block;
            border-radius: 10px;
            max-width: 500px;
            width: 90%;
        }

        input, button {
            display: block;
            margin: 10px auto;
            padding: 10px;
            width: 90%;
        }

        .mensaje {
            color: #ff8080;
            margin-top: 10px;
        }

        .btn-secundario {
            background-color: #007bff;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .btn-secundario:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <h2>Registro de Cliente</h2>
        <?php if ($mensaje): ?>
            <p class="mensaje"><?php echo $mensaje; ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="contraseña" placeholder="Contraseña" required>
            <input type="text" name="telefono" placeholder="Teléfono" required>
            <input type="text" name="provincia" placeholder="Provincia" required>
            <input type="text" name="partido" placeholder="Partido/Distrito" required>
            <input type="text" name="localidad" placeholder="Localidad" required>
            <input type="text" name="direccion" placeholder="Dirección" required>
            <button type="submit">Registrarse</button>
        </form>
        <p>¿Ya tienes cuenta? <a href="login_cliente.php" class="btn-secundario">Iniciar sesión</a></p>
        <p><a href="../index.php" class="btn-secundario">Volver al inicio</a></p>
    </div>
</body>
</html>
