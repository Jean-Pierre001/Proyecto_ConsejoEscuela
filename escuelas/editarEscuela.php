<?php
include '../baseDatos/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos actuales
    $sql = "SELECT * FROM escuelas WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $escuela = $stmt->fetch();

    if (!$escuela) {
        header("Location: escuelas.php");
        exit();
    }
} else {
    header("Location: escuelas.php");
    exit();
}

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

    $sql_update = "UPDATE escuelas SET 
        turno = :turno,
        servicio = :servicio,
        edificio_compartido = :edificio_compartido,
        CUE = :cue,
        direccion = :direccion,
        localidad = :localidad,
        telefono = :telefono,
        correo_electronico = :correo_electronico,
        directivo = :directivo,
        vicedirectora = :vicedirectora,
        secretaria = :secretaria
        WHERE id = :id";

    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute([
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
        'secretaria' => $secretaria,
        'id' => $id
    ]);

    header("Location: escuelas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Escuela</title>
    <link rel="stylesheet" href="estilos/editarEscuela.css"> <!-- Asegúrate de tener este archivo -->
</head>
<body>

<div class="container">
    <header>
        <h1>Editar Escuela</h1>
    </header>

    <form method="POST">
        <label for="turno">Turno:</label>
        <input type="text" id="turno" name="turno" value="<?= htmlspecialchars($escuela['turno']) ?>" required>

        <label for="servicio">Servicio:</label>
        <input type="text" id="servicio" name="servicio" value="<?= htmlspecialchars($escuela['servicio']) ?>" required>

        <label>
            <input type="checkbox" name="edificio_compartido" <?= $escuela['edificio_compartido'] ? 'checked' : '' ?>>
            Edificio compartido
        </label>

        <label for="cue">CUE:</label>
        <input type="text" id="cue" name="cue" value="<?= htmlspecialchars($escuela['CUE']) ?>" required>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" value="<?= htmlspecialchars($escuela['direccion']) ?>" required>

        <label for="localidad">Localidad:</label>
        <input type="text" id="localidad" name="localidad" value="<?= htmlspecialchars($escuela['localidad']) ?>" required>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($escuela['telefono']) ?>" required>

        <label for="correo_electronico">Correo electrónico:</label>
        <input type="email" id="correo_electronico" name="correo_electronico" value="<?= htmlspecialchars($escuela['correo_electronico']) ?>" required>

        <label for="directivo">Directivo:</label>
        <input type="text" id="directivo" name="directivo" value="<?= htmlspecialchars($escuela['directivo']) ?>" required>

        <label for="vicedirectora">Vicedirectora:</label>
        <input type="text" id="vicedirectora" name="vicedirectora" value="<?= htmlspecialchars($escuela['vicedirectora']) ?>" required>

        <label for="secretaria">Secretaria:</label>
        <input type="text" id="secretaria" name="secretaria" value="<?= htmlspecialchars($escuela['secretaria']) ?>" required>

        <button type="submit" class="btn btn-editar">Actualizar Escuela</button>
    </form>
</div>

</body>
</html>
