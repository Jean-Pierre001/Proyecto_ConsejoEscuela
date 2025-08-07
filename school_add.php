<?php
include 'includes/session.php';
include 'includes/conn.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: schools.php');
    exit;
}

$schoolName = trim($_POST['schoolName'] ?? '');
$cue = trim($_POST['cue'] ?? '');
$shift = trim($_POST['shift'] ?? '');
$address = trim($_POST['address'] ?? '');
$city = trim($_POST['city'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$principal = trim($_POST['principal'] ?? '');
$vicePrincipal = trim($_POST['vicePrincipal'] ?? '');
$secretary = trim($_POST['secretary'] ?? '');
$service = trim($_POST['service'] ?? '');
$sharedBuilding = trim($_POST['sharedBuilding'] ?? '');
$email = trim($_POST['email'] ?? '');

if ($schoolName === '') {
    header('Location: schools.php');
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO schools (schoolName, cue, shift, address, city, phone, principal, vicePrincipal, secretary, service, sharedBuilding, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$schoolName, $cue, $shift, $address, $city, $phone, $principal, $vicePrincipal, $secretary, $service, $sharedBuilding, $email]);
} catch (Exception $e) {
    // Puedes loguear el error si lo deseas
}
header('Location: schools.php');
exit;
