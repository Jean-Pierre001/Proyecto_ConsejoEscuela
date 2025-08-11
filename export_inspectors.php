<?php
require 'vendor/autoload.php';
include 'includes/conn.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;

if (!isset($_POST['ids']) || empty($_POST['ids'])) {
    die("No seleccionaste inspectores.");
}

$ids = $_POST['ids'];
$placeholders = implode(',', array_fill(0, count($ids), '?'));

$sql = "SELECT id, name, levelModality, phone, email 
        FROM inspectors 
        WHERE id IN ($placeholders)";
$stmt = $pdo->prepare($sql);
$stmt->execute($ids);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$data) {
    die("No se encontraron inspectores para exportar.");
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Encabezados
$headers = ['ID', 'Nombre', 'Modalidad/Nivel', 'Teléfono', 'Email'];
$columnLetters = ['A', 'B', 'C', 'D', 'E'];

// Estilos (copiados y adaptados del export escuelas)
$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => '1F497D'], // Azul oscuro
        'size' => 12,
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'D9E1F2'], // Gris azulado claro
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

$dataStyle = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => 'CCCCCC'],
        ],
    ],
    'alignment' => [
        'vertical' => Alignment::VERTICAL_CENTER,
        'horizontal' => Alignment::HORIZONTAL_LEFT,
    ],
    'font' => [
        'size' => 11,
    ],
];

// Poner encabezados con estilo
foreach ($headers as $i => $header) {
    $cell = $columnLetters[$i] . '1';
    $sheet->setCellValue($cell, $header);
}
$sheet->getStyle('A1:E1')->applyFromArray($headerStyle);

// Poner datos
$row = 2;
foreach ($data as $inspector) {
    $sheet->setCellValue('A' . $row, $inspector['id']);
    $sheet->setCellValue('B' . $row, $inspector['name']);
    $sheet->setCellValue('C' . $row, $inspector['levelModality']);
    $sheet->setCellValue('D' . $row, $inspector['phone']);
    $sheet->setCellValue('E' . $row, $inspector['email']);
    $row++;
}

$sheet->getStyle("A2:E" . ($row - 1))->applyFromArray($dataStyle);

// Autoajustar ancho de columnas
foreach ($columnLetters as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Descargar archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="inspectores.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
