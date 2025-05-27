<?php
include '../baseDatos/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos actuales
    $sql = "SELECT * FROM inspectores WHERE idInspector = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $inspector = $stmt->fetch();

    if (!$inspector) {
        header("Location: inspectores.php");
        exit();
    }
} else {
    header("Location: inspectores.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $nivelModalidad = $_POST['nivelModalidad'];
    $telefono = $_POST['telefono'] ?: null; // Convertir a NULL si está vacío
    $correo = $_POST['correo'] ?: null;

    $sql_update = "UPDATE inspectores SET 
        nombre = :nombre,
        nivelModalidad = :nivelModalidad,
        telefono = :telefono,
        correo = :correo
        WHERE idInspector = :id";

    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute([
        'nombre' => $nombre,
        'nivelModalidad' => $nivelModalidad,
        'telefono' => $telefono,
        'correo' => $correo,
        'id' => $id
    ]);

    header("Location: inspectores.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Inspector</title>
    <link rel="stylesheet" href="estilos/editarInspectores.css"> <!-- Asegúrate de tener este archivo -->
</head>
<body>
<nav id="mainNavbar" class="navbar navbar-expand-lg sticky-top">

<div class="container">
    <header>
        <h1>Editar Inspector</h1>
    </header>

    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($inspector['nombre']) ?>" required>

        <label for="nivelModalidad">Nivel / Modalidad:</label>
        <input type="text" id="nivelModalidad" name="nivelModalidad" value="<?= htmlspecialchars($inspector['nivelModalidad']) ?>" required>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($inspector['telefono']) ?>">

        <label for="correo">Correo electrónico:</label>
        <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($inspector['correo']) ?>">

        <button type="submit" class="btn btn-editar">Actualizar Inspector</button>
    </form>
</div>

</body>
</html>
