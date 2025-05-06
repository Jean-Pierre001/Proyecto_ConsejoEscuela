<?php
include '../baseDatos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $turno = $_POST['turno'];
    $servicio = $_POST['servicio'];
    $edificio_compartido = isset($_POST['edificio_compartido']) ? 1 : 0;
    $cue = $_POST['cue'];
    $direccion = $_POST['direccion'];
    $localidad = $_POST['localidad'];
    $telefono = $_POST['telefono'];
    $correo_electronico = $_POST['correo_electronico'];
    $directivo = $_POST['directivo'];
    $vicedirectora = $_POST['vicedirectora'];
    $secretaria = $_POST['secretaria'];

    $sql_insert = "INSERT INTO escuelas (
        turno, servicio, edificio_compartido, CUE, direccion, localidad,
        telefono, correo_electronico, directivo, vicedirectora, secretaria
    ) VALUES (
        :turno, :servicio, :edificio_compartido, :cue, :direccion, :localidad,
        :telefono, :correo_electronico, :directivo, :vicedirectora, :secretaria
    )";

    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->execute([
        'turno' => $turno,
        'servicio' => $servicio,
        'edificio_compartido' => $edificio_compartido,
        'cue' => $cue,
        'direccion' => $direccion,
        'localidad' => $localidad,
        'telefono' => $telefono,
        'correo_electronico' => $correo_electronico,
        'directivo' => $directivo,
        'vicedirectora' => $vicedirectora,
        'secretaria' => $secretaria
    ]);

    header("Location: escuelas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Escuela</title>
    <link rel="stylesheet" href="estilos/agregarEscuela.css">
</head>
<body>

<div class="container">
    <header>
        <h1>Agregar Nueva Escuela</h1>
    </header>

    <form action="" method="POST">
        <label for="turno">Turno:</label>
        <input type="text" id="turno" name="turno" required>

        <label for="servicio">Servicio:</label>
        <input type="text" id="servicio" name="servicio" required>

        <label>
            <input type="checkbox" name="edificio_compartido">
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

        <label for="correo_electronico">Correo electrónico:</label>
        <input type="email" id="correo_electronico" name="correo_electronico" required>

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
</html>
