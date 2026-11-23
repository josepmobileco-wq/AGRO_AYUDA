
<?php
require_once "sesion.php";

if (isset($_SESSION['usuario_id'])) {
    header("Location: panel.php");
    exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión - AgroAyuda</title>
</head>
<body>

<h2>Bienvenido a AgroAyuda</h2>

<?php if (isset($_GET['registro'])): ?>
    <p>Tu cuenta se creó correctamente.</p>
<?php endif; ?>

<form action="procesar_login.php" method="POST">

    <input type="hidden" name="csrf_token"
    value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

    <label>Correo electrónico:</label>
    <input type="email" name="correo" required>

    <br><br>

    <label>Contraseña:</label>
    <input type="password" name="password" required>

    <br><br>

    <button type="submit">Iniciar sesión</button>

</form>

</body>
</html>
