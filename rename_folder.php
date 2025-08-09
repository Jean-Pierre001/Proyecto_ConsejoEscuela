<?php
// Evitar mostrar errores visibles que rompan JSON (útil en producción)
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');

include 'includes/session.php';
include 'includes/conn.php';

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

// Función para sanear igual que carpeta
function sanitizeFolderName($name) {
    $name = trim($name);
    $name = preg_replace('/[\/\\\\:*?"<>|]/', '_', $name);
    $name = preg_replace('/[\s_]+/', '_', $name);
    return $name;
}

$sanitizedNewName = sanitizeFolderName($newName);

// EXTRA: obtener el nombre original de la carpeta (sin path)
// Por ejemplo si $oldPath es "folder1/subfolder", sacamos solo "subfolder"
$oldFolderName = basename($oldPath);
$sanitizedOldName = sanitizeFolderName($oldFolderName);

// Verificar si el nombre original corresponde a una escuela en DB
$sql = "SELECT COUNT(*) FROM schools WHERE
        REPLACE(REPLACE(REPLACE(schoolName, ' ', '_'), '/', '_'), '\\\\', '_') = :oldName";
$stmt = $pdo->prepare($sql);
$stmt->execute(['oldName' => $sanitizedOldName]);
$countOldName = $stmt->fetchColumn();

if ($countOldName > 0) {
    // La carpeta original corresponde a una escuela => no se puede renombrar
    echo json_encode(['error' => 'No se puede modificar el nombre de esta carpeta porque corresponde a una escuela registrada.']);
    exit;
}

// Continuar con validación y renombrado normal

$oldFullPath = realpath($baseDir . $oldPath);
$baseDirReal = realpath($baseDir);

if ($oldFullPath === false || strpos($oldFullPath, $baseDirReal) !== 0 || !is_dir($oldFullPath)) {
    echo json_encode(['error' => 'Carpeta original no válida.']);
    exit;
}

// Construir nuevo path
$parentDir = dirname($oldFullPath);
$newFullPath = $parentDir . DIRECTORY_SEPARATOR . $sanitizedNewName;

if (file_exists($newFullPath)) {
    echo json_encode(['error' => 'Ya existe una carpeta con ese nombre en el sistema de archivos.']);
    exit;
}

if (rename($oldFullPath, $newFullPath)) {
    echo json_encode(['success' => true]);
    exit;
} else {
    echo json_encode(['error' => 'No se pudo renombrar la carpeta.']);
    exit;
}
