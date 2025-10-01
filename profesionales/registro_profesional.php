<?php
session_start();
include_once '../includes/conexion.php';

$mensaje = "";

// Variables por defecto
$nombre = $email = $oficio = $provincia = $partido = $localidad = $descripcion = $whatsapp = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $contraseña = isset($_POST['contraseña']) ? password_hash($_POST['contraseña'], PASSWORD_DEFAULT) : '';
    $oficio = $_POST['oficio'] ?? '';
    $provincia = $_POST['provincia'] ?? '';
    $partido = $_POST['partido'] ?? '';
    $localidad = $_POST['localidad'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $whatsapp = $_POST['whatsapp'] ?? '';
    $foto = '';

    $check = $conexion->prepare("SELECT id FROM profesionales WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        $mensaje = "<p class='mensaje error'>Este correo ya está registrado. <a href='login_profesional.php'>Iniciar sesión</a></p>";
    } else {
        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
            $foto_nombre = time() . "_" . basename($_FILES['foto_perfil']['name']);
            $destino = "../uploads/foto_perfil/" . $foto_nombre;
            move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $destino);
            $foto = $foto_nombre;
        }
        if(empty($foto)){
            $foto="perfil.png";
        }

        $stmt = $conexion->prepare("INSERT INTO profesionales (nombre, email, contraseña, oficio, provincia, partido, localidad, descripcion, whatsapp, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $nombre, $email, $contraseña, $oficio, $provincia, $partido, $localidad, $descripcion, $whatsapp, $foto);

        if ($stmt->execute()) {
            $mensaje = "<p class='mensaje success'>Registro exitoso. <a href='login_profesional.php'>Iniciar sesión ahora</a>.</p>";
        } else {
            $mensaje = "<p class='mensaje error'>Error al registrar. Intentalo de nuevo.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro Profesional</title>
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
        .card { background: white;  
                padding: 2rem; 
                border-radius: 10px;
                box-shadow: 0 0 15px rgba(0,0,0,0.1);
                max-width: 500px; width: 100%; }
        input, textarea, button ,select { width: 100%; 
                                margin-bottom: 1rem;
                                padding: 0.75rem;
                                border-radius: 5px;
                                border: 1px solid #ccc; }
        button { background: #48e;
                color: white; border: none;
                cursor: pointer; font-weight: bold; }
        button:hover { background: #283; }
        h2 { text-align: center; 
            margin-bottom: 1.5rem; }
        .mensaje { text-align: center;
                    padding: 0.5rem 1rem;
                    border-radius: 5px; 
                    margin-bottom: 1rem; }
        .success { background: #d4edda;
                    color: #155724; 
                    border: 1px solid #c3e6cb; }
        .error { background: #f8d7da;
                color: #721c24; 
                border: 1px solid #f5c6cb; }
        label { font-weight: bold; 
                display: block;
                margin-bottom: 0.5rem; }
        a { color: #007bff; 
            text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <img src="../img/logo.png" alt="Logo" class="logo">
    <div class="card">
        <h2>🛠 Registro Profesional</h2>
        <?php echo $mensaje; ?>
        <form method="POST" enctype="multipart/form-data">
            <label>Nombre completo</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>

            <label>Correo electrónico</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label>Contraseña</label>
            <input type="password" name="contraseña" required>

            <label>WhatsApp (opcional)</label>
            <input type="text" name="whatsapp" value="<?php echo htmlspecialchars($whatsapp); ?>">

            <label>Oficio</label>
            <input type="text" name="oficio" value="<?php echo htmlspecialchars($oficio); ?>" placeholder="Ej: Plomero, Electricista" required>

            <label>Provincia</label>
           <!-- <input type="text" name="provincia" value="<?php echo htmlspecialchars($provincia); ?>" required>--> 
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

            <label>Partido</label>
            <input type="text" name="partido" value="<?php echo htmlspecialchars($partido); ?>" required>

            <label>Localidad</label>
            <input type="text" name="localidad" value="<?php echo htmlspecialchars($localidad); ?>" required>

            <label>Descripción</label>
            <textarea name="descripcion" rows="4"><?php echo htmlspecialchars($descripcion); ?></textarea>

            <label>Foto de perfil</label>
            <input type="file" name="foto_perfil" accept="image/*">

            <button type="submit">Registrarme</button>
        </form>
    </div>
</body>
</html>
