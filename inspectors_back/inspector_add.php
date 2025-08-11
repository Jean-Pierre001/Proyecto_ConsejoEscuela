<?php
// inspectors_back/inspector_add.php
include '../includes/session.php';
include '../includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar datos
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $levelModality = trim(filter_input(INPUT_POST, 'levelModality', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));

    if (!$name || !$levelModality) {
        $_SESSION['error'] = 'El nombre y la modalidad/nivel son obligatorios.';
        header('Location: ../inspectors.php');
        exit;
    }

    try {
        $sql = "INSERT INTO inspectors (name, levelModality, phone, email) 
                VALUES (:name, :levelModality, :phone, :email)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':levelModality' => $levelModality,
            ':phone' => $phone ?: null,
            ':email' => $email ?: null
        ]);

        $_SESSION['success'] = 'Inspector agregado correctamente.';
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error al agregar el inspector: ' . $e->getMessage();
    }

    header('Location: ../inspectors.php');
    exit;
} else {
    $_SESSION['error'] = 'Método de solicitud no válido.';
    header('Location: ../inspectors.php');
    exit;
}
