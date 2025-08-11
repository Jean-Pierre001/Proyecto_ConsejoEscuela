<?php
include '../includes/session.php';
include '../includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../schools.php');
    exit;
}

// Sanitizar y obtener datos del POST
$schoolName      = trim($_POST['schoolName'] ?? '');
$order_number    = intval($_POST['order_number'] ?? 0);
$category_id     = intval($_POST['category_id'] ?? 0);
$is_disadvantaged= isset($_POST['is_disadvantaged']) ? (int)$_POST['is_disadvantaged'] : 0;
$shift           = trim($_POST['shift'] ?? '');
$service_code    = trim($_POST['service_code'] ?? '');
$shared_building = trim($_POST['shared_building'] ?? null); // puede ser NULL o texto
$cue_code        = trim($_POST['cue_code'] ?? '');
$address         = trim($_POST['address'] ?? '');
$locality        = trim($_POST['locality'] ?? '');
$phone           = trim($_POST['phone'] ?? null);
$email           = trim($_POST['email'] ?? null);

// Validación básica
if ($schoolName === '' || $shift === '' || $service_code === '' || $cue_code === '' || $address === '' || $locality === '') {
    header('Location: ../schools.php?error=missing_data');
    exit;
}

// Manejar categoría: si no existe, crear "Sin categoría"
if ($category_id <= 0) {
    $stmtCat = $pdo->prepare("SELECT id FROM categories WHERE name = ?");
    $stmtCat->execute(['Sin categoría']);
    $cat = $stmtCat->fetch(PDO::FETCH_ASSOC);

    if ($cat) {
        $category_id = $cat['id'];
    } else {
        $stmtInsCat = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmtInsCat->execute(['Sin categoría']);
        $category_id = $pdo->lastInsertId();
    }
}

try {
    $stmt = $pdo->prepare("INSERT INTO schools 
        (schoolName, order_number, category_id, is_disadvantaged, shift, service_code, shared_building, cue_code, address, locality, phone, email) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->execute([
        $schoolName,
        $order_number,
        $category_id,
        $is_disadvantaged,
        $shift,
        $service_code,
        $shared_building,
        $cue_code,
        $address,
        $locality,
        $phone,
        $email
    ]);
} catch (Exception $e) {
    // Registrar error si quieres
    header('Location: ../schools.php?error=insert_failed');
    exit;
}

header('Location: ../schools.php?created=1');
exit;
