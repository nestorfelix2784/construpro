<?php
session_start();
include('../includes/conexion.php');

$mensaje = '';

// Validar sesión del profesional
if (!isset($_SESSION['profesional_id'])) {
    header('Location: login_profesional.php');
    exit();
}

$id_profesional = $_SESSION['profesional_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';

    if (isset($_FILES['fotos']) && !empty($_FILES['fotos']['name'][0])) {
        // Insertar trabajo sin imagen principal
        $stmt = $conexion->prepare("INSERT INTO trabajos (id_profesional, titulo, descripcion) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $id_profesional, $titulo, $descripcion);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $id_trabajo = $stmt->insert_id;
            $carpeta = "../uploads/trabajos/$id_profesional/$id_trabajo/";

            if (!is_dir($carpeta)) {
                mkdir($carpeta, 0777, true);
            }

            $foto_stmt = $conexion->prepare("INSERT INTO fotos_trabajo (trabajo_id, nombre_archivo) VALUES (?, ?)");

            foreach ($_FILES['fotos']['name'] as $i => $nombre_original) {
                $tmp = $_FILES['fotos']['tmp_name'][$i];

                if (!empty($nombre_original)) {
                    $nombre_limpio = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', basename($nombre_original));
                    $nombre_unico = time() . '_' . $nombre_limpio;
                    $ruta_destino = $carpeta . $nombre_unico;

                    if (move_uploaded_file($tmp, $ruta_destino)) {
                        $foto_stmt->bind_param("is", $id_trabajo, $nombre_unico);
                        $foto_stmt->execute();
                        $mensaje .= "<div class='success'>✅ Imagen guardada: $nombre_original</div>";
                    } else {
                        $mensaje .= "<div class='error'>❌ Error al subir: $nombre_original</div>";
                    }
                } else {
                    $mensaje .= "<div class='error'>❌ Archivo sin nombre</div>";
                }
            }
        } else {
            $mensaje = "<div class='error'>❌ No se guardó el trabajo</div>";
        }
    } else {
        $mensaje = "<div class='error'>❌ No se seleccionaron imágenes</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Trabajo</title>
    <link rel="stylesheet" href="/construpro/css/estilos.css">
    <style>
        body { font-family: sans-serif; background: #e9f1fb; padding: 2rem; }
        .card { background: white; padding: 2rem; border-radius: 10px; max-width: 600px; margin: auto; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        input, textarea, button { width: 100%; margin-bottom: 1rem; padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px; }
        button { background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        .success { background: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
        .error { background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
        .volver { text-align: center; margin-top: 20px; }
        .volver a { color: #007bff; text-decoration: none; font-weight: bold; }
        .volver a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="card">
        <h2>📁 Subir Trabajo</h2>
        <?php echo $mensaje; ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="titulo" placeholder="Título del trabajo" required>
            <textarea name="descripcion" rows="4" placeholder="Descripción del trabajo"></textarea>
            <input type="file" name="fotos[]" accept="image/*" multiple required>
            <button type="submit">Subir</button>
        </form>
        <div class="volver">
            <a href="perfil.php">← Volver al perfil</a>
        </div>
    </div>
</body>
</html>
