
<?php

require_once "conexion.php";
require_once "sesion.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit("Método no permitido");
}

if (
    !isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    exit("Solicitud no válida");
}

$nombre = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$password = $_POST['password'] ?? '';

if (
    $nombre === '' ||
    $apellido === '' ||
    !filter_var($correo, FILTER_VALIDATE_EMAIL) ||
    $telefono === '' ||
    strlen($password) < 12 ||
    strlen($password) > 72
) {
    exit("Verifica los datos ingresados.");
}

// Generar hash de contraseña
$passwordHash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

// El registro público siempre será comprador
$rol = 'comprador';
$estado = 'Activo';

try {

    $sql = "INSERT INTO usuario
    (nombre, apellido, correo, telefono,
     contraseña, estado, rol)
    VALUES
    (:nombre, :apellido, :correo, :telefono,
     :password, :estado, :rol)";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':nombre' => $nombre,
        ':apellido' => $apellido,
        ':correo' => $correo,
        ':telefono' => $telefono,
        ':password' => $passwordHash,
        ':estado' => $estado,
        ':rol' => $rol
    ]);

    unset($_SESSION['csrf_token']);

    header("Location: login.php?registro=exitoso");
    exit;

} catch (PDOException $e) {

    if ($e->getCode() === '23000') {
        exit("No se pudo completar el registro. Verifica el correo.");
    }

    error_log($e->getMessage());
    exit("Error al registrar el usuario.");

}
