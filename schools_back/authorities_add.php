<?php
include '../includes/session.php';
include '../includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $role = trim($_POST['role'] ?? '');
    $school_id = intval($_POST['school_id'] ?? 0);
    $personal_phone = trim($_POST['personal_phone'] ?? '');
    $personal_email = trim($_POST['personal_email'] ?? '');

    if (!$name || !$role || !$school_id) {
        $_SESSION['error'] = "Complete todos los campos obligatorios.";
        header('Location: ../schools.php');
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO authorities (name, role, school_id, personal_phone, personal_email) VALUES (:name, :role, :school_id, :personal_phone, :personal_email)");
    $stmt->execute([
        ':name' => $name,
        ':role' => $role,
        ':school_id' => $school_id,
        ':personal_phone' => $personal_phone,
        ':personal_email' => $personal_email
    ]);

    $_SESSION['success'] = "Autoridad agregada correctamente.";
    header('Location: ../schools.php');
    exit;
}

header('Location: ../schools.php');
exit;
