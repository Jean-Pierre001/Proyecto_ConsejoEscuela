<?php
include 'includes/session.php';
include 'includes/conn.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

$id = intval($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');

if ($id <= 0 || $name === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Datos inválidos']);
    exit;
}

// Función para sanear nombres igual que en las carpetas
function sanitizeFolderName($name) {
    $name = trim($name);
    $name = preg_replace('/[\/\\\\:*?"<>|]/', '_', $name);
    $name = preg_replace('/[\s_]+/', '_', $name);
    return $name;
}

try {
    // Obtener el nombre actual de la categoría antes de actualizar
    $stmt = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$category) {
        http_response_code(404);
        echo json_encode(['error' => 'Categoría no encontrada']);
        exit;
    }

    $oldName = sanitizeFolderName($category['name']);
    $newNameSanitized = sanitizeFolderName($name);

    // Actualizar categoría en la base de datos
    $stmt = $pdo->prepare("UPDATE categories SET name = ?, description = ? WHERE id = ?");
    $stmt->execute([$name, $description, $id]);

    // Ruta base de uploads
    $baseDir = __DIR__ . '/uploads/';
    $baseDirReal = realpath($baseDir);

    $oldPath = $baseDir . $oldName;
    $newPath = $baseDir . $newNameSanitized;

    // Si la carpeta con el nombre viejo existe y es un directorio
    if (is_dir($oldPath)) {
        // Verificar que no exista ya una carpeta con el nuevo nombre
        if (!file_exists($newPath)) {
            if (!rename($oldPath, $newPath)) {
                echo json_encode(['error' => 'Categoría actualizada, pero no se pudo renombrar la carpeta.']);
                exit;
            }
        } else {
            echo json_encode(['error' => 'Categoría actualizada, pero ya existe una carpeta con el nuevo nombre.']);
            exit;
        }
    }

    echo json_encode(['success' => true, 'message' => 'Categoría y carpeta actualizadas correctamente.']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en base de datos: ' . $e->getMessage()]);
}
