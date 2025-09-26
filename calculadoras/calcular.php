<?php
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', 1);

$materiales = [
    "ladrillos_huecos" => ["nombre" => "Pared de ladrillos huecos", "unidad" => "m²", "datos" => [
        "Ladrillos huecos" => 15,
        "Cemento (kg)" => 2.2,
        "Cal (kg)" => 5.0,
        "Arena (m³)" => 0.042,
    ]],
    "ladrillos_macizos" => ["nombre" => "Pared de ladrillos comunes (macizos)", "unidad" => "m²", "datos" => [
        "Ladrillos macizos" => 55,
        "Cemento (kg)" => 2.2,
        "Cal (kg)" => 5.0,
        "Arena (m³)" => 0.042,
    ]],
    "bloques" => ["nombre" => "Pared de bloques de hormigón", "unidad" => "m²", "datos" => [
        "Bloques de hormigón" => 13.0,
        "Cemento (kg)" => 9.0,
        "Arena (m³)" => 0.021,
    ]],
    "contrapiso" => ["nombre" => "Contrapiso (espesor 8 cm)", "unidad" => "m²", "datos" => [
        "Cemento (kg)" => 9.0,
        "Arena (m³)" => 0.021,
        "Cascote (m³)" => 0.049,
    ]],
    "carpeta" => ["nombre" => "Carpeta (espesor 2 cm)", "unidad" => "m²", "datos" => [
        "Cemento (kg)" => 9.0,
        "Cal (kg)" => 5.0,
        "Arena fina (m³)" => 0.021,
    ]],
    "revoque" => ["nombre" => "Revoque grueso", "unidad" => "m²", "datos" => [
        "Cemento (kg)" => 4.5,
        "Cal (kg)" => 5.0,
        "Arena (m³)" => 0.035,
    ]],
    "columna" => ["nombre" => "Columna de hormigón 12x20 cm", "unidad" => "metro lineal", "datos" => [
        "Hormigón (m³)" => 0.024,
        "Cemento (kg)" => 9.0,
        "Arena (m³)" => 0.021,
        "Piedra partida (m³)" => 0.021,
    ]],
    "viga" => ["nombre" => "Viga aérea 25x12 cm", "unidad" => "metro lineal", "datos" => [
        "Hormigón (m³)" => 0.03,
        "Cemento (kg)" => 9.0,
        "Arena (m³)" => 0.021,
        "Piedra partida (m³)" => 0.021,
    ]],
    "hormigon" => ["nombre" => "Hormigón (general)", "unidad" => "m³", "datos" => [
        "Cemento (kg)" => 9.0,
        "Arena (m³)" => 0.021,
        "Piedra partida (m³)" => 0.021,
    ]],
    "losa_telgopor" => ["nombre" => "Losa alivianada con telgopor", "unidad" => "m²", "datos" => [
        "Hormigón (m³)" => 0.03,
        "Viguetas (ml)" => 1.2,
        "Ladrillos telgopor" => 2,
        "Cemento (kg)" => 9.0,
        "Arena (m³)" => 0.021,
        "Piedra partida (m³)" => 0.021,
    ]],
    "encadenado" => ["nombre" => "Encadenado 20x12 cm", "unidad" => "metro lineal", "datos" => [
        "Hormigón (m³)" => 0.024,
        "Cemento (kg)" => 9.0,
        "Arena (m³)" => 0.021,
        "Piedra partida (m³)" => 0.021,
    ]],
];

$resultado = [];
$seleccion = "";
$unidad = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $opcion = $_POST["tipo"] ?? "";
    
