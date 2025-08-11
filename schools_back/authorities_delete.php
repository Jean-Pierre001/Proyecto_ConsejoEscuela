<?php
include '../includes/session.php';
include '../includes/conn.php';

// Recibimos el id por POST (más seguro para eliminar)
$id = intval($_POST['id'] ?? 0);
if ($id <= 0) {
    $_SESSION['error'] = "ID inválido para eliminar autoridad.";
    header('Location: ../schools.php');
    exit;
}

try {
    // Verificar que exista la autoridad
    $stmt = $pdo->prepare("SELECT name FROM authorities WHERE id = ?");
    $stmt->execute([$id]);
    $authority = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$authority) {
        $_SESSION['error'] = "No se encontró la autoridad con id $id.";
        header('Location: ../schools.php');
        exit;
    }

    // Intentar eliminar autoridad
    $stmtDel = $pdo->prepare("DELETE FROM authorities WHERE id = ?");
    if (!$stmtDel->execute([$id])) {
        $errorInfo = $stmtDel->errorInfo();
        $_SESSION['error'] = "Error al eliminar la autoridad: " . $errorInfo[2];
        header('Location: ../schools.php');
        exit;
    }

    $_SESSION['success'] = "Autoridad '" . htmlspecialchars($authority['name']) . "' eliminada correctamente.";
    header('Location: ../schools.php');
    exit;

} catch (Exception $e) {
    $_SESSION['error'] = "Error inesperado: " . $e->getMessage();
    header('Location: ../schools.php');
    exit;
}
