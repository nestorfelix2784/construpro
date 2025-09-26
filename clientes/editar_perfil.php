<?php
session_start();
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login_cliente.php");
    exit();
}

include_once __DIR__ . '/../includes/conexion.php';
$cliente_id = $_SESSION['cliente_id'];

$stmt = $conexion->prepare("SELECT * FROM clientes WHERE id = ?");
$stmt->bind_param("i", $cliente_id);
$stmt->execute();
$cliente = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Perfil</title>
  <link rel="stylesheet" href="/css/estilos.css">
</head>
<body>
  <div class="tarjeta-perfil">
    <h2>✏️ Editar mi perfil</h2>
    <form method="POST" action="guardar_edicion.php">
      <input type="hidden" name="id" value="<?php echo $cliente_id; ?>">
      <label>Nombre:</label>
      <input type="text" name="nombre" value="<?php echo htmlspecialchars($cliente['nombre']); ?>" required>
      <label>Email:</label>
      <input type="email" name="email" value="<?php echo htmlspecialchars($cliente['email']); ?>" required>
      <label>Teléfono:</label>
      <input type="text" name="telefono" value="<?php echo htmlspecialchars($cliente['telefono']); ?>">
      <label>Dirección:</label>
      <input type="text" name="direccion" value="<?php echo htmlspecialchars($cliente['direccion']); ?>">

      <button type="submit" class="boton-profesional">
        <i class="fas fa-save"></i> Guardar cambios
      </button>
    </form>
  </div>
</body>
</html>
