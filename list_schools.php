<?php
// Archivo: list_schools.php
// Devuelve la lista de escuelas en formato JSON
header('Content-Type: application/json');

// Simulación de datos (puedes reemplazar por consulta a la base de datos)
$schools = [
    [
        'nombre' => 'Escuela Primaria N°1',
        'cue' => '12345',
        'direccion' => 'Calle Falsa 123',
        'telefono' => '011-1234-5678',
        'director' => 'Juan Pérez',
        'nivel' => 'Primario'
    ],
    [
        'nombre' => 'Escuela Secundaria N°2',
        'cue' => '67890',
        'direccion' => 'Av. Siempreviva 742',
        'telefono' => '011-8765-4321',
        'director' => 'Ana Gómez',
        'nivel' => 'Secundario'
    ]
];

echo json_encode(['success' => true, 'schools' => $schools]);
