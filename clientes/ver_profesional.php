<?php
session_start();
$fondo = 'fondo-perfil';
include('../includes/header.php');
include('../includes/conexion.php');

// 1) Validar ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de profesional inválido o no enviado.";
    exit;
}
$profID = (int) $_GET['id'];

// 2) Datos del profesional
$stmt = $conexion->prepare("SELECT * FROM profesionales WHERE id = ?");
$stmt->bind_param("i", $profID);
$stmt->execute();
$profesional = $stmt->get_result()->fetch_assoc();
if (!$profesional) {
    echo "Profesional no encontrado.";
    exit;
}

// 3) Comentarios y promedio
$stmtC = $conexion->prepare("
  SELECT c.*, cl.nombre AS nombre_cliente
  FROM comentarios c
  JOIN clientes cl ON c.usuario_id = cl.id
  WHERE c.profesional_id = ?
  ORDER BY c.fecha_creacion DESC
");
$stmtC->bind_param("i", $profID);
$stmtC->execute();
$resultado_comentarios = $stmtC->get_result();

$stmtP = $conexion->prepare("
  SELECT AVG(calificacion) AS promedio, COUNT(*) AS total
  FROM comentarios
  WHERE profesional_id = ?
");
$stmtP->bind_param("i", $profID);
$stmtP->execute();

$stmtP->bind_result($promedio, $total);
$stmtP->fetch();

$promedio = $promedio ?? 0;
$promedio = round((float)$promedio, 1);
$total = (int)($total ?? 0);

$stmtP->close();

// 4) Trabajos realizados
$stmtT = $conexion->prepare("SELECT * FROM trabajos WHERE id_profesional = ?");
$stmtT->bind_param("i", $profID);
$stmtT->execute();
$trabajos = $stmtT->get_result()->fetch_all(MYSQLI_ASSOC);

// 5) URLs base
$baseURL        = '/uploads';
$perfilURL      = "{$baseURL}/foto_perfil/" . ($profesional['foto_perfil'] ?: 'default.png');
$defaultTrabajo = "{$baseURL}/trabajos/default-trabajo.jpg";
?>
</header>

<div class="tarjeta-perfil">
  <!-- FOTO + INFO -->
  <div class="foto-info">
    <div class="foto-perfil">
      <img
        src="<?php echo htmlspecialchars($perfilURL); ?>"
        alt="Perfil de <?php echo htmlspecialchars($profesional['nombre']); ?>"
        onerror="this.src='<?php echo "{$baseURL}/foto_perfil/default.png"; ?>';"
      />
    </div>
    <div class="info">
      <h2>
        <?php echo htmlspecialchars($profesional['nombre']); ?>
        <small>(<?php echo htmlspecialchars($profesional['oficio']); ?>)</small>
      </h2>
      <div class="detalle-dato">
        <i class="fas fa-map-marker-alt"></i>
        <?php echo "{$profesional['provincia']}, {$profesional['partido']}, {$profesional['localidad']}"; ?>
      </div>
      <div class="detalle-dato">
        <i class="fas fa-star"></i>
        <?php echo "$promedio / 5 ($total opiniones)"; ?>
      </div>
      <div class="detalle-dato">
        <i class="fas fa-envelope"></i>
        <?php echo htmlspecialchars($profesional['email']); ?>
      </div>
      <div class="detalle-dato">
        <i class="fas fa-phone"></i>
        <?php echo htmlspecialchars($profesional['whatsapp']); ?>
      </div>
      <p class="contacto-desc">
        <strong>Descripción:</strong><br>
        <?php echo nl2br(htmlspecialchars($profesional['descripcion'])); ?>
      </p>
      <button
        class="boton-profesional"
        onclick="this.style.display='none'; document.querySelector('.galeria-trabajos').style.display='grid';"
      >
        <i class="fas fa-briefcase"></i> Ver trabajos realizados
      </button>
    </div>
  </div>

  <!-- FORMULARIO DE COMENTARIO -->
  <?php if (isset($_SESSION['cliente_id'])): ?>
    <div class="form-comentario">
      <h3>📝 Dejá tu comentario</h3>
      <form action="comentar.php" method="POST">
        <input type="hidden" name="id_profesional" value="<?php echo $profID; ?>">
        <label>Calificación:</label>
        <div class="estrellas">
          <?php for ($i = 1; $i <= 5; $i++): ?>
            <label>
              <input type="radio" name="calificacion" value="<?php echo $i; ?>" required>
              <?php echo str_repeat('⭐', $i); ?>
            </label>
          <?php endfor; ?>
        </div>
        <textarea name="comentario" rows="3" placeholder="Escribí tu comentario..." required></textarea>
        <button type="submit" class="boton-profesional">
          <i class="fas fa-paper-plane"></i> Publicar comentario
        </button>
      </form>
    </div>
  <?php else: ?>
    <p class="aviso-login">🔐 Iniciá sesión para dejar tu comentario.</p>
  <?php endif; ?>

  <!-- GALERÍA DE TRABAJOS -->
  <div class="galeria-trabajos" style="display:none;">
    <?php if (!empty($trabajos)): ?>
      <?php foreach ($trabajos as $t): ?>
        <?php
          // Si tu campo imagen guarda "subcarpeta1/subcarpeta2/foo.jpg", aquí se respeta
          $relative = $t['imagen'] ?: 'default-trabajo.jpg';
          // URL final
          $urlImg = "{$baseURL}/trabajos/{$profID}/{$relative}";
        ?>
        <!-- DEBUG: campo imagen BD = <?php echo htmlspecialchars($relative); ?> | URL usada = <?php echo htmlspecialchars($urlImg); ?> -->
        <div class="trabajo-item">
          <img
            src="<?php echo htmlspecialchars($urlImg); ?>"
            alt="<?php echo htmlspecialchars($t['titulo']); ?>"
            loading="lazy"
            onerror="this.src='<?php echo $defaultTrabajo; ?>';"
          />
          <h4><?php echo htmlspecialchars($t['titulo']); ?></h4>
          <p><?php echo htmlspecialchars($t['descripcion']); ?></p>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Este profesional aún no subió trabajos.</p>
    <?php endif; ?>
  </div>

  <!-- COMENTARIOS -->
  <h3>🗣️ Comentarios de clientes</h3>
  <div class="comentarios-profesional">
    <?php if ($resultado_comentarios->num_rows > 0): ?>
      <?php while ($c = $resultado_comentarios->fetch_assoc()): ?>
        <div class="comentario-item">
          <p><strong><?php echo htmlspecialchars($c['nombre_cliente']); ?></strong> dijo:</p>
          <p>“<?php echo htmlspecialchars($c['comentario']); ?>”</p>
          <p>Calificación: <?php echo str_repeat('⭐', $c['calificacion']); ?></p>
          <p>📅 <?php echo date("d/m/Y", strtotime($c['fecha'])); ?></p>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No hay comentarios aún.</p>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
