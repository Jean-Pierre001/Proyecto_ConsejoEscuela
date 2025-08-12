<?php
include '../includes/session.php';
include '../includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? 'user';
    $password = $_POST['password'] ?? '';

    if (!$id || !$username || !$email) {
        $_SESSION['error'] = "Completa los campos obligatorios.";
        header('Location: ../users.php');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Email inválido.";
        header('Location: ../users.php');
        exit;
    }

    try {
        // Verificar si username o email ya existen en otro usuario
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE (username = ? OR email = ?) AND id != ?");
        $stmt->execute([$username, $email, $id]);
        if ($stmt->fetchColumn() > 0) {
            $_SESSION['error'] = "El usuario o email ya están en uso.";
            header('Location: ../users.php');
            exit;
        }

        if ($password) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, role = ?, password = ? WHERE id = ?");
            $stmt->execute([$username, $email, $role, $passwordHash, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
            $stmt->execute([$username, $email, $role, $id]);
        }

        $_SESSION['success'] = "Usuario actualizado correctamente.";
        header('Location: ../users.php');
        exit;

    } catch (Exception $e) {
        $_SESSION['error'] = "Error al actualizar usuario: " . $e->getMessage();
        header('Location: ../users.php');
        exit;
    }

} else {
    header('Location: ../users.php');
    exit;
}
