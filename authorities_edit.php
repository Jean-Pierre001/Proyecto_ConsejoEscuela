<?php
include 'includes/session.php';
include 'includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    if (!$id) {
        $_SESSION['error'] = "ID inválido.";
        header('Location: schools.php');
        exit;
    }

    if (isset($_POST['update'])) {
        $name = trim($_POST['name'] ?? '');
        $role = trim($_POST['role'] ?? '');
        $school_id = intval($_POST['school_id'] ?? 0);
        $personal_phone = trim($_POST['personal_phone'] ?? '');
        $personal_email = trim($_POST['personal_email'] ?? '');

        if (!$name || !$role || !$school_id) {
            $_SESSION['error'] = "Complete todos los campos obligatorios."; 
            header('Location: schools.php');
            exit;
        }

        $stmt = $pdo->prepare("UPDATE authorities SET name = :name, role = :role, school_id = :school_id, personal_phone = :personal_phone, personal_email = :personal_email WHERE id = :id");
        $stmt->execute([
            ':name' => $name,
            ':role' => $role,
            ':school_id' => $school_id,
            ':personal_phone' => $personal_phone,
            ':personal_email' => $personal_email,
            ':id' => $id
        ]);

        $_SESSION['success'] = "Autoridad actualizada correctamente.";
        header('Location: schools.php');
        exit;
    }
}

header('Location: schools.php');
exit;
