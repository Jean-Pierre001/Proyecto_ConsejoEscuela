<?php
include 'includes/session.php';
include 'includes/conn.php';


$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: schools.php');
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM schools WHERE id=?");
    $stmt->execute([$id]);
} catch (Exception $e) {
    // Puedes loguear el error si lo deseas
}
header('Location: schools.php');
exit;
