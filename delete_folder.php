<?php
header('Content-Type: application/json');

// Directorio base de uploads
$baseDir = __DIR__ . '/uploads/';
$baseDirReal = realpath($baseDir);

// Recibe la ruta relativa de la carpeta a eliminar
$input = json_decode(file_get_contents('php://input'), true);
$folder = $input['path'] ?? '';
$folder = trim($folder, '/');

$fullPath = $baseDir . $folder;
$fullPathReal = realpath($fullPath);

// Validación de seguridad
if (!$fullPathReal || strpos($fullPathReal, $baseDirReal) !== 0 || !is_dir($fullPathReal)) {
    echo json_encode(['error' => 'Ruta de carpeta inválida.']);
    exit;
}

// Función recursiva para eliminar carpeta y su contenido
function deleteDir($dir) {
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        if (is_dir($path)) {
            if (!deleteDir($path)) return false;
        } else {
            if (!unlink($path)) return false;
        }
    }
    return rmdir($dir);
}

// Verifica si la carpeta tiene contenido
$hasContent = false;
$items = scandir($fullPathReal);
foreach ($items as $item) {
    if ($item !== '.' && $item !== '..') {
        $hasContent = true;
        break;
    }
}

// Elimina la carpeta
if (deleteDir($fullPathReal)) {
    $msg = 'Carpeta eliminada correctamente.';
    if ($hasContent) {
        $msg .= ' Se eliminó todo el contenido de la carpeta.';
    }
    echo json_encode(['success' => true, 'message' => $msg]);
} else {
    echo json_encode(['error' => 'No se pudo eliminar la carpeta.']);
}
