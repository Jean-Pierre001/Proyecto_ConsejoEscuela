<?php
include '../includes/session.php';
include '../includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger y validar datos
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? 'user';
    $password = $_POST['password'] ?? '';

    if (!$username || !$email || !$password) {
        $_SESSION['error'] = "Completa todos los campos obligatorios.";
        header('Location: ../users.php');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Email inválido.";
        header('Location: ../users.php');
        exit;
    }

    // Hashear contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Verificar si username o email ya existen
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetchColumn() > 0) {
            $_SESSION['error'] = "El usuario o email ya existen.";
            header('Location: ../users.php');
            exit;
        }

        // Insertar usuario
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$username, $email, $passwordHash, $role]);

        $_SESSION['success'] = "Usuario agregado correctamente.";
        header('Location: ../users.php');
        exit;

    } catch (Exception $e) {
        $_SESSION['error'] = "Error al agregar usuario: " . $e->getMessage();
        header('Location: ../users.php');
        exit;
    }
} else {
    header('Location: ../users.php');
    exit;
}
