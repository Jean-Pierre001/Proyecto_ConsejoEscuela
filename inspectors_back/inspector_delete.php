<?php
include '../includes/session.php';
include '../includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if (!$id) {
        $_SESSION['error'] = 'ID inválido.';
        header('Location: ../inspectors.php');
        exit;
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM inspectors WHERE id = :id");
        $stmt->execute([':id' => $id]);

        $_SESSION['success'] = 'Inspector eliminado correctamente.';
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error al eliminar el inspector: ' . $e->getMessage();
    }

    header('Location: ../inspectors.php');
    exit;
} else {
    $_SESSION['error'] = 'Método de solicitud no válido.';
    header('Location: ../inspectors.php');
    exit;
}
