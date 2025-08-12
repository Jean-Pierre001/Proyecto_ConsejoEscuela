<?php
include '../includes/session.php';
include '../includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);

    if (!$id) {
        $_SESSION['error'] = "ID inválido.";
        header('Location: ../users.php');
        exit;
    }

    // Asumiendo que el ID del usuario logueado está en $_SESSION['user_id']
    if (isset($_SESSION['user_id']) && $id === (int)$_SESSION['user_id']) {
        $_SESSION['error'] = "No puedes eliminar el usuario con sesión activa.";
        header('Location: ../users.php');
        exit;
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);

        $_SESSION['success'] = "Usuario eliminado correctamente.";
        header('Location: ../users.php');
        exit;

    } catch (Exception $e) {
        $_SESSION['error'] = "Error al eliminar usuario: " . $e->getMessage();
        header('Location: ../users.php');
        exit;
    }
} else {
    header('Location: ../users.php');
    exit;
}
