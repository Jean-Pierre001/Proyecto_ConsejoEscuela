<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'includes/session.php';
include 'includes/conn.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: schools.php');
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT schoolName FROM schools WHERE id = ?");
    $stmt->execute([$id]);
    $school = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$school) {
        throw new Exception("No se encontró la escuela con id $id");
    }

    $schoolName = $school['schoolName'];

    // Eliminar la escuela (las autoridades deben eliminarse por ON DELETE CASCADE)
    $stmtDel = $pdo->prepare("DELETE FROM schools WHERE id = ?");
    if (!$stmtDel->execute([$id])) {
        $errorInfo = $stmtDel->errorInfo();
        throw new Exception("Error al eliminar la escuela: " . $errorInfo[2]);
    }

    // Carpeta (sanitizar nombre para evitar problemas)
    $safeFolderName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $schoolName);
    $baseDir = __DIR__ . '/uploads/';
    $folderPath = $baseDir . $safeFolderName;

    if (is_dir($folderPath)) {
        deleteDirectory($folderPath);
    }

    header('Location: schools.php');
    exit;

} catch (Exception $e) {
    echo "Error inesperado: " . $e->getMessage();
    exit;
}

function deleteDirectory($dir) {
    if (!is_dir($dir)) return;
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        if (is_dir($path)) {
            deleteDirectory($path);
        } else {
            unlink($path);
        }
    }
    rmdir($dir);
}
