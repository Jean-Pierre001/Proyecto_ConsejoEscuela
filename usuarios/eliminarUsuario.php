<?php
include '../baseDatos/conexion.php';

if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];

    // Consulta para eliminar el socio
    $sql = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_usuario' => $id_usuario]);
    
    // Redirigir a la página principal después de eliminar
    header("Location: usuarios.php");
    exit();
} else {
    // Redirigir si no se pasa el id_usuario del socio
    header("Location: usuarios.php");
    exit();
}
?>