$largo = (float) ($_POST["largo"] ?? 0.0);
    $ancho = (float) ($_POST["ancho"] ?? 0.0);
    $alto  = (float) ($_POST["alto"] ?? 0.0);

    if (isset($materiales[$opcion])) {
        $seleccion = $materiales[$opcion]["nombre"];
        $unidad = $materiales[$opcion]["unidad"];

        if (in_array($opcion, ["ladrillos_huecos", "ladrillos_macizos", "bloques", "revoque"])) {
            $cantidad = $alto * $largo;
        } elseif (in_array($opcion, ["contrapiso", "carpeta"])) {
            $cantidad = $ancho * $largo;
        } elseif ($opcion === "losa_telgopor") {
            $cantidad = $ancho * $largo;
            $viguetas_por_metro = 1 / 0.5;
            $cantidad_viguetas = ceil($largo * $viguetas_por_metro);
            $ml_viguetas = $cantidad_viguetas * $ancho;
        } elseif (in_array($opcion, ["columna", "viga", "encadenado"])) {
            $cantidad = $largo;
        } elseif ($opcion === "hormigon") {
            $cantidad = $ancho * $largo * $alto;
        } else {
            $cantidad = $ancho * $largo;
        }

        foreach ($materiales[$opcion]["datos"] as $mat => $valor) {
            $total = ($opcion === "losa_telgopor" && $mat === "Viguetas (ml)") ? $ml_viguetas + $ancho: $valor * $cantidad ;

            if (str_contains($mat, "kg")) {
                $bolsas = ceil($total / 25);
                $resultado[$mat] = "$total kg ($bolsas bolsas de 25 kg)";
            } elseif (str_contains($mat, "(m³)")) {
                $resultado[$mat] = "$total metros";
            } else {
                $resultado[$mat] = "$total";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora de Materiales</title>
    <link rel="stylesheet" href="/construpro/css/estilos.css?v=<?php echo time(); ?>">
    <style>
        body {
            background-color: #0056b3;
            background-size: cover;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .contenedor1 {
            width: 80%;
            margin: 0 auto;
            padding: 10%;
            background-color: #fff;
            background-image: url("../img/fondo.png");
            text-align: center;
            border-radius: 12px;
        }
        .logo {
            width: 15%;
            position: absolute;
            top: 0;
            left: 0 ;
            margin: 10px;
            box-shadow: 0 4px 10px #000;

        }
        label {
            display: block;
            margin-bottom: 9px;
            font-weight: bold;
            color: #000;
        }
        h1 {
            text-align: center;
            color: #fff;
            font-size: 4em;
            margin-top: 10px;
        }
        h2{
            text-align: center;
            color: #000;
            font-size: 2em ;
        }
        select, input[type="number"] {
            width: 40%;
            padding: 10px;
            margin-bottom: 18px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        .opcion{
            color: #fff;
            font-size: 1.2em;
            margin-top: 10px;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .resultados {
            margin-top: 30px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #ddd;
        }
        .resultados li {
            margin-bottom: 8px;
        }
        .boton-profesional {
            background-color: #007bff;
            color: #fff;
            padding: 12px 24px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;}
        .boton-profesional:hover {
            background-color: #0056b3;  
        }
        .nav{
            background-color: #008abc; 
            position: absolute ;
            top: 10px;
            right: 10px;
        }
    </style>    
</head>
<body>
    <div>
    <nav class="nav">
        <a href="../index.php" class="bnt-inicio">volver al inicio</a>
    </nav>
    </div>
    <div class="contenedor1">
        <img src="../img/logo.png" alt="Logo" class="logo">
        <h1>🧮 Calculadora de Materiales</h1>
        <form method="POST" action="">
            <label for="tipo" class="opcion">Seleccione el tipo de material o estructura:</label>
            <select id="tipo" name="tipo" required>
                <option value="" disabled selected>-- Seleccione --</option>
                <?php foreach ($materiales as $key => $mat): ?>
                    <option value="<?php echo $key; ?>" <?php if ($key === ($_POST["tipo"] ?? "")) echo "selected"; ?>>
                        <?php echo $mat["nombre"]; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="largo" class="opcion">Largo (m):</label>
            <input type="number" id="largo" name="largo" step="0.01" min="0" value="<?php echo htmlspecialchars($_POST["largo"] ?? ""); ?>" required>

            <label for="ancho" class="opcion">Ancho (m):</label>
            <input type="number" id="ancho" name="ancho" step="0.01" min="0" value="<?php echo htmlspecialchars($_POST["ancho"] ?? ""); ?>" required>

            <label for="alto" class="opcion">Alto (m):</label>
            <input type="number" id="alto" name="alto" step="0.01" min="0" value="<?php echo htmlspecialchars($_POST["alto"] ?? ""); ?>" required>

            <button type="submit" class="boton-profesional">Calcular</button>
        </form>

        <?php if (!empty($resultado)): ?>
            <div class="resultados">
                <h2>📦 Resultados para <?php echo htmlspecialchars($seleccion); ?> (<?php echo htmlspecialchars($unidad); ?>)</h2>
                <ul>
                    <?php foreach ($resultado as $mat => $cant): ?>
                        <li><?php echo htmlspecialchars($mat); ?>: <?php echo htmlspecialchars($cant); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</body>
</html> 