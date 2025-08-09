<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'includes/session.php';
include 'includes/conn.php';

// Recibir ID, probá primero con POST, si no con GET (para debug)
$id = 0;
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    echo "ID recibido por POST: $id<br>";
} elseif (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    echo "ID recibido por GET: $id<br>";
} else {
    echo "No se recibió ID por POST ni GET.<br>";
}

if ($id <= 0) {
    echo "ID inválido o no especificado.<br>";
    echo '<a href="schools.php">Volver a listado</a>';
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT schoolName FROM schools WHERE id = ?");
    if (!$stmt->execute([$id])) {
        $errorInfo = $stmt->errorInfo();
        echo "Error en consulta SELECT: " . $errorInfo[2];
        exit;
    }

    $school = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$school) {
        echo "No se encontró la escuela con id $id.<br>";
        exit;
    }

    $schoolName = $school['schoolName'];
    echo "Escuela encontrada: $schoolName<br>";

    $stmtDel = $pdo->prepare("DELETE FROM schools WHERE id = ?");
    if (!$stmtDel->execute([$id])) {
        $errorInfo = $stmtDel->errorInfo();
        echo "Error al eliminar la escuela: " . $errorInfo[2];
        exit;
    }
    echo "Escuela eliminada correctamente.<br>";

    // Eliminar carpeta asociada
    $safeFolderName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $schoolName);
    $baseDir = __DIR__ . '/uploads/';
    $folderPath = $baseDir . $safeFolderName;

    if (is_dir($folderPath)) {
        echo "Eliminando carpeta: $folderPath<br>";
        deleteDirectory($folderPath);
    } else {
        echo "No existe carpeta: $folderPath<br>";
    }

    echo '<a href="schools.php">Volver a listado</a>';
    exit;

} catch (Exception $e) {
    echo "Error inesperado: " . $e->getMessage();
    exit;
}

function deleteDirectory($dir) {
    if (!is_dir($dir)) return;
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        if (is_dir($path)) {
            deleteDirectory($path);
        } else {
            unlink($path);
        }
    }
    rmdir($dir);
}
?>
