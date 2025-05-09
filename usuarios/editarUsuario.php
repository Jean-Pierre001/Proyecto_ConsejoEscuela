<?php
include '../baseDatos/conexion.php';

if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];

    // Obtener los datos actuales
    $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_usuario' => $id_usuario]);
    $usuario = $stmt->fetch();

    if (!$usuario) {
        header("Location: usuarios.php");
        exit();
    }
} else {
    header("Location: usuarios.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $contrasena = $_POST['contrasena'];
    $tipo = $_POST['tipo'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    // Verificar si la contraseña fue cambiada
    if (!empty($contrasena)) {
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

        $sql_update = "UPDATE usuarios SET 
            nombre = :nombre,
            contrasena = :contrasena,
            tipo = :tipo,
            correo = :correo,
            telefono = :telefono
            WHERE id_usuario = :id_usuario";

        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute([
            'nombre' => $nombre,
            'contrasena' => $contrasena_hash,
            'tipo' => $tipo,
            'correo' => $correo,
            'telefono' => $telefono,
            'id_usuario' => $id_usuario
        ]);
    } else {
        // No se modifica la contraseña
        $sql_update = "UPDATE usuarios SET 
            nombre = :nombre,
            tipo = :tipo,
            correo = :correo,
            telefono = :telefono
            WHERE id_usuario = :id_usuario";

        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute([
            'nombre' => $nombre,
            'tipo' => $tipo,
            'correo' => $correo,
            'telefono' => $telefono,
            'id_usuario' => $id_usuario
        ]);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="estilos/editarusuario.css">
</head>
<body>

<div class="container">
    <header>
        <h1>Editar Usuario</h1>
    </header>

    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>

        <label for="contrasena">Nueva Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" placeholder="Dejar en blanco para no cambiar">

        <label for="tipo">Tipo:</label>
        <input type="text" id="tipo" name="tipo" value="<?= htmlspecialchars($usuario['tipo']) ?>" required>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($usuario['correo']) ?>" required>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($usuario['telefono']) ?>" required>

        <button type="submit" class="btn btn-editar">Actualizar Usuario</button>
    </form>
</div>

</body>
</html>
