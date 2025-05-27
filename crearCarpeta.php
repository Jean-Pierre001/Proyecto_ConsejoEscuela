<?php

require_once 'baseDatos/conexion.php';

// Recibir datos
$cue = isset($_GET['CUE']) ? $_GET['CUE'] : '';
$nombre = isset($_GET['nombreEscuela']) ? $_GET['nombreEscuela'] : '';
$localidad = isset($_GET['localidad']) ? $_GET['localidad'] : '';

// Validación mínima
if (empty($cue) || empty($nombre) || empty($localidad)) {
    die("Faltan datos obligatorios.");
}

// Ruta de la carpeta
$carpeta = "folders/$nombre";

// Crear carpeta si no existe
if (!is_dir($carpeta)) {
    if (!mkdir($carpeta, 0777, true)) {
        die("No se pudo crear la carpeta.");
    }
}

// Asociar en base de datos
try {
    // Verificar si ya existe ese CUE
    $stmt = $pdo->prepare("SELECT id FROM carpetas WHERE cue = ?");
    $stmt->execute([$cue]);
    $escuela = $stmt->fetch();

    if ($escuela) {
        // Ya existe: actualizar la carpeta y el nombre
        $stmt = $pdo->prepare("UPDATE carpetas SET nombre = ?, carpeta = ?, localidad = ? WHERE cue = ?");
        $stmt->execute([$nombre, $carpeta, $localidad, $cue]);
    } else {
        // No existe: insertar nuevo registro
        $stmt = $pdo->prepare("INSERT INTO carpetas (cue, nombre, carpeta, localidad) VALUES (?, ?, ?, ?)");
        $stmt->execute([$cue, $nombre, $carpeta, $localidad]);
    }

    header("Location: folders.php?mensaje=Carpeta+creada+y+asociada+correctamente");
    exit;
} catch (PDOException $e) {
    die("Error al guardar en la base de datos: " . $e->getMessage());
}

?>