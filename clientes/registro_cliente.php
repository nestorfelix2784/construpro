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
    <!-- <link rel="stylesheet" href="../css/estilos.css">-->
    <style>

        body  {font-family: sans-serif;
                background-image:url("../img/fondo.png"); 
                display: flex;  
                justify-content: center;  
                align-items: center; 
                min-height: 100vh; 
                padding: 1rem; }
            
        .logo {
                width: 15%;
                position: absolute;
                top: 0;
                left: 0 ;
                margin: 10px;
                box-shadow: 0 4px 10px #000;

        }

        .contenedor {
                background-color: white;
                padding: 30px;
                display: inline-block;
                border-radius: 10px;
                max-width: 500px;
                width: 90%;
        }

        
        input, textarea, button ,select { width: 100%; 
                                margin-bottom: 1rem;
                                padding: 0.75rem;
                                border-radius: 5px;
                                border: 1px solid #ccc; }
        button { background: #48e;
                color: white; border: none;
                cursor: pointer; font-weight: bold; }
        button:hover { background: #283; }

        .mensaje {
            color: #ff8080;
            margin-top: 10px;
        }

        .btn-secundario {
            background-color: #48e;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .btn-secundario:hover {
            background-color: #283;
        }
    </style>
</head>
<body>
    <img src="../img/logo.png" alt="Logo" class="logo">
    <div class="contenedor">
        <h2>Registro de Cliente</h2>
        <?php if ($mensaje): ?>
            <p class="mensaje"><?php echo $mensaje; ?></p>
        <?php endif; ?>
    
        <form method="POST">
        <label for="nombre">Nombre completo</label>     
    <input type="text" name="nombre"  required>
        <label for="Email">Elmail</label>
    <input type="email" name="email"  required>
        <label for="pasword">Contraseña</label>
    <input type="password" name="contraseña"  required>
        <label for="telefono">WhatsApp</label>
    <input type="text" name="telefono"  required>
        <label for="provincia"> provincia</label>
    <select name="provincia" required>
    <option value=""> </option>
    <option value="Buenos Aires">Buenos Aires</option>
    <option value="Catamarca">Catamarca</option>
    <option value="Chaco">Chaco</option>
    <option value="Chubut">Chubut</option>
    <option value="Córdoba">Córdoba</option>
    <option value="Corrientes">Corrientes</option>
    <option value="Entre Ríos">Entre Ríos</option>
    <option value="Formosa">Formosa</option>
    <option value="Jujuy">Jujuy</option>
    <option value="La Pampa">La Pampa</option>
    <option value="La Rioja">La Rioja</option>
    <option value="Mendoza">Mendoza</option>
    <option value="Misiones">Misiones</option>
    <option value="Neuquén">Neuquén</option>
    <option value="Río Negro">Río Negro</option>
    <option value="Salta">Salta</option>
    <option value="San Juan">San Juan</option>
    <option value="San Luis">San Luis</option>
    <option value="Santa Cruz">Santa Cruz</option>
    <option value="Santa Fe">Santa Fe</option>
    <option value="Santiago del Estero">Santiago del Estero</option>
    <option value="Tierra del Fuego">Tierra del Fuego</option>
    <option value="Tucumán">Tucumán</option>
    </select>
        <label for="partido">partido/distrito</label>
    <input type="text" name="partido"  required>
        <label for="localidad">Localidad</label>
    <input type="text" name="localidad"  required>
        <label for="direccion">Direccion</label>
    <input type="text" name="direccion" required>
        
    <button type="submit">Registrarse</button>
</form>



        <p>¿Ya tienes cuenta?</p> <a href="login_cliente.php" class="btn-secundario">Iniciar sesión</a>
        <a href="../index.php" class="btn-secundario">Volver al inicio</a>
    </div>
</body>
</html>
