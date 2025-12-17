<?php
session_start();

// 1. Validar sesión de profesional
if (!isset($_SESSION['profesional_id'])) {
    header("Location: ../profesionales/login.php");
    exit();
}

include_once __DIR__ . '/../includes/conexion.php';
include_once __DIR__ . '/../includes/header.php';

$profesional_id = $_SESSION['profesional_id'];
$error = '';

// 2. Obtener datos actuales del profesional
$query  = "SELECT * FROM profesionales WHERE id = ?";
$stmt   = $conexion->prepare($query);
$stmt->bind_param("i", $profesional_id);
$stmt->execute();
$result = $stmt->get_result();
$profesional = $result->fetch_assoc();

// 3. Procesar formulario de actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre     = $_POST['nombre']     ?? '';
    $email      = $_POST['email']      ?? '';
    $whatsapp   = $_POST['whatsapp']   ?? '';
    $oficio     = $_POST['oficio']     ?? '';
    $provincia  = $_POST['provincia']  ?? '';
    $partido    = $_POST['partido']    ?? '';
    $localidad  = $_POST['localidad']  ?? '';

    // 3.1 Manejo de la foto de perfil
    if (!empty($_FILES['foto_perfil']['name'])) {
        $original       = basename($_FILES['foto_perfil']['name']);
        $nombreArchivo  = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $original);

        // ← Aquí cambiamos a Foto_perfil (sin 's')
        $carpeta        = __DIR__ . '/../uploads/foto_perfil/';
        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $rutaDestino = $carpeta . $nombreArchivo;
        if (!move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaDestino)) {
            $error = '❌ Error al subir la nueva foto.';
        }
    } else {
        // Si no se sube nueva foto, mantener la anterior
        $nombreArchivo = $profesional['foto_perfil'];
    }

    // 3.2 Actualizar base de datos si no hubo error de subida
    if (empty($error)) {
        $sql = "UPDATE profesionales 
                SET nombre = ?, email = ?, whatsapp = ?, oficio = ?, provincia = ?, partido = ?, localidad = ?, foto = ?
                WHERE id = ?";
        $upd = $conexion->prepare($sql);
        $upd->bind_param(
            "ssssssssi",
            $nombre,
            $email,
            $whatsapp,
            $oficio,
            $provincia,
            $partido,
            $localidad,
            $nombreArchivo,
            $profesional_id
        );

        if ($upd->execute()) {
            $_SESSION['mensaje_actualizado'] = '✅ Perfil actualizado con éxito.';
            header("Location: /perfil.php");
            exit();
        } else {
            $error = '❌ Error al actualizar perfil: ' . $upd->error;
        }
    }
}
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    
        
<!-- Estilos locales para este formulario -->
<!--<style>
    .card {
        background: #fff;
        max-width: 600px;
        margin: 2rem auto;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        font-family: sans-serif;
    }
    .card h2 {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #333;
    }
    .form-group {
        margin-bottom: 1rem;
    }
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: #555;
    }
    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="file"] {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .error {
        background: #f8d7da;
        color: #721c24;
        padding: 0.75rem;
        border-radius: 5px;
        border: 1px solid #f5c6cb;
        margin-bottom: 1rem;
    }
    .buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1.5rem;
    }
    .btn-primary {
        background: #007bff;
        color: #fff;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.2s ease;
    }
    .btn-primary:hover {
        background: #0069d9;
    }
    .btn-secondary {
        background: #6c757d;
        color: #fff;
        text-decoration: none;
        display: inline-block;
        padding: 0.75rem 1.5rem;
        border-radius: 5px;
        transition: background 0.2s ease;
    }
    .btn-secondary:hover {
        background: #5a6268;
    }
</style>-->
<style>
    * {
        box-sizing: border-box;
    }

    .card {
        background: #fff;
        width: 90%;
        max-width: 600px;
        margin: 2rem auto;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        font-family: sans-serif;
    }

    .card h2 {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #333;
        font-size: 1.5rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: #555;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="file"] {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
    }

    .error {
        background: #f8d7da;
        color: #721c24;
        padding: 0.75rem;
        border-radius: 5px;
        border: 1px solid #f5c6cb;
        margin-bottom: 1rem;
    }

    .buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1.5rem;
        gap: 1rem;
    }

    .btn-primary,
    .btn-secondary {
        padding: 0.75rem 1.5rem;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.2s ease;
        font-size: 1rem;
        text-align: center;
        width: auto;
    }

    .btn-primary {
        background: #007bff;
        color: #fff;
        border: none;
    }

    .btn-primary:hover {
        background: #0069d9;
    }

    .btn-secondary {
        background: #6c757d;
        color: #fff;
        text-decoration: none;
        display: inline-block;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    @media (max-width: 600px) {
        .buttons {
            flex-direction: column;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
        }
    }
</style>

</head>
<body>
<div class="card">
    <h2>Editar Perfil Profesional</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($profesional['nombre']); ?>" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($profesional['email']); ?>" required>
        </div>

        <div class="form-group">
            <label>WhatsApp:</label>
            <input type="text" name="whatsapp" value="<?php echo htmlspecialchars($profesional['whatsapp']); ?>">
        </div>

        <div class="form-group">
            <label>Oficio:</label>
            <input type="text" name="oficio" value="<?php echo htmlspecialchars($profesional['oficio']); ?>" required>
        </div>

        <div class="form-group">
            <label>Provincia:</label>
            <input type="text" name="provincia" value="<?php echo htmlspecialchars($profesional['provincia']); ?>" required>
        </div>

        <div class="form-group">
            <label>Partido:</label>
            <input type="text" name="partido" value="<?php echo htmlspecialchars($profesional['partido']); ?>" required>
        </div>

        <div class="form-group">
            <label>Localidad:</label>
            <input type="text" name="localidad" value="<?php echo htmlspecialchars($profesional['localidad']); ?>" required>
        </div>

        <div class="form-group">
            <label>Foto de Perfil (opcional):</label>
            <input type="file" name="foto_perfil" accept="image/*">
        </div>

        <div class="buttons">
            <button type="submit" class="btn-primary">Guardar Cambios</button>
            <a href="perfil.php" class="btn-secondary">Volver al Perfil</a>
        </div>
    </form>
</div>
</body>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
