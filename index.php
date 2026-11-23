
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>AgroAyuda</title>
</head>
<body>

    <h1>Bienvenido a AgroAyuda</h1>

    <h2>Crear una cuenta</h2>

    <form action="registro/registrar.php" method="POST">

        <label>Nombre:</label>
        <input type="text" name="nombre" required>
        <br><br>

        <label>Apellido:</label>
        <input type="text" name="apellido" required>
        <br><br>

        <label>Correo electrónico:</label>
        <input type="email" name="correo" required>
        <br><br>

        <label>Teléfono:</label>
        <input type="text" name="telefono">
        <br><br>

        <label>Contraseña:</label>
        <input type="password" name="contrasena" required>
        <br><br>

        <button type="submit">Registrarme</button>

    </form>

</body>
</html>
