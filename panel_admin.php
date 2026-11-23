
<?php

require_once "sesion.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['rol'] !== 'administrador') {
    http_response_code(403);
    exit("No tienes permiso para acceder.");
}

?>
