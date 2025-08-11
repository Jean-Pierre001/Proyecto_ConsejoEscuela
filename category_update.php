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
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');

if ($id <= 0 || $name === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Datos inválidos']);
    exit;
}

try {
    // Verificar si la categoría existe
    $stmt = $pdo->prepare("SELECT id FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    if (!$stmt->fetch()) {
        http_response_code(404);
        echo json_encode(['error' => 'Categoría no encontrada']);
        exit;
    }

    // Actualizar categoría
    $stmt = $pdo->prepare("UPDATE categories SET name = ?, description = ? WHERE id = ?");
    $stmt->execute([$name, $description, $id]);

    echo json_encode(['success' => true, 'message' => 'Categoría actualizada']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en base de datos: ' . $e->getMessage()]);
}
