<?php
header('Content-Type: application/json');


// Directorio base de uploads
$baseDir = __DIR__ . '/uploads/';
$baseDirReal = realpath($baseDir);

// Recibe la ruta relativa de la carpeta a renombrar
if (stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false) {
    $input = json_decode(file_get_contents('php://input'), true);
    $folder = $input['oldPath'] ?? '';
    $newName = $input['newName'] ?? '';
} else {
    $folder = $_POST['oldPath'] ?? '';
    $newName = $_POST['newNameInput'] ?? '';
}
$folder = trim($folder, '/');
$newName = trim($newName);


// LOG de depuración
error_log('--- RENAMING FOLDER ---');
error_log('folder (input): ' . $folder);
error_log('newName (input): ' . $newName);

if ($folder === '' || $newName === '') {
    error_log('Datos incompletos');
    echo json_encode(['error' => 'Datos incompletos.']);
    exit;
}



$fullPath = $baseDir . $folder;
$fullPath = preg_replace('/\\+/', '/', $fullPath); // Normaliza slashes
$fullPath = preg_replace('/\/+/', '/', $fullPath); // Normaliza slashes
$fullPath = rtrim($fullPath, '/'); // Elimina slash final
$fullPathReal = realpath($fullPath);
error_log('fullPath (recibida): ' . $fullPath);
error_log('fullPathReal (resuelta): ' . $fullPathReal);
error_log('baseDirReal (esperada): ' . $baseDirReal);

// Validación de seguridad mejorada
if (!$fullPathReal) {
    error_log('Ruta inválida: realpath falló');
    echo json_encode([
        'error' => 'Ruta inválida. No se encontró la carpeta.',
        'debug' => [
            'fullPath' => $fullPath,
            'fullPathReal' => $fullPathReal,
            'baseDirReal' => $baseDirReal
        ]
    ]);
    exit;
}
if (strpos($fullPathReal, $baseDirReal) !== 0) {
    error_log('Ruta fuera de uploads: ' . $fullPathReal);
    echo json_encode([
        'error' => 'Ruta fuera de uploads.',
        'debug' => [
            'fullPath' => $fullPath,
            'fullPathReal' => $fullPathReal,
            'baseDirReal' => $baseDirReal
        ]
    ]);
    exit;
}
if (!is_dir($fullPathReal)) {
    error_log('No es carpeta: ' . $fullPathReal);
    echo json_encode([
        'error' => 'La ruta no es una carpeta.',
        'debug' => [
            'fullPath' => $fullPath,
            'fullPathReal' => $fullPathReal,
            'baseDirReal' => $baseDirReal
        ]
    ]);
    exit;
}

// Validar nombre nuevo
if (preg_match('/[\\\/]/', $newName)) {
    error_log('Nombre inválido');
    echo json_encode(['error' => 'El nombre no puede contener "/" ni "\\".']);
    exit;
}

$newFullPath = dirname($fullPathReal) . DIRECTORY_SEPARATOR . $newName;
error_log('newFullPath: ' . $newFullPath);

if (file_exists($newFullPath)) {
    error_log('Ya existe una carpeta con ese nombre');
    echo json_encode(['error' => 'Ya existe una carpeta con ese nombre.']);
    exit;
}

if (rename($fullPathReal, $newFullPath)) {
    error_log('Renombrado OK');
    echo json_encode(['success' => true]);
    exit;
}

// Si el renombrado falló, verifica si la carpeta ya no existe en la ruta original y sí existe en la nueva
if (!is_dir($fullPathReal) && is_dir($newFullPath)) {
    error_log('Renombrado físico detectado aunque rename falló');
    echo json_encode(['success' => true]);
    exit;
}

error_log('No se pudo renombrar la carpeta');
echo json_encode(['error' => 'No se pudo renombrar la carpeta.']);
