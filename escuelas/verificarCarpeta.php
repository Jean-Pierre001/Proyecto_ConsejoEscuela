<?php
$cue = isset($_GET['cue']) ? $_GET['cue'] : '';
$directorioBase = 'folders';

$respuesta = ['existe' => false];
$ruta = $directorioBase . $cue;
/*if ($cue) {
    $ruta = $directorioBase . $cue;
    if (is_dir($ruta)) {
        $respuesta['existe'] = true;
    }
}*/

if (!is_dir("$directorioBase/$cue")) {
    $respuesta['existe'] = true;
    }

header('Content-Type: application/json');
echo json_encode($respuesta);