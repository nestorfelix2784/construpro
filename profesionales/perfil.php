<?php
session_start();
if (!isset($_SESSION['profesional_id'])) {
    header("Location: login_profesional.php");
    exit();
}

include_once '../includes/conexion.php';
include_once '../includes/header.php';

// Mostrar mensaje si existe
$mensaje_eliminacion = $_SESSION['mensaje_eliminado'] ?? null;
if (isset($_SESSION['mensaje_eliminado'])) {
    unset($_SESSION['mensaje_eliminado']);
}

$profesional_id = $_SESSION['profesional_id'];
$query = "SELECT * FROM profesionales WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $profesional_id);
$stmt->execute();
$resultado = $stmt->get_result();
$profesional = $resultado->fetch_assoc();
?>

<div style="max-width:800px;margin:20px auto;padding:20px;border:1px solid #ccc;border-radius:10px;font-family:sans-serif;background:#fff;">
    <?php if ($mensaje_eliminacion): ?>
        <div style="background:#28a745;color:white;padding:10px;border-radius:5px;margin-bottom:20px;text-align:center;animation:fadeOut 4s ease forwards;">
            <?php echo $mensaje_eliminacion; ?>
        </div>
        <style>
            @keyframes fadeOut {
                0% { opacity: 1; }
                80% { opacity: 1; }
                100% { opacity: 0; display: none; }
            }
        </style>
    <?php endif; ?>

    <h2 style="text-align:center;">👷 Perfil Profesional</h2>
    <div style="text-align:center;margin-bottom:15px;">
        <?php
        if($profesional){
            $foto = !empty($profesional['foto']) ? $profesional['foto'] : 'perfil.png';
            $ruta_foto = "/construpro/uploads/foto_perfil/" . htmlspecialchars($foto);
            } else {
                $ruta_foto="/construpro/uploads/foto_perfil/perfil.png";
            }
        ?>
        <img src="<?php echo $ruta_foto; ?>" alt ="foto de perfil" width="150" style="border-radius: 50%;border:2px solid #aaa;">



    </div>
    <p><strong>📛 Nombre:</strong> <?php echo htmlspecialchars($profesional['nombre']); ?></p>
    <p><strong>📧 Email:</strong> <?php echo htmlspecialchars($profesional['email']); ?></p>
    <p><strong>📱 WhatsApp:</strong> <?php echo htmlspecialchars($profesional['whatsapp'] ?? ''); ?></p>
    <p><strong>🔨 Oficio:</strong> <?php echo htmlspecialchars($profesional['oficio']); ?></p>
    <p><strong>📍 Provincia:</strong> <?php echo htmlspecialchars($profesional['provincia']); ?></p>
    <p><strong>🌐 Partido:</strong> <?php echo htmlspecialchars($profesional['partido']); ?></p>
    <p><strong>🏘️ Localidad:</strong> <?php echo htmlspecialchars($profesional['localidad']); ?></p>
    <p><strong>📝 Descripción:</strong> <?php echo htmlspecialchars($profesional['descripcion']); ?></p>

    <div style="text-align:center;margin:20px 0;">
        <a href="editar_perfil.php" style="padding:10px 20px;background:#007bff;color:white;border:none;border-radius:5px;text-decoration:none;">Editar Perfil</a>
        <a href="subir_trabajo.php" style="padding:10px 20px;background:#28a745;color:white;border:none;border-radius:5px;text-decoration:none;margin-left:10px;">Subir Trabajo</a>
        <a href="../index.php" style="padding:10px 20px;background:#6c757d;color:white;border:none;border-radius:5px;text-decoration:none;">🏠 Volver al Inicio</a>

    </div>


    <hr>
    <h3 style="text-align:center;">🧱 Trabajos Subidos</h3>

    <?php
    $trabajos = $conexion->prepare("SELECT * FROM trabajos WHERE id_profesional = ? ORDER BY fecha_publicacion DESC");
    $trabajos->bind_param("i", $profesional_id);
    $trabajos->execute();
    $resultado_trabajos = $trabajos->get_result();

    while ($trabajo = $resultado_trabajos->fetch_assoc()) {
        echo "<div style='margin-bottom:30px;padding:15px;border:1px solid #ddd;border-radius:8px;'>";
        echo "<h4>" . htmlspecialchars($trabajo['titulo']) . "</h4>";
        echo "<p>" . nl2br(htmlspecialchars($trabajo['descripcion'])) . "</p>";
        echo "<div style='display:flex;flex-wrap:wrap;gap:10px;'>";

        $id_trabajo = $trabajo['id'];
        $fotos = $conexion->prepare("SELECT nombre_archivo FROM fotos_trabajo WHERE trabajo_id = ?");
        $fotos->bind_param("i", $id_trabajo);
        $fotos->execute();
        $res_fotos = $fotos->get_result();

        while ($foto = $res_fotos->fetch_assoc()) {
            $nombre_archivo = htmlspecialchars($foto['nombre_archivo'], ENT_QUOTES);
            $ruta_img = "/construpro/uploads/trabajos/$profesional_id/$id_trabajo/$nombre_archivo";

            echo "<img src='$ruta_img' alt='$nombre_archivo' style='width:120px;height:auto;border-radius:5px;border:1px solid #ccc;' />";
        }

        echo "</div>";
        echo "<form action='eliminar_trabajo.php' method='POST' onsubmit=\"return confirm('¿Estás seguro de que querés borrar este trabajo?');\" style='margin-top:15px;'>";
        echo "<input type='hidden' name='id_trabajo' value='" . $trabajo['id'] . "' />";
        echo "<button type='submit' style='background:#dc3545;color:white;border:none;padding:10px 15px;border-radius:5px;'>🗑️ Borrar Trabajo</button>";
        echo "</form>";
        echo "</div>";
    }
    ?>

</div>

<?php include_once '../includes/footer.php'; ?>
