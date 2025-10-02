<?php
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['cliente_id'])) {
    header("Location: /construpro/clientes/login_cliente.php");
    exit();
}

include_once __DIR__ . '/../includes/conexion.php';
$cliente_id = $_SESSION['cliente_id'];


// Obtener datos del cliente
$stmt = $conexion->prepare("SELECT * FROM clientes WHERE id = ?");
$stmt->bind_param("i", $cliente_id);
$stmt->execute();
$resultado = $stmt->get_result();
$cliente = $resultado->fetch_assoc();

if (!$cliente) {
    echo "<p style='color:red;'>No se encontró el cliente con ID $cliente_id</p>";
    exit();
}

// Subida de foto
$mensajeFoto = "";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["foto_perfil"])) {
    $foto = $_FILES["foto_perfil"];
    $directorio = "../imagenes/clientes/";

    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    $archivoDestino = $directorio . $cliente_id . ".jpg";

    if ($foto["error"] === UPLOAD_ERR_OK) {
        move_uploaded_file($foto["tmp_name"], $archivoDestino);
        $mensajeFoto = "Foto subida correctamente.";
    } else {
        $mensajeFoto = "Error al subir la foto.";
    }
}

// Favoritos
$stmtFav = $conexion->prepare("
    SELECT profesionales.id, profesionales.nombre 
    FROM favoritos 
    JOIN profesionales ON favoritos.profesional_id = profesionales.id 
    WHERE favoritos.cliente_id = ?
    
");
$stmtFav->bind_param("i", $cliente);
$stmtFav->execute();
$resultadoFav = $stmtFav->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mi Perfil - Construpro</title>
  <link rel="stylesheet" href="/construpro/css/estilos.css?v=<?php echo time(); ?>">
  <script src="https://kit.fontawesome.com/3f3e0e8a56.js" crossorigin="anonymous"></script>
        
 
</head>
<body>
    <button> <a href="../index.php">volver al inicio</a></button>
<div class="tarjeta-perfil cliente">
  <!-- FOTO + INFO -->
  <div class="foto-info">
    <div class="foto-perfil redonda">
      <?php if (file_exists("../imagenes/clientes/" . $cliente_id . ".jpg")): ?>
        <img src="../imagenes/clientes/<?php echo $cliente_id; ?>.jpg"
              alt="Foto de perfil"
              onerror="this.src='/construpro/uploads/foto_perfil/default.png';" />
      <?php else: ?>
        <img src="/construpro/uploads/foto_perfil/default.png" alt="Sin foto de perfil" />
      <?php endif; ?>
    </div>

    <div class="info">
      <h2><?php echo htmlspecialchars($cliente['nombre']); ?>
        <small>(Cliente)</small>
      </h2>
      <div class="detalle-dato"><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($cliente['email']); ?></div>
      <div class="detalle-dato"><i class="fas fa-phone"></i> <?php echo htmlspecialchars($cliente['telefono']); ?></div>
      <div class="detalle-dato"><i class="fas fa-map-marker-alt"></i>
        <?php echo "{$cliente['provincia']}, {$cliente['partido']}, {$cliente['localidad']}"; ?>
      </div>
      <div class="detalle-dato"><i class="fas fa-home"></i> <?php echo htmlspecialchars($cliente['direccion']); ?></div>

      <a href="editar_perfil.php" class="boton-profesional">
        <i class="fas fa-user-edit"></i> Editar Perfil
      </a>
      <a href="/construpro/clientes/logout.php" class="boton-profesional">
        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
      </a>
    </div>
  </div>

  <!-- FAVORITOS -->
  <hr>
  <h3>⭐ Profesionales Favoritos</h3>
  <select onchange="if(this.value) location.href=this.value;" class="select-favoritos">
    <option value="">Seleccioná un profesional...</option>
    <?php while ($fav = $resultadoFav->fetch_assoc()): ?>
      <option value="/construpro/profesionales/perfil.php?id=<?php echo $fav['id']; ?>">
        <?php echo htmlspecialchars($fav['nombre']); ?>
      </option>
    <?php endwhile; ?>
  </select>

  <!-- BUSCADOR -->
  <hr>
  <h3>🔍 Buscar profesional</h3>
  <form method="GET" action="buscar_profesionales.php" class="form-busqueda">
    <input type="text" name="termino" placeholder="Buscar por oficio o zona" required>
    <button type="submit" class="boton-profesional">Buscar</button>
  </form>

  <!-- SUBIDA FOTO -->
  <hr>
  <h3>📷 Actualizar foto de perfil</h3>
  <?php if (!empty($mensajeFoto)): ?>
    <p class="success"><?php echo $mensajeFoto; ?></p>
  <?php endif; ?>
  <form method="POST" enctype="multipart/form-data" class="form-foto">
    <input type="file" name="foto_perfil" accept="image/*">
    <button type="submit" class="boton-profesional">
      <i class="fas fa-upload"></i> Subir Foto
    </button>
  </form>
</div>
</body>
</html>
<?php include_once '../includes/footer.php'; ?>
