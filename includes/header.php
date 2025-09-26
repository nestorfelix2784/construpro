<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
$rutaPrincipal = $protocolo . $host . '/construpro/index.php'; // <-- cuidado con minúsculas en 'construpro'
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Construpro</title>
    <link rel="stylesheet" href="/construpro/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="<?php echo $fondo ?? 'fondo-inicio'; ?>">
<header>
    <h1><a href="<?php echo $rutaPrincipal; ?>">Construpro</a></h1>
    <nav>
        <ul>
            <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'cliente'): ?>
                <li><a href="/construpro/clientes/perfil.php">Mi Perfil</a></li>
                <li>
                    <form action="/construpro/includes/logout.php" method="POST" style="display:inline;">
                        <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                    </form>
                </li>
            <?php elseif (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'profesional'): ?>
                <li><a href="/construpro/panel/dashboard.php">Panel</a></li>
                <li>
                    <form action="/construpro/includes/logout.php" method="POST" style="display:inline;">
                        <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                    </form>
                </li>
            <?php else: ?>
                <li><a href="/construpro/clientes/login.php">Login Cliente</a></li>
                <li><a href="/construpro/profesionales/login.php">Login Profesional</a></li>
                <li><a href="/construpro/clientes/register.php">Registro Cliente</a></li>
                <li><a href="/construpro/profesionales/register.php">Registro Profesional</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
