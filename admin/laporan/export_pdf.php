<?php
require '../../vendor/autoload.php';
require '../../config/db.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Ambil filter dari URL
$bulan = isset($_GET['bulan']) ? (int) $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? (int) $_GET['tahun'] : date('Y');

// Ambil data setting kantor
$stmtSetting = $conn->query("SELECT * FROM setting LIMIT 1");
$setting = $stmtSetting->fetch(PDO::FETCH_ASSOC);
$nama_kantor = $setting['nama_kantor'] ?? '';

// Ambil data sppd dengan JOIN ke pegawai dan rekening
$sql = "SELECT s.*, p.nama AS nama_pegawai, r.bidang 
        FROM sppd s 
        LEFT JOIN pegawai p ON s.pegawai_id = p.id 
        LEFT JOIN rekening r ON s.rekening_id = r.id 
        WHERE MONTH(s.tgl_berangkat) = :bulan AND YEAR(s.tgl_berangkat) = :tahun 
        ORDER BY s.tgl_berangkat ASC";

$stmt = $conn->prepare($sql);
$stmt->execute(['bulan' => $bulan, 'tahun' => $tahun]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Format nama bulan
$bulanNama = date('F', mktime(0, 0, 0, $bulan, 10));
$bulanNama = str_replace(
    ['January','February','March','April','May','June','July','August','September','October','November','December'],
    ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
    $bulanNama
);

// Encode gambar kop surat ke base64
$imagePath = '../../assets/images/kopsurat.jpg';
$imageData = @file_get_contents($imagePath);
$imageBase64 = $imageData ? 'data:image/jpeg;base64,' . base64_encode($imageData) : '';

// Bangun HTML untuk PDF
$html = '
<style>
body { font-family: sans-serif; font-size: 12px; }
.clearfix::after { content: ""; display: table; clear: both; }
.kop img { float: left; width: 100px; }
.header { text-align: center; margin-bottom: 20px; }
.table { width: 100%; border-collapse: collapse; margin-top: 20px; }
.table th, .table td {
  border: 1px solid #000; padding: 6px; text-align: center;
}
.table th {
  background-color: orange;
  color: white;
}
</style>

<div class="kop clearfix">
    <img src="' . $imageBase64 . '" alt="Kop Surat">
    <div class="header">
        <h3>LAPORAN PERJALANAN DINAS</h3>
        <p>INSTANSI ' . strtoupper($nama_kantor) . '</p>
        <p>BULAN ' . strtoupper($bulanNama) . ' TAHUN ' . $tahun . '</p>
    </div>
</div>

<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Bidang</th>
            <th>Tujuan</th>
            <th>Maksud</th>
            <th>Tgl. Berangkat</th>
            <th>Tgl. Pulang</th>
            <th>Lama Hari</th>
        </tr>
    </thead>
    <tbody>';

$no = 1;
foreach ($data as $row) {
    $html .= '<tr>
        <td>' . $no++ . '</td>
        <td>' . htmlspecialchars($row['nama_pegawai']) . '</td>
        <td>' . htmlspecialchars($row['bidang']) . '</td>
        <td>' . htmlspecialchars($row['tujuan']) . '</td>
        <td>' . htmlspecialchars($row['maksud']) . '</td>
        <td>' . date('d-m-Y', strtotime($row['tgl_berangkat'])) . '</td>
        <td>' . date('d-m-Y', strtotime($row['tgl_pulang'])) . '</td>
        <td>' . $row['lama_hari'] . ' hari</td>
    </tr>';
}

$html .= '</tbody></table>';

// Generate PDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->setPaper('A4', 'landscape');
$dompdf->loadHtml($html);
$dompdf->render();

// Nama file
$tglFile = date('dmY');
$filename = "LAPORAN_SPPD_{$tglFile}.pdf";

// Output ke browser
$dompdf->stream($filename, ["Attachment" => false]);
exit;