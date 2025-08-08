<?php
header('Content-Type: application/json');

if (!isset($_POST['path'], $_POST['new_name'])) {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
    exit;
}

$path = $_POST['path'];
$newName = basename($_POST['new_name']); // Sanitizar nombre
$dir = dirname($path);
$newPath = $dir . DIRECTORY_SEPARATOR . $newName;

if (file_exists($path)) {
    if (rename($path, $newPath)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se pudo renombrar']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Archivo no encontrado']);
}
