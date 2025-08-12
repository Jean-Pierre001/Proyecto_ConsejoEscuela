<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'includes/session.php';
include 'includes/conn.php';

// Recibir ID, primero POST, luego GET
$id = 0;
if (isset($_POST['id'])) {
    header('Location: schools.php');
    $id = intval($_POST['id']);
} elseif (isset($_GET['id'])) {
    header('Location: schools.php');
    $id = intval($_GET['id']);
} else {
    echo "No se recibió ID por POST ni GET.<br>";
    echo '<a href="schools.php">Volver a listado</a>';
    exit;
}

if ($id <= 0) {
    echo "ID inválido o no especificado.<br>";
    echo '<a href="schools.php">Volver a listado</a>';
    exit;
}

try {
    // Consultar nombre escuela y nombre categoría con JOIN
    $stmt = $pdo->prepare("
        SELECT s.schoolName, c.name AS categoryName 
        FROM schools s 
        JOIN categories c ON s.category_id = c.id 
        WHERE s.id = ?");
    if (!$stmt->execute([$id])) {
        $errorInfo = $stmt->errorInfo();
        echo "Error en consulta SELECT: " . $errorInfo[2];
        exit;
    }

    $school = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$school) {
        echo "No se encontró la escuela con id $id.<br>";
        echo '<a href="schools.php">Volver a listado</a>';
        exit;
    }

    $schoolName = $school['schoolName'];
    $categoryName = $school['categoryName'];
    echo "Escuela encontrada: $schoolName<br>";
    echo "Categoría: $categoryName<br>";

    // Eliminar la escuela de la base de datos
    $stmtDel = $pdo->prepare("DELETE FROM schools WHERE id = ?");
    if (!$stmtDel->execute([$id])) {
        $errorInfo = $stmtDel->errorInfo();
        echo "Error al eliminar la escuela: " . $errorInfo[2];
        exit;
    }
    echo "Escuela eliminada correctamente.<br>";

    // Construir ruta carpeta escuela dentro de su categoría (sin saneo)
    $baseDir = __DIR__ . '/uploads/';
    $folderPath = $baseDir . $categoryName . DIRECTORY_SEPARATOR . $schoolName;

    if (is_dir($folderPath)) {
        echo "Eliminando carpeta: $folderPath<br>";
        deleteDirectory($folderPath);
    } else {
        echo "No existe carpeta: $folderPath<br>";
    }

    echo '<a href="schools.php">Volver a listado</a>';

    // Redirigir después de 3 segundos para que se vean los mensajes
    header("refresh:3;url=schools.php");
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
            if (!unlink($path)) {
                echo "No se pudo eliminar archivo: $path<br>";
            }
        }
    }
    if (!rmdir($dir)) {
        echo "No se pudo eliminar carpeta: $dir<br>";
    } else {
        echo "Carpeta eliminada: $dir<br>";
    }
}
?>
