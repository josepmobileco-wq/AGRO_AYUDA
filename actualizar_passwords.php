
<?php

require_once "conexion.php";

$stmt = $conexion->query(
    "SELECT id_usuario, contraseña FROM usuario"
);

$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($usuarios as $usuario) {

    $passwordActual = $usuario['contraseña'];

    // Comprobar si ya tiene formato de hash reconocido
    $info = password_get_info($passwordActual);

    if ($info['algo'] === null) {

        $nuevoHash = password_hash(
            $passwordActual,
            PASSWORD_DEFAULT
        );

        $actualizar = $conexion->prepare(
            "UPDATE usuario
             SET contraseña = :password
             WHERE id_usuario = :id"
        );

        $actualizar->execute([
            ':password' => $nuevoHash,
            ':id' => $usuario['id_usuario']
        ]);

    }

}

echo "Proceso de actualización finalizado.";

?>
