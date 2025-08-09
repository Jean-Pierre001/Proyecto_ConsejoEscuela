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

        if (!$name || !$role || !$school_id) {
            $_SESSION['error'] = "Complete todos los campos obligatorios.";
            header('Location: schools.php');
            exit;
        }

        $stmt = $pdo->prepare("UPDATE authorities SET name = :name, role = :role, school_id = :school_id WHERE id = :id");
        $stmt->execute([
            ':name' => $name,
            ':role' => $role,
            ':school_id' => $school_id,
            ':id' => $id
        ]);

        $_SESSION['success'] = "Autoridad actualizada correctamente.";
        header('Location: schools.php');
        exit;
    }

    if (isset($_POST['delete_authority'])) {
        $pdo->prepare("DELETE FROM authorities WHERE id = :id")->execute([':id' => $id]);

        $_SESSION['success'] = "Autoridad eliminada correctamente.";
        header('Location: schools.php');
        exit;
    }
}

header('Location: schools.php');
exit;
