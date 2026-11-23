
<?php
$host = "localhost";
$basedatos = "agroayuda";
$usuario = "root";
$contrasena = "";

try {
    $conexion = new PDO(
        "mysql:host=$host;dbname=$basedatos;charset=utf8mb4",
        $usuario,
        $contrasena
    );

    $conexion->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    echo "¡Conexión con la base de datos exitosa!";
    
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
