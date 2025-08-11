<?php
header('Content-Type: application/json');

include 'includes/session.php';
include 'includes/conn.php';

// Directorio base de uploads
$baseDir = __DIR__ . '/uploads/';
$baseDirReal = realpath($baseDir);

// Recibe la ruta relativa de la carpeta a eliminar
$input = json_decode(file_get_contents('php://input'), true);
$folder = $input['path'] ?? '';
$folder = trim($folder, '/');

$fullPath = $baseDir . $folder;
$fullPathReal = realpath($fullPath);

// Validación de seguridad del path
if (!$fullPathReal || strpos($fullPathReal, $baseDirReal) !== 0 || !is_dir($fullPathReal)) {
    echo json_encode(['error' => 'Ruta de carpeta inválida.']);
    exit;
}

// Función para sanear el nombre de la carpeta igual que en la DB
function sanitizeFolderName($name) {
    $name = trim($name);
    // reemplazar caracteres no válidos por '_'
    $name = preg_replace('/[\/\\\\:*?"<>|]/', '_', $name);
    // reemplazar espacios y guiones bajos consecutivos por uno solo
    $name = preg_replace('/[\s_]+/', '_', $name);
    return $name;
}

// Obtener el nombre de la carpeta base (última parte del path)
$folderName = basename($folder);
$sanitizedFolderName = sanitizeFolderName($folderName);

// Verificar si el nombre corresponde a una escuela
$sqlSchool = "SELECT COUNT(*) FROM schools 
              WHERE REPLACE(REPLACE(REPLACE(schoolName, ' ', '_'), '/', '_'), '\\\\', '_') = :folderName";
$stmt = $pdo->prepare($sqlSchool);
$stmt->execute(['folderName' => $sanitizedFolderName]);
$countSchool = $stmt->fetchColumn();

// Verificar si el nombre corresponde a una categoría
$sqlCategory = "SELECT COUNT(*) FROM categories 
                WHERE REPLACE(REPLACE(REPLACE(name, ' ', '_'), '/', '_'), '\\\\', '_') = :folderName";
$stmt = $pdo->prepare($sqlCategory);
$stmt->execute(['folderName' => $sanitizedFolderName]);
$countCategory = $stmt->fetchColumn();

if ($countSchool > 0 || $countCategory > 0) {
    echo json_encode(['error' => 'No se puede eliminar la carpeta porque corresponde a un registro de escuela o categoría en la base de datos.']);
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
