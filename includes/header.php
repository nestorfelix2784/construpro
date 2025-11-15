<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
$rutaPrincipal = $protocolo . $host . '/construpro/index.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Construpro - Encuentra profesionales de la construcción</title>
    <meta name="description" content="Plataforma para conectar clientes con profesionales de la construcción de confianza">
    <link rel="stylesheet" href="/construpro/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVottePpZmZZzw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="<?php echo $fondo ?? 'fondo-inicio'; ?>">
<header>
    <div class="contenedor">
        <div class="header-contenido">
            <h1 class="logo">
                <a href="<?php echo $rutaPrincipal; ?>">
                    <i class="fas fa-home"></i> Construpro
                </a>
            </h1>
            
            <button class="menu-toggle" aria-label="Menú de navegación">
                <i class="fas fa-bars"></i>
            </button>
            
            <nav class="navegacion">
                <ul class="menu">
                    <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'cliente'): ?>
                        <li><a href="/construpro/clientes/perfil.php"><i class="fas fa-user"></i> Mi Perfil</a></li>
                        <li><a href="/construpro/clientes/buscar_profesionales.php"><i class="fas fa-search"></i> Buscar Profesionales</a></li>
                        <li>
                            <form action="/construpro/includes/logout.php" method="POST" class="form-logout">
                                <button type="submit" class="btn btn-outline"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button>
                            </form>
                        </li>
                    <?php elseif (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'profesional'): ?>
                        <li><a href="/construpro/panel/dashboard.php"><i class="fas fa-tachometer-alt"></i> Panel</a></li>
                        <li><a href="/construpro/profesionales/perfil.php"><i class="fas fa-id-card"></i> Mi Perfil</a></li>
                        <li>
                            <form action="/construpro/includes/logout.php" method="POST" class="form-logout">
                                <button type="submit" class="btn btn-outline"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button>
                            </form>
                        </li>
                    <?php else: ?>
                        <li><a href="/construpro/clientes/login.php"><i class="fas fa-sign-in-alt"></i> Acceso Clientes</a></li>
                        <li><a href="/construpro/profesionales/login.php"><i class="fas fa-tools"></i> Área Profesionales</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</header>

<main class="contenedor">
