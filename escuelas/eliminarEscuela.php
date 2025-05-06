<?php
include '../baseDatos/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para eliminar el socio
    $sql = "DELETE FROM escuelas WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    // Redirigir a la página principal después de eliminar
    header("Location: escuelas.php");
    exit();
} else {
    // Redirigir si no se pasa el id del socio
    header("Location: escuelas.php");
    exit();
}
?>
