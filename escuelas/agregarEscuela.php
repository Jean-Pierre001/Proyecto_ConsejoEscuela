<?php
include '../baseDatos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombreEscuela = $_POST['nombreEscuela'];
    $turno = $_POST['turno'];
    $servicio = $_POST['servicio'];
    $edificioCompartido = isset($_POST['edificioCompartido']) ? 1 : 0;
    $cue = $_POST['cue'];
    $direccion = $_POST['direccion'];
    $localidad = $_POST['localidad'];
    $telefono = $_POST['telefono'];
    $correoElectronico = $_POST['correoElectronico'];
    $directivo = $_POST['directivo'];
    $vicedirectora = $_POST['vicedirectora'];
    $secretaria = $_POST['secretaria'];

    $sql_insert = "INSERT INTO escuelas (
        nombreEscuela, turno, servicio, edificioCompartido, CUE, direccion, localidad,
        telefono, correoElectronico, directivo, vicedirectora, secretaria
    ) VALUES (
        :nombreEscuela, :turno, :servicio, :edificioCompartido, :cue, :direccion, :localidad,
        :telefono, :correoElectronico, :directivo, :vicedirectora, :secretaria
    )";

    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->execute([
        'nombreEscuela' => $nombreEscuela,
        'turno' => $turno,
        'servicio' => $servicio,
        'edificioCompartido' => $edificioCompartido,
        'cue' => $cue,
        'direccion' => $direccion,
        'localidad' => $localidad,
        'telefono' => $telefono,
        'correoElectronico' => $correoElectronico,
        'directivo' => $directivo,
        'vicedirectora' => $vicedirectora,
        'secretaria' => $secretaria
    ]);

    header("Location: escuelas.php");
    exit();
}
?>

<!--<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar escuela</title>
    <link rel="stylesheet" href="estilos/agregarEscuela.css">
</head>
<body>
<nav id="mainNavbar" class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="escuelas.php">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span href="escuelas.php" class="navbar-toggler-icon">Volver</span>
            </button>
        </a>
    </div>

<div class="container">
    <header>
        <h1>Agregar nueva escuela</h1>
    </header>

    <form action="" method="POST">
        <label for="nombreEscuela">Nombre Escuela:</label>
        <input type="text" id="nombreEscuela" name="nombreEscuela" required>

        <label for="turno">Turno:</label>
        <input type="text" id="turno" name="turno" required>

        <label for="servicio">Servicio:</label>
        <input type="text" id="servicio" name="servicio" required>

        <label>
            <input type="checkbox" name="edificioCompartido">
            ¿Edificio compartido?
        </label>

        <label for="cue">CUE:</label>
        <input type="text" id="cue" name="cue" required>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" required>

        <label for="localidad">Localidad:</label>
        <input type="text" id="localidad" name="localidad" required>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required>

        <label for="correoElectronico">Correo electrónico:</label>
        <input type="email" id="correoElectronico" name="correoElectronico" required>

        <label for="directivo">Directivo:</label>
        <input type="text" id="directivo" name="directivo" required>

        <label for="vicedirectora">Vicedirectora:</label>
        <input type="text" id="vicedirectora" name="vicedirectora" required>

        <label for="secretaria">Secretaria:</label>
        <input type="text" id="secretaria" name="secretaria" required>

        <button type="submit" class="btn btn-agregar">Agregar Escuela</button>
    </form>
</div>

</body>
</html>-->
