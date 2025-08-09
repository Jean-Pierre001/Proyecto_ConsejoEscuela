<?php
include 'includes/session.php';
include 'includes/conn.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: schools.php');
    exit;
}

try {
    // 1. Obtener el nombre de la escuela antes de borrarla
    $stmt = $pdo->prepare("SELECT name FROM schools WHERE id=?");
    $stmt->execute([$id]);
    $school = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($school) {
        $schoolName = $school['name'];

        // 2. Borrar escuela de la base de datos
        $stmt = $pdo->prepare("DELETE FROM schools WHERE id=?");
        $stmt->execute([$id]);

        // 3. Llamar a delete_folder.php para borrar carpeta
        $folderPath = trim($schoolName, '/'); // nombre igual al de la carpeta en uploads/

        $url = __DIR__ . '/delete_folder.php'; // ruta absoluta al script

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['path' => $folderPath]));
        $response = curl_exec($ch);
        curl_close($ch);

        // Podés loguear $response si querés verificar
    }

} catch (Exception $e) {
    // Registrar error si querés
}

header('Location: schools.php');
exit;
