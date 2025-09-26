<?php
session_start();
session_unset();
session_destroy();

// Reiniciar sesión solo para mostrar el mensaje
session_start();
$_SESSION['logout_message'] = "Sesión cerrada correctamente";

header("Location: /construpro/index.php");
exit;
