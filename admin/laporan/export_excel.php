<?php
require '../../vendor/autoload.php';
require '../../config/init.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

// Ambil parameter filter
$bulan = ($_GET['bulan'] ?? '') !== '' ? (int)$_GET['bulan'] : (int)date('n');
$tahun = ($_GET['tahun'] ?? '') !== '' ? (int)$_GET['tahun'] : (int)date('Y');

// Pastikan bulan berada dalam rentang 1–12
if ($bulan < 1 || $bulan > 12) {
    $bulan = (int)date('n');
}

// Ambil setting nama kantor
$stmtSetting = $conn->query("SELECT * FROM setting LIMIT 1");
$setting = $stmtSetting->fetch(PDO::FETCH_ASSOC);
$nama_kantor = $setting['nama_kantor'] ?? '';

// Ambil data sppd
$sql = "SELECT s.*, p.nama AS nama_pegawai, r.bidang 
        FROM sppd s 
        LEFT JOIN pegawai p ON s.pegawai_id = p.id 
        LEFT JOIN rekening r ON s.rekening_id = r.id 
        WHERE MONTH(s.tgl_berangkat) = :bulan AND YEAR(s.tgl_berangkat) = :tahun 
        ORDER BY s.tgl_berangkat ASC";
$stmt = $conn->prepare($sql);
$stmt->execute(['bulan' => $bulan, 'tahun' => $tahun]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Format nama bulan Indonesia
$bulanNama = date('F', mktime(0, 0, 0, $bulan, 10));
$bulanNama = str_replace(
    ['January','February','March','April','May','June','July','August','September','October','November','December'],
    ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
    $bulanNama
);

// Buat spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set orientasi landscape dan ukuran A4
$sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
$sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);

// Header
$sheet->mergeCells('A1:H1');
$sheet->setCellValue('A1', 'LAPORAN PERJALANAN DINAS');
$sheet->mergeCells('A2:H2');
$sheet->setCellValue('A2', 'INSTANSI ' . strtoupper($nama_kantor));
$sheet->mergeCells('A3:H3');
$sheet->setCellValue('A3', 'BULAN ' . strtoupper($bulanNama) . ' TAHUN ' . $tahun);

// Spasi
$sheet->setCellValue('A5', 'No');
$sheet->setCellValue('B5', 'Nama');
$sheet->setCellValue('C5', 'Bidang');
$sheet->setCellValue('D5', 'Tujuan');
$sheet->setCellValue('E5', 'Maksud');
$sheet->setCellValue('F5', 'Tgl. Berangkat');
$sheet->setCellValue('G5', 'Tgl. Pulang');
$sheet->setCellValue('H5', 'Lama Hari');

// Isi data
$row = 6;
$no = 1;
foreach ($data as $d) {
    $sheet->setCellValue("A$row", $no++);
    $sheet->setCellValue("B$row", $d['nama_pegawai']);
    $sheet->setCellValue("C$row", $d['bidang']);
    $sheet->setCellValue("D$row", $d['tujuan']);
    $sheet->setCellValue("E$row", $d['maksud']);
    $sheet->setCellValue("F$row", date('d-m-Y', strtotime($d['tgl_berangkat'])));
    $sheet->setCellValue("G$row", date('d-m-Y', strtotime($d['tgl_pulang'])));
    $sheet->setCellValue("H$row", $d['lama_hari'] . ' hari');
    $row++;
}

// Format otomatis kolom
foreach (range('A', 'H') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Download
$filename = 'LAPORAN_SPPD_' . date('dmY') . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;