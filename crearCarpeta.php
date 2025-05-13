<?php

// Crear carpeta
$foldersEscuela = $_GET['CUE'];

// Verificar si la carpeta ya existe
if (!is_dir("folders/$foldersEscuela")) {
    if (mkdir("folders/$foldersEscuela", 0777, true)) {
        header("Location: folders.php?mensaje=La+carpeta+ya+existe");
        exit;
    } else {
        die("No se pudo crear la carpeta.");
    }
} else {
    header("Location: folders.php?mensaje=La+carpeta+ya+existe");
    exit;
}