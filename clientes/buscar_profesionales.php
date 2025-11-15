<?php
session_start();
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit();
}

include_once __DIR__ . '/../includes/conexion.php';
include_once __DIR__ . '/../includes/header.php';

$termino = isset($_GET['termino']) ? trim($_GET['termino']) : '';
$resultados = [];

if ($termino !== '') {
    $termino = "%$termino%";
    $sql = "SELECT * FROM profesionales 
            WHERE oficio LIKE ? OR provincia LIKE ? OR partido LIKE ? OR localidad LIKE ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssss", $termino, $termino, $termino, $termino);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($fila = $result->fetch_assoc()) {
        $resultados[] = $fila;
    }
}
?>

<style>
.tarjeta-profesional {
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 12px;
  padding: 20px;
  margin-bottom: 24px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.04);
  transition: box-shadow 0.3s ease;
}
.tarjeta-profesional:hover {
  box-shadow: 0 6px 12px rgba(0,0,0,0.06);
}
.tarjeta-profesional h2 {
  color: #c80000;
  margin-bottom: 10px;
}
.tarjeta-profesional p {
  margin: 6px 0;
  font-size: 16px;
  color: #333;
}
.boton-ver {
  display: inline-block;
  margin-top: 12px;
  padding: 8px 16px;
  background-color: #007bff;
  color: white;
  border-radius: 6px;
  text-decoration: none;
  font-weight: bold;
  transition: background 0.3s ease;
}
.boton-ver:hover {
  background-color: #0056b3;
}
</style>

<div class="contenedor">
    <h2>Resultados de búsqueda</h2>

    <?php if (count($resultados) > 0): ?>
        <?php foreach ($resultados as $pro): ?>
            <div class="tarjeta-profesional">
                <h2><?= htmlspecialchars($pro['nombre'] ?? '') ?></h2>
                <p><i class="fas fa-tools"></i> Oficio: <?= htmlspecialchars($pro['oficio'] ?? '') ?></p>
                <p><i class="fas fa-map-marker-alt"></i> Zona: 
                    <?= htmlspecialchars($pro['provincia'] ?? '') ?>,
                    <?= htmlspecialchars($pro['partido'] ?? '') ?>,
                    <?= htmlspecialchars($pro['localidad'] ?? '') ?>
                </p>
                <a href="ver_profesional.php?id=<?= $pro['id']; ?>" class="boton-ver">👁️ Ver Perfil</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No se encontraron profesionales con ese criterio.</p>
    <?php endif; ?>
</div>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
