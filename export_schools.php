<?php
require 'vendor/autoload.php';
include 'includes/conn.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Style\Color;

if (!isset($_POST['ids']) || empty($_POST['ids'])) {
    die("No seleccionaste escuelas.");
}

$ids = $_POST['ids'];
$placeholders = implode(',', array_fill(0, count($ids), '?'));

// Consultar escuelas junto con la categoría (join)
$sql = "SELECT s.*, c.name as category_name 
        FROM schools s
        JOIN categories c ON s.category_id = c.id
        WHERE s.id IN ($placeholders)
        ORDER BY c.name ASC, s.service_code ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($ids);
$schools = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$schools) {
    die("No se encontraron escuelas para exportar.");
}

// Función para formatear texto de autoridades con RichText
function formatAuthorityRichText($auth) {
    $richText = new RichText();

    if (!empty($auth['name'])) {
        $name = $richText->createTextRun($auth['name']);
        $name->getFont()->setBold(true)->setSize(11)->setColor(new Color('FF1F497D')); // azul oscuro
        $richText->createText("\n");
    }

    if (!empty($auth['personal_phone'])) {
        $phone = $richText->createTextRun("Tel: " . $auth['personal_phone']);
        $phone->getFont()->setItalic(true)->setSize(10)->setColor(new Color('FF7F7F7F')); // gris
        $richText->createText("\n");
    }

    if (!empty($auth['personal_email'])) {
        $email = $richText->createTextRun("Email: " . $auth['personal_email']);
        $email->getFont()->setItalic(true)->setSize(10)->setColor(new Color('FF7F7F7F')); // gris
    }

    return $richText;
}

// Estilo para encabezados
$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => '1F497D'],
        'size' => 12,
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'D9E1F2'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => '7F7F7F'],
        ],
    ],
];

// Estilo para datos
$dataStyle = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => 'CCCCCC'],
        ],
    ],
    'alignment' => [
        'vertical' => Alignment::VERTICAL_TOP,
        'horizontal' => Alignment::HORIZONTAL_LEFT,
        'wrapText' => true,
    ],
    'font' => [
        'size' => 11,
    ],
];

// Estilo especial para celdas de autoridades
$styleAuthority = [
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'E8F0FE'],  // azul muy claro
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => 'B0C4DE'],
        ],
    ],
    'alignment' => [
        'vertical' => Alignment::VERTICAL_TOP,
        'horizontal' => Alignment::HORIZONTAL_LEFT,
        'wrapText' => true,
    ],
];

// Estilo para fila de categoría
$styleCategory = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF'],
        'size' => 14,
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '4F81BD'], // azul intenso
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_LEFT,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
];

// Definir encabezados
$headers = [
    'ID', 'Nombre', 'Turno', 'Edificio Compartido', 'CUE', 'Dirección', 'Localidad',
    'Teléfono', 'Email', 'Director/a', 'Vicedirector/a', 'Secretario/a'
];
$columns = range('A', 'L');

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$row = 1;
$currentCategory = null;

foreach ($schools as $school) {
    if ($currentCategory !== $school['category_name']) {
        // Nueva categoría, imprimir título de categoría
        $currentCategory = $school['category_name'];
        $sheet->mergeCells("A{$row}:L{$row}");
        $sheet->setCellValue("A{$row}", $currentCategory);
        $sheet->getStyle("A{$row}")->applyFromArray($styleCategory);
        $row++;

        // Escribir encabezados después del título categoría
        foreach ($headers as $i => $header) {
            $cell = $columns[$i] . $row;
            $sheet->setCellValue($cell, $header);
        }
        $sheet->getStyle("A{$row}:L{$row}")->applyFromArray($headerStyle);
        $row++;
    }

    // Obtener autoridades
    $stmtAuth = $pdo->prepare("SELECT role, name, personal_phone, personal_email FROM authorities WHERE school_id = ?");
    $stmtAuth->execute([$school['id']]);
    $authorities = $stmtAuth->fetchAll(PDO::FETCH_ASSOC);

    $director = $viceDirector = $secretary = null;

    foreach ($authorities as $auth) {
        $role = strtolower($auth['role']);
        if (strpos($role, 'director') !== false && $director === null) {
            $director = formatAuthorityRichText($auth);
        } elseif ((strpos($role, 'vicedirector') !== false || strpos($role, 'vicedirector/a') !== false) && $viceDirector === null) {
            $viceDirector = formatAuthorityRichText($auth);
        } elseif (strpos($role, 'secretario') !== false && $secretary === null) {
            $secretary = formatAuthorityRichText($auth);
        }
    }

    // Rellenar datos escuela
    $sheet->setCellValue('A' . $row, $school['id']);
    $sheet->setCellValue('B' . $row, $school['service_code']);
    $sheet->setCellValue('C' . $row, $school['shift']);
    $sheet->setCellValue('D' . $row, $school['shared_building']);
    $sheet->setCellValue('E' . $row, $school['cue_code']);
    $sheet->setCellValue('F' . $row, $school['address']);
    $sheet->setCellValue('G' . $row, $school['locality']);
    $sheet->setCellValue('H' . $row, $school['phone']);
    $sheet->setCellValue('I' . $row, $school['email']);

    if ($director !== null) {
        $sheet->getCell('J' . $row)->setValue($director);
        $sheet->getStyle('J' . $row)->applyFromArray($styleAuthority);
    }
    if ($viceDirector !== null) {
        $sheet->getCell('K' . $row)->setValue($viceDirector);
        $sheet->getStyle('K' . $row)->applyFromArray($styleAuthority);
    }
    if ($secretary !== null) {
        $sheet->getCell('L' . $row)->setValue($secretary);
        $sheet->getStyle('L' . $row)->applyFromArray($styleAuthority);
    }

    // Aplicar estilo general a fila de datos (menos autoridades que ya lo tienen)
    $sheet->getStyle("A{$row}:I{$row}")->applyFromArray($dataStyle);

    $row++;
}

// Autoajustar columnas
foreach ($columns as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Descargar archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="escuelas_por_categoria.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
