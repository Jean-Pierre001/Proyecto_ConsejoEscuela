<?php
// create_folder_and_redirect.php

include 'includes/session.php';
include 'includes/conn.php';

if (!isset($_GET['id'])) {
    header('Location: schools.php');
    exit;
}

$id = intval($_GET['id']);

$stmt = $pdo->prepare("SELECT schoolName FROM schools WHERE id = ?");
$stmt->execute([$id]);
$school = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$school) {
    header('Location: schools.php');
    exit;
}

$schoolName = $school['schoolName'];


$folderName = $schoolName;

$basePath = __DIR__ . '/uploads/';

if (!is_dir($basePath)) {
    mkdir($basePath, 0755, true);
}

$fullPath = $basePath . $folderName;

if (file_exists($fullPath)) {
    header('Location: schools.php?id=' . $id . '&error=folder_exists');
    exit;
} else {
    mkdir($fullPath, 0755, true);
    header('Location: schools.php?id=' . $id . '&created_folder=' . urlencode($folderName));
    exit;
}
