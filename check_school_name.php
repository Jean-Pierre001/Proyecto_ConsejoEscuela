<?php
require 'includes/conn.php'; // conexión PDO

$name = trim($_GET['schoolName'] ?? '');

$stmt = $pdo->prepare("SELECT COUNT(*) FROM schools WHERE schoolName = ?");
$stmt->execute([$name]);
$exists = $stmt->fetchColumn() > 0;

header('Content-Type: application/json; charset=utf-8');
echo json_encode(['exists' => $exists]);
