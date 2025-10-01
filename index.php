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
        padding: 1%;
        background-image: url("img/fondo.png");
        background-size: cover;
        background-position: center;
        text-align: center;
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
    }
    .encabezado {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 20px;
                }

    .logo {
                width: 15%;
                height: auto;
                position: static;
                margin: 0;
                box-shadow: 0 4px 10px #000;
        }

    .nav {
                background-color: #48e;
                margin: 10px 0;
    }

.nav__list {
    display: block;
    gap: 15px;
    margin: 0;
    padding: 0;
    list-style: none;
}

.nav__item {
    
        display: inline-block;
        margin: 0 25px;
}

.nav__link {
    color: #fff;
    text-decoration: none;
    padding: 10px 15px;
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
    .bienvenida{
        margin: 20px;
        align-items: center;
        width: 56em;
        background-color: #fff;
        position: static;
        margin: auto;
    }
    h1 {
        font-size: 6em;
        margin: 20px 0;
        color: #000;
        text-shadow: 0 4px 20px #ccc;
    }

    footer {
        text-align: center;
        padding: 20px;
        background-color: #48e;
        color: #fff;
        font-weight: bold;
    }
    .carousel{
        background-position: center;
        align-items: center;
    }
    .carousel-item{
        width: 60em;
    }
    .caption {
        position: absolute;
        top: 20px;
        left: 20px;
        font-size: 40px;
        color: white;
        background-color: transparent;
        padding: 20px;
        border-radius: 5px;
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
            <div class="encabezado">
                <img src="img/logo.png" alt="Logo Construpro" class="logo">
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
        </div>

            <div class="bienvenida">
                <h1>Bienvenidos</h1>
                <p>Esta pagina fue creada para conectar profesionales de la construcción ,Para conttruir o refaccionar tu casa. <br>
                Aqui encontraras albañiles, pintores ,plomeros ,Electricistas ,etc </p>
            </div>

        <div id="carouselInicio" class="carousel slide mb-4 mx-auto" style="max-width: 900px;" data-bs-ride="carousel" data-bs-interval="3000">

            <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/tr14.jpeg"  class="d-block w-100" alt="tr2.jpeg" >
                <div class="caption">plomeria en baño</div>
            </div>
            <div class="carousel-item">
                <img src="img/tr7.jpg" class="d-block w-100" alt="tr5.jpg">
                    <div class="caption">revoque de pared</div>
            </div>
            <div class="carousel-item">
                <img src="img/tr16.jpeg" class="d-block w-100" alt="tr4.jpeg">
                    <div class="caption">contruccion con bloques</div>
            </div>
            <div class="carousel-item">
                <img src="img/tr6.jpg" class="d-block w-100" alt="tr4.jpeg">
                    <div class="caption">techos de loza</div>
            </div>
            <div class="carousel-item">
                <img src="img/tr12.jpg" class="d-block w-100" alt="tr4.jpeg">
                    <div class="caption">armado techo de chapa</div>
            </div>
            <div class="carousel-item">
                <img src="img/tr10.jpg" class="d-block w-100" alt="tr4.jpeg">
                    <div class="caption">contruccion en seco</div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselInicio" data-bs-slide="prev">
            <span class="carrousel-control-prev-icon"></span>
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
</body>
</html>
