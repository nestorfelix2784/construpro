<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include_once __DIR__ . '/../includes/conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['contraseña'];

    $stmt = $conexion->prepare("SELECT id, contraseña FROM clientes WHERE LOWER(email) = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $cliente = $resultado->fetch_assoc();

        // Solo para testeo. Luego usar password_verify()
        if (password_verify($password, $cliente['contraseña'])) {
            $_SESSION['cliente_id'] = $cliente['id'];
            $_SESSION['tipo'] = 'cliente'; // 👈 activa navegación para cliente
            header("Location: /clientes/perfil.php");
            exit();
        } else {
            $mensaje = "Contraseña incorrecta.";
        }
    } else {
        $mensaje = "Email no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Cliente</title>
    <link rel="stylesheet" href="../css/estilos.css">
        <style>
       /** *body { font-family: sans-serif; background: #f0f0f0; display: flex; justify-content: center; align-items: center; height: 100vh; }
          .pagina {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }*/body {
        margin: 0;
        padding: 0;
        background-color: #ccc;
        font-family: sans-serif;
        min-width: 200px;
    }
        main{
            flex: 1;
        }
    .logo {
            width: 15%;
            position: absolute;
            top: 0;
            left: 0 ;
            margin: 10px;
            box-shadow: 0 4px 10px #000;

        }
            .contenedor {
               
        padding: 10%;
        color: transparent;
        background-image: url("../img/fondo.png");
        background-size: cover;
        background-position: center;
        text-align: center;
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
        font-family: sans-serif;
        font-size: medium;
    }
        .card { background: white; padding: 3rem; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 100%; max-width: 600px; }
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
    <div class="pagina">  
        <main>
            <div class="contenedor">
                <div class="card">
                    <h1>Iniciar Sesión como Cliente</h1>

                        <?php if (!empty($mensaje)): ?>
                        <p style="color: red;"><?php echo $mensaje; ?></p>
                        <?php endif; ?>

                        <form method="POST">
                        <label>Email:</label>
                        <input type="email" name="email" required placeholder="mail-de ejemplo@gmail.com"><br>
                        <label>Contraseña:</label>
                        <input type="password" name="contraseña" required placeholder="tu contraseña aqui"><br>
                        <button type="submit">Ingresar</button>
                        </form >
                        <p><a href="registro_cliente.php">¿No tienes cuenta? Regístrate</a></p>
                        <p><a href="recuperar_contraseña.php">¿Olvidaste tu contraseña?</a></p>
                        <p> <a href="../index.php">volver al inicio</a></p>
                </div>
                    <img src="../img/logo.png" alt="Logo Construpro" class="logo">
                </div>
        </main>
    </div>
</body>
</html>

