<?php
session_start();

$_SESSION['cliente_id'] = 999; // valor ficticio
header("Location: /construpro/clientes/perfil.php");
exit();
