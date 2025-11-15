<?php
session_start();

$_SESSION['cliente_id'] = 999; // valor ficticio
header("Location: /clientes/perfil.php");
exit();
