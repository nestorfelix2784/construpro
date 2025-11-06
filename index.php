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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
    /* Tus estilos personalizados (sin cambios) */
    body {
        margin: 0;
        padding: 0;
        background-color: #0056b3;
        font-family: sans-serif;
    }
    .contenedor {
        padding: 1%;
        background-image: url("img/fondo.png");
        background-size: cover;
        background-position: center;
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
    }
    .logo {
        max-width: 150px;
        box-shadow: 0 4px 10px #000;
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
    .bienvenida {
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        max-width: 900px;
        text-align: center;
    }
    h1 {
        font-size: 4em;
        margin: 20px 0;
        color: #000;
        text-shadow: 0 4px 20px #ccc;
    }
    @media (max-width: 768px) {
        h1 {
        font-size: 2em;
        }
    }
    footer {
        text-align: center;
        padding: 20px;
        background-color: #48e;
        color: #fff;
        font-weight: bold;
    }
    .caption {
        position: absolute;
        top: 20px;
        left: 20px;
        font-size: 1.5em;
        color: white;
        background-color: rgba(0,0,0,0.4);
        padding: 10px;
        border-radius: 5px;
    }
    .nav__list {
        display: flex;
        gap: 15px;
        margin: 0;
        padding: 0;
        list-style: none;
        flex-wrap: wrap;
    }
    .nav__item {
        margin: 0 10px;
    }
    .nav__link {
        color: #fff !important;
        text-decoration: none;
        padding: 10px 15px;
        background-color: #48e;
        border-radius: 6px;
        transition: background-color 0.3s ease;
        display: inline-block;
    }
    .nav__link:hover {
        background-color: #59e;
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
        <div class="container-fluid py-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-3 text-center">
            <img src="/img/logo.png" alt="Construpro logo showing the company name Construpro next to a stylized construction helmet icon, used as site header branding; conveys a professional and trustworthy tone" class="logo img-fluid">
            </div>
            <div class="col-12 col-md-9">
            <nav class="navbar navbar-expand-lg bg-primary">
                <div class="container-fluid">
                <a class="navbar-brand text-white" href="#">Construpro</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav nav__list">
                    <li class="nav-item nav__item">
                        <a class="nav-link nav__link" href="/www/clientes/login_cliente.php">Ingresar como Cliente</a>
                    </li>
                    <li class="nav-item nav__item">
                        <a class="nav-link nav__link" href="/www/profesionales/login_profesional.php">Ingresar como Profesional</a>
                    </li>
                    <li class="nav-item nav__item">
                        <a class="nav-link nav__link" href="/www/calculadoras/calcular.php">Calcula Material</a>
                    </li>
                    </ul>
                </div>
                </div>
            </nav>
        </div>
        </div>
        </div>

        <div class="bienvenida">
        <h1>Bienvenidos</h1>
        <p>Esta página fue creada para conectar profesionales de la construcción. Aquí encontrarás albañiles, pintores, plomeros, electricistas, etc.</p>
        </div>

        <div id="carouselInicio" class="carousel slide mb-4 mx-auto" style="max-width: 900px;" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
            <div class="carousel-item active">
            <img src="img/tr14.jpeg" class="d-block w-100 img-fluid" alt="plomería en baño">
            <div class="caption">Plomería en baño</div>
            </div>
            <div class="carousel-item">
            <img src="img/tr7.jpg" class="d-block w-100 img-fluid" alt="revoque de pared">
            <div class="caption">Revoque de pared</div>
            </div>
            <div class="carousel-item">
            <img src="img/tr16.jpeg" class="d-block w-100 img-fluid" alt="construcción con bloques">
            <div class="caption">Construcción con bloques</div>
            </div>
            <div class="carousel-item">
            <img src="img/tr6.jpg" class="d-block w-100 img-fluid" alt="techos de loza">
            <div class="caption">Techos de loza</div>
            </div>
            <div class="carousel-item">
            <img src="img/tr12.jpg" class="d-block w-100 img-fluid" alt="armado techo de chapa">
            <div class="caption">Armado techo de chapa</div>
            </div>
            <div class="carousel-item">
            <img src="img/tr10.jpg" class="d-block w-100 img-fluid" alt="construcción en seco">
            <div class="caption">Construcción en seco</div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselInicio" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselInicio" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
        </div>
    </div>
    </main>

    <footer>
    <p>Proyecto final para la carrera de Tecnicatura Universitaria en Programación comisión 4C - UTN. Damian Noble Nestor Fernandez</p>
    </footer>

</div>

<!-- ✅ Funciones seguras para manipulación DOM -->
<script>
function safeInsertBefore(parent, newNode, referenceNode) {
    if (referenceNode && referenceNode.parentNode === parent) {
    parent.insertBefore(newNode, referenceNode);
    } else {
    parent.appendChild(newNode);
    } 
}

function safeRemoveChild(parent, child) {
    if (child && child.parentNode === parent) {
    parent.removeChild(child);
    } else {
    console.warn("⚠️ El nodo no pertenece al contenedor. No se puede eliminar.");
    }
}

window.addEventListener("error", function (e) {
    if (e.message.includes("insertBefore")) {
    console.warn("⚠️ insertBefore falló: referencia inválida. Se usará appendChild como fallback.");
    e.preventDefault();
    }
    if (e.message.includes("removeChild")) {
    console.warn("⚠️ removeChild falló: el nodo no es hijo del contenedor.");
    e.preventDefault();
    }
}, true);
</script>

</body>
</html>

