<?php
include 'includes/session.php';
include 'includes/conn.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: schools.php');
    exit;
}

try {
    // 1. Obtener el nombre de la escuela antes de eliminarla
    $stmt = $pdo->prepare("SELECT schoolName FROM schools WHERE id=?");
    $stmt->execute([$id]);
    $school = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($school) {
        $schoolschoolName = $school['schoolName'];

        // 2. Eliminar la escuela de la base de datos
        $stmt = $pdo->prepare("DELETE FROM schools WHERE id=?");
        $stmt->execute([$id]);

        // 3. Construir la ruta de la carpeta
        $baseDir = __DIR__ . '/uploads/';
        $folderPath = $baseDir . $schoolschoolName;

        // 4. Eliminar carpeta si existe
        if (is_dir($folderPath)) {
            deleteDirectory($folderPath);
        }
    }
} catch (Exception $e) {
    // Puedes registrar el error si quieres
}

// Función recursiva para borrar una carpeta y todo su contenido
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

header('Location: schools.php');
exit;
