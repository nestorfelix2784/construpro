<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Construpro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 0;
        background-color: #0056b3;
        font-family: sans-serif;
    }

    .pagina {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    main {
        flex: 1;
    }

    .contenedor {
        padding: 10%;
        background-image: url("img/fondo.png");
        background-size: cover;
        background-position: center;
        text-align: center;
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
    }

    .logo {
        max-width: 80%;
        height: auto;
        margin-bottom: 20px;
        box-shadow: 0 4px 30px #000;
    }

    .nav {
        background-color: #48e;
        margin: 20px 0;
    }

    .nav__list {
        text-align: center;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .nav__item {
        display: inline-block;
        margin: 0 10px;
    }

    .nav__link {
        color: #fff;
        text-decoration: none;
        padding: 10px 20px;
        background-color: #48e;
        border-radius: 6px;
        transition: background-color 0.3s ease;
    }

    .nav__link:hover {
        background-color: #59e;
    }

    .alert {
        background-color: #28a745;
        color: #fff;
        padding: 15px;
        margin: 20px auto;
        border-radius: 8px;
        width: fit-content;
        animation: fadeOut 5s ease forwards;
    }

    @keyframes fadeOut {
        0% { opacity: 1; }
        80% { opacity: 1; }
        100% { opacity: 0; display: none; }
    }

    h1 {
        font-size: 5em;
        margin: 20px 0;
        color: #000;
        text-shadow: 0 4px 10px #000;
    }

    footer {
        text-align: center;
        padding: 20px;
        background-color: #48e;
        color: #fff;
        font-weight: bold;
    }
</style>
</head>
<body>
<div class="pagina">

    <?php if (isset($_SESSION['logout_message'])): ?>
        <div class="alert"><?php echo $_SESSION['logout_message']; ?></div>
        <?php unset($_SESSION['logout_message']); ?>
    <?php endif; ?>

    <main>
        <div class="contenedor">
            <nav class="nav">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="/construpro/clientes/login_cliente.php" class="nav__link">Ingresar como Cliente</a>
                    </li>
                    <li class="nav__item">
                        <a href="/construpro/profesionales/login_profesional.php" class="nav__link">Ingresar como Profesional</a>
                    </li>
                    <li class="nav__item">
                        <a href="/construpro/calculadoras/calcular.php" class="nav__link">Calcula Material</a>
                    </li>
                </ul>
            </nav>

            <h1>Bienvenido a Construpro</h1>
            <img src="img/logo.png" alt="Logo Construpro" class="logo">
        </div>
    </main>

    <footer>
        <p>Proyecto final para la carrera de Tecnicatura Universitaria en Programación comisión 4C - UTN.</p>
    </footer>

</div>
</body>
</html>
