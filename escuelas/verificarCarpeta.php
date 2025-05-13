<?php
$cue = isset($_GET['cue']) ? $_GET['cue'] : '';
$directorioBase = 'folders/';

$respuesta = ['existe' => false];

if ($cue) {
    $ruta = $directorioBase . $cue;
    if (is_dir($ruta)) {
        $respuesta['existe'] = true;
    }
}

header('Content-Type: application/json');
echo json_encode($respuesta);