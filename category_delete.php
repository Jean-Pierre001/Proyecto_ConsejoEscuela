<?php
include 'includes/session.php';
include 'includes/conn.php';

header('Content-Type: application/json');

// ID de la categoría de reasignación por defecto
$defaultCategoryId = 7;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

$id = intval($_POST['id'] ?? 0);
if ($id <= 0 || $id == $defaultCategoryId) {
    http_response_code(400);
    echo json_encode(['error' => 'ID inválido o protegido']);
    exit;
}

try {
    // Obtener nombre de la categoría a eliminar
    $stmt = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    $catToDelete = $stmt->fetchColumn();

    if (!$catToDelete) {
        http_response_code(404);
        echo json_encode(['error' => 'Categoría no encontrada']);
        exit;
    }

    // Obtener nombre de la categoría de reasignación
    $stmt = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
    $stmt->execute([$defaultCategoryId]);
    $catDefault = $stmt->fetchColumn();

    if (!$catDefault) {
        http_response_code(500);
        echo json_encode(['error' => 'Categoría de reasignación no encontrada']);
        exit;
    }

    // Rutas de carpetas
    $baseDir = __DIR__ . '/uploads/';
    $sourceDir = $baseDir . $catToDelete;
    $targetDir = $baseDir . $catDefault;

    // Si existen carpetas, moverlas
    if (is_dir($sourceDir)) {
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $items = scandir($sourceDir);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;

            $srcPath = $sourceDir . '/' . $item;
            $destPath = $targetDir . '/' . $item;

            // Evitar sobreescritura
            if (file_exists($destPath)) {
                $destPath .= '_moved_' . time();
            }

            rename($srcPath, $destPath);
        }

        // Eliminar carpeta de categoría antigua
        rmdir($sourceDir);
    }

    // Reasignar escuelas
    $stmt = $pdo->prepare("UPDATE schools SET category_id = ? WHERE category_id = ?");
    $stmt->execute([$defaultCategoryId, $id]);

    // Eliminar categoría
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode([
        'success' => true,
        'message' => "Categoría eliminada, escuelas reasignadas a la categoría {$defaultCategoryId} y carpetas movidas"
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en base de datos: ' . $e->getMessage()]);
}
