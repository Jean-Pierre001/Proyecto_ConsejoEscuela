<?php
header('Content-Type: application/json');

include 'includes/conn.php';

    $name = trim($_GET['name'] ?? '');

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM schools WHERE schoolName = ?");
    $stmt->execute([$name]);
    $count = $stmt->fetchColumn();

    echo json_encode(["exists" => $count > 0]);
