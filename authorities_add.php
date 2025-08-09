<?php
include 'includes/session.php';
include 'includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $role = trim($_POST['role'] ?? '');
    $school_id = intval($_POST['school_id'] ?? 0);

    if (!$name || !$role || !$school_id) {
        $_SESSION['error'] = "Complete todos los campos obligatorios.";
        header('Location: schools.php');
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO authorities (name, role, school_id) VALUES (:name, :role, :school_id)");
    $stmt->execute([
        ':name' => $name,
        ':role' => $role,
        ':school_id' => $school_id
    ]);

    $_SESSION['success'] = "Autoridad agregada correctamente.";
    header('Location: schools.php');
    exit;
}

header('Location: schools.php');
exit;
