<?php
require '../../vendor/autoload.php';
require '../../config/init.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Ambil parameter dari URL
$bidang = $_GET['bidang'] ?? '';
$bulan = $_GET['bulan'] ?? '';
$tahun = $_GET['tahun'] ?? '';
$pegawai = $_GET['pegawai'] ?? '';

$query = "SELECT sppd.*, pegawai.nama, pegawai.jabatan, rekening.bidang 
    FROM sppd 
    JOIN pegawai ON sppd.pegawai_id = pegawai.id 
    JOIN rekening ON sppd.rekening_id = rekening.id 
    WHERE 1=1";

$params = [];

if (!empty($bidang)) {
    $query .= " AND rekening.bidang = ?";
    $params[] = $bidang;
}

if (!empty($bulan)) {
    $query .= " AND MONTH(sppd.tgl_berangkat) = ?";
    $params[] = $bulan;
}

if (!empty($tahun)) {
    $query .= " AND YEAR(sppd.tgl_berangkat) = ?";
    $params[] = $tahun;
}

if (!empty($pegawai)) {
    $query .= " AND sppd.pegawai_id = ?";
    $params[] = $pegawai;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$data = $stmt->fetchAll();

$spreadsheet = new Spreadsheet();
$spreadsheet->getProperties()->setCreator('DKIP Bulungan')->setTitle('Laporan SPPD');

$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Laporan SPPD');

// Judul Header
$setting = $pdo->query("SELECT * FROM setting LIMIT 1")->fetch();
$judul = "LAPORAN PERJALANAN DINAS\nINSTANSI " . strtoupper($setting['nama_kantor']) . "\nBULAN " . ($bulan ? date('F', mktime(0, 0, 0, $bulan, 10)) : 'SEMUA') . " TAHUN " . ($tahun ?: 'SEMUA');
$sheet->mergeCells('A1:I1');
$sheet->mergeCells('A2:I2');
$sheet->mergeCells('A3:I3');
$sheet->setCellValue('A1', 'LAPORAN PERJALANAN DINAS');
$sheet->setCellValue('A2', 'INSTANSI ' . strtoupper($setting['nama_kantor']));
$sheet->setCellValue('A3', 'BULAN ' . ($bulan ? date('F', mktime(0, 0, 0, $bulan, 10)) : 'SEMUA') . ' TAHUN ' . ($tahun ?: 'SEMUA'));

// Header Tabel
$sheet->fromArray(
    ['No', 'Nama', 'Bidang', 'Tujuan', 'Maksud', 'Tgl Berangkat', 'Tgl Pulang', 'Lama Hari'],
    NULL,
    'A5'
);

// Isi Tabel
$rowNum = 6;
$no = 1;

foreach ($data as $row) {
    $sheet->setCellValue('A' . $rowNum, $no++);
    $sheet->setCellValue('B' . $rowNum, $row['nama']);
    $sheet->setCellValue('C' . $rowNum, $row['bidang']);
    $sheet->setCellValue('D' . $rowNum, $row['tujuan']);
    $sheet->setCellValue('E' . $rowNum, $row['maksud']);
    $sheet->setCellValue('F' . $rowNum, date('d-m-Y', strtotime($row['tgl_berangkat'])));
    $sheet->setCellValue('G' . $rowNum, date('d-m-Y', strtotime($row['tgl_pulang'])));
    $sheet->setCellValue('H' . $rowNum, $row['lama_hari']);
    $rowNum++;
}

// Set orientasi landscape dan ukuran kertas A4
$sheet->getPageSetup()
    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

// Auto width kolom
foreach (range('A', 'H') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Output ke browser
$filename = 'LAPORAN_SPPD_' . date('dmY') . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
