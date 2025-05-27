<?php
include '../baseDatos/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para eliminar el socio
    $sql = "DELETE FROM inspectores WHERE idInspector = :idInspector";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['idInspector' => $id]);

    // Redirigir a la página principal después de eliminar
    header("Location: inspectores.php");
    exit();
} else {
    // Redirigir si no se pasa el idInspector del socio
    header("Location: inspectores.php");
    exit();
}
?>
