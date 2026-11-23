
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

$correo = trim($_POST['correo'] ?? '');
$password = $_POST['password'] ?? '';

if (
    !filter_var($correo, FILTER_VALIDATE_EMAIL) ||
    $password === '' ||
    strlen($password) > 72
) {
    exit("Correo o contraseña incorrectos");
}

// Consultar usuario
$sql = "SELECT id_usuario, nombre, apellido,
               correo, contraseña, estado, rol
        FROM usuario
        WHERE correo = :correo
        LIMIT 1";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    ':correo' => $correo
]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Comprobar credenciales y estado
if (
    !$usuario ||
    $usuario['estado'] !== 'Activo' ||
    !password_verify($password, $usuario['contraseña'])
) {
    exit("Correo o contraseña incorrectos");
}

// Regenerar identificador de sesión
if (!session_regenerate_id(true)) {
    exit("No se pudo iniciar la sesión");
}

// Guardar información del usuario
$_SESSION['usuario_id'] = $usuario['id_usuario'];
$_SESSION['nombre'] = $usuario['nombre'];
$_SESSION['apellido'] = $usuario['apellido'];
$_SESSION['rol'] = $usuario['rol'];

unset($_SESSION['csrf_token']);

// Redireccionar según el rol
switch ($usuario['rol']) {

    case 'administrador':
        header("Location: panel_admin.php");
        break;

    case 'agricultor':
        header("Location: panel_agricultor.php");
        break;

    case 'comprador':
        header("Location: panel_comprador.php");
        break;

    case 'transportador':
        header("Location: panel_transportador.php");
        break;

    default:
        $_SESSION = [];
        session_destroy();
        exit("Rol no autorizado");
}

exit;

?>
