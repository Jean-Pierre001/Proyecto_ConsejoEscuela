<?php
include '../includes/session.php';
include '../includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $levelModality = trim(filter_input(INPUT_POST, 'levelModality', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));

    if (!$id || !$name || !$levelModality) {
        $_SESSION['error'] = 'Datos inválidos. El nombre y la modalidad/nivel son obligatorios.';
        header('Location: ../inspectors.php');
        exit;
    }

    try {
        $sql = "UPDATE inspectors 
                SET name = :name, levelModality = :levelModality, phone = :phone, email = :email
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':levelModality' => $levelModality,
            ':phone' => $phone ?: null,
            ':email' => $email ?: null
        ]);

        $_SESSION['success'] = 'Inspector actualizado correctamente.';
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error al actualizar el inspector: ' . $e->getMessage();
    }

    header('Location: ../inspectors.php');
    exit;
} else {
    $_SESSION['error'] = 'Método de solicitud no válido.';
    header('Location: ../inspectors.php');
    exit;
}
