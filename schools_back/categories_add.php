<?php
include '../includes/session.php';
include '../includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if (!$name) {
        $_SESSION['error'] = "El nombre de la categoría no puede estar vacío.";
        header('Location: ../schools.php');
        exit;
    }

    // Verificar si ya existe
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM categories WHERE name = :name");
    $stmt->execute([':name' => $name]);
    if ($stmt->fetchColumn() > 0) {
        $_SESSION['error'] = "La categoría ya existe.";
        header('Location: ../schools.php');
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
    $stmt->execute([':name' => $name]);

    $_SESSION['success'] = "Categoría agregada correctamente.";
    header('Location: ../schools.php');
    exit;
}

header('Location: ../schools.php');
exit;
