<?php
// Evitar mostrar errores visibles que rompan JSON (útil en producción)
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');

$baseDir = __DIR__ . '/uploads/';

// Obtener datos JSON
$data = json_decode(file_get_contents('php://input'), true);
$oldPath = trim($data['old_path'] ?? '', '/');
$newName = trim($data['new_name'] ?? '');

if ($oldPath === '' || $newName === '') {
    echo json_encode(['error' => 'Datos insuficientes.']);
    exit;
}

// Validar nombre nuevo: no permitir ".." ni barras invertidas o normales
if (strpos($newName, '..') !== false || preg_match('/[\\\\\\/]/', $newName)) {
    echo json_encode(['error' => 'Nombre de carpeta no válido.']);
    exit;
}

$oldFullPath = realpath($baseDir . $oldPath);
$baseDirReal = realpath($baseDir);

if ($oldFullPath === false || strpos($oldFullPath, $baseDirReal) !== 0 || !is_dir($oldFullPath)) {
    echo json_encode(['error' => 'Carpeta original no válida.']);
    exit;
}

// Construir nuevo path
$parentDir = dirname($oldFullPath);
$newFullPath = $parentDir . DIRECTORY_SEPARATOR . $newName;

if (file_exists($newFullPath)) {
    echo json_encode(['error' => 'Ya existe una carpeta con ese nombre.']);
    exit;
}

if (rename($oldFullPath, $newFullPath)) {
    echo json_encode(['success' => true]);
    exit;
} else {
    echo json_encode(['error' => 'No se pudo renombrar la carpeta.']);
    exit;
}
