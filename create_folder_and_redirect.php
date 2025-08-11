<?php
// create_folder_and_redirect.php

include 'includes/session.php';
include 'includes/conn.php';

if (!isset($_GET['id'])) {
    header('Location: schools.php');
    exit;
}

$id = intval($_GET['id']);

// Obtener nombre de la escuela y de la categoría
$stmt = $pdo->prepare("
    SELECT s.schoolName, c.name AS categoryName
    FROM schools s
    JOIN categories c ON s.category_id = c.id
    WHERE s.id = ?
");
$stmt->execute([$id]);
$school = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$school) {
    header('Location: schools.php');
    exit;
}

$schoolName   = $school['schoolName'];
$categoryName = $school['categoryName'];

// Base uploads
$basePath = __DIR__ . '/uploads/';

// Ruta final: uploads/Categoria/Escuela
$categoryPath = $basePath . $categoryName;
$fullPath     = $categoryPath . '/' . $schoolName;

// Crear carpeta de la categoría si no existe
if (!is_dir($categoryPath)) {
    mkdir($categoryPath, 0755, true);
}

// Verificar si ya existe carpeta de la escuela
if (file_exists($fullPath)) {
    header('Location: schools.php?id=' . $id . '&error=folder_exists');
    exit;
} else {
    mkdir($fullPath, 0755, true);
    header('Location: schools.php?id=' . $id . '&created_folder=' . urlencode($schoolName));
    exit;
}
