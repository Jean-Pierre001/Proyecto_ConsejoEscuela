<?php
include '../baseDatos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $nivelModalidad = $_POST['nivelModalidad'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    $sql_insert = "INSERT INTO Inspectores (
        nombre, nivelModalidad, telefono, correo
    ) VALUES (
        :nombre, :nivelModalidad, :telefono, :correo
    )";

    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->execute([
        'nombre' => $nombre,
        'nivelModalidad' => $nivelModalidad,
        'telefono' => $telefono,
        'correo' => $correo
    ]);

    header("Location: Inspectores.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Inspectores</title>
    <link rel="stylesheet" href="estilos/agregarInspectores.css">
</head>
<body>

<div class="container">
    <header>
        <h1>Registrar Nuevo Inspector</h1>
    </header>

    <form action="" method="POST">
        <label for="nombre">Nombre de Inspectores:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="nivelModalidad">Nivel De Modalidad:</label>
        <input type="text" id="nivelModalidad" name="nivelModalidad" required>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required>

        <label for="correo">Correo electrónico:</label>
        <input type="email" id="correo" name="correo" required>

        <button type="submit" class="btn btn-agregar">Registrar Inspectores</button>
    </form>
</div>

</body>
</html>
