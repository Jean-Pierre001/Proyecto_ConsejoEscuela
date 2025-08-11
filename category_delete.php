<?php
include 'includes/session.php'; // si usas sesión
include 'includes/conn.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

$id = intval($_POST['id'] ?? 0);
if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'ID inválido']);
    exit;
}

try {
    // Opcional: verificar que la categoría existe antes de borrar
    $stmt = $pdo->prepare("SELECT id FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    if (!$stmt->fetch()) {
        http_response_code(404);
        echo json_encode(['error' => 'Categoría no encontrada']);
        exit;
    }

    // Borrar categoría
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(['success' => true, 'message' => 'Categoría eliminada']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en base de datos: ' . $e->getMessage()]);
}
