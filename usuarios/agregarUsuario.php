<?php
include '../baseDatos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $contrasena_plana = $_POST['contrasena'];
    $tipo = $_POST['tipo'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    // Hashear la contraseña antes de guardarla
    $contrasena_hash = password_hash($contrasena_plana, PASSWORD_DEFAULT);

    $sql_insert = "INSERT INTO usuarios (
        nombre, contrasena, tipo, correo, telefono
    ) VALUES (
        :nombre, :contrasena, :tipo, :correo, :telefono
    )";

    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->execute([
        'nombre' => $nombre,
        'contrasena' => $contrasena_hash,
        'tipo' => $tipo,
        'correo' => $correo,
        'telefono' => $telefono
    ]);

    header("Location: usuarios.php");
    exit();
}
?>

<!--<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario</title>
    <link rel="stylesheet" href="estilos/agregarUsuario.css">
</head>
<body>

<div class="container">
    <header>
        <h1>Registrar Nuevo Usuario</h1>
    </header>

    <form action="" method="POST">
        <label for="nombre">Nombre de usuario:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>

        <label for="tipo">Tipo de usuario:</label>
        <select id="tipo" name="tipo" required>
            <option value="administrador">Administrador</option>
            <option value="directivo">Directivo</option>
        </select>

        <label for="correo">Correo electrónico:</label>
        <input type="email" id="correo" name="correo" required>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required>

        <button type="submit" class="btn btn-agregar">Registrar Usuario</button>
    </form>
</div>

</body>
</html>-->
