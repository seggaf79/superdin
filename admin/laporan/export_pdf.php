<?php
require '../../vendor/autoload.php';
require '../../config/init.php';

use Dompdf\Dompdf;

// Ambil parameter filter
$bidang = $_GET['bidang'] ?? '';
$bulan = $_GET['bulan'] ?? '';
$tahun = $_GET['tahun'] ?? '';
$pegawai = $_GET['pegawai'] ?? '';

// Ambil data nama kantor dari tabel setting
$stmt = $pdo->query("SELECT nama_kantor FROM setting LIMIT 1");
$setting = $stmt->fetch();
$nama_kantor = $setting['nama_kantor'] ?? '';

// Query dasar
$query = "
    SELECT sppd.*, pegawai.nama, pegawai.jabatan, rekening.bidang 
    FROM sppd 
    JOIN pegawai ON sppd.pegawai_id = pegawai.id 
    JOIN rekening ON sppd.rekening_id = rekening.id 
    WHERE 1=1
";

// Tambahkan filter jika ada
$params = [];

if (!empty($bidang)) {
    $query .= " AND rekening.bidang = :bidang";
    $params[':bidang'] = $bidang;
}
if (!empty($bulan)) {
    $query .= " AND MONTH(sppd.tgl_berangkat) = :bulan";
    $params[':bulan'] = $bulan;
}
if (!empty($tahun)) {
    $query .= " AND YEAR(sppd.tgl_berangkat) = :tahun";
    $params[':tahun'] = $tahun;
}
if (!empty($pegawai)) {
    $query .= " AND sppd.pegawai_id = :pegawai_id";
    $params[':pegawai_id'] = $pegawai;
}

$query .= " ORDER BY sppd.tgl_berangkat ASC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$data = $stmt->fetchAll();

// Ambil gambar kopsurat sebagai base64
$imagePath = '../../assets/images/kopsurat.jpg';
$imageData = base64_encode(file_get_contents($imagePath));
$src = 'data:image/jpeg;base64,' . $imageData;

// Mulai HTML
$html = '
<style>
    body { font-family: sans-serif; font-size: 12px; }
    .kop { text-align: center; margin-bottom: 20px; }
    .kop img { float: left; width: 600px; }
    .kop h2, .kop h3 { margin: 0; padding: 0; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #f97316; padding: 6px; text-align: left; }
    th { background-color: #fdba74; }
</style>

<div class="kop">
    <img src="' . $src . '">
    <h2>LAPORAN PERJALANAN DINAS</h2>
    <h3>INSTANSI ' . strtoupper($nama_kantor) . '</h3>
    <h4>BULAN ' . ($bulan ? date('F', mktime(0, 0, 0, $bulan, 1)) : '-') . ' TAHUN ' . ($tahun ?: '-') . '</h4>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Bidang</th>
            <th>Tujuan</th>
            <th>Maksud</th>
            <th>Tanggal Berangkat</th>
            <th>Tanggal Pulang</th>
            <th>Lama Hari</th>
        </tr>
    </thead>
    <tbody>';

$no = 1;
foreach ($data as $row) {
    $html .= '<tr>
        <td>' . $no++ . '</td>
        <td>' . htmlspecialchars($row['nama']) . '</td>
        <td>' . htmlspecialchars($row['bidang']) . '</td>
        <td>' . htmlspecialchars($row['tujuan']) . '</td>
        <td>' . htmlspecialchars($row['maksud']) . '</td>
        <td>' . date('d/m/Y', strtotime($row['tgl_berangkat'])) . '</td>
        <td>' . date('d/m/Y', strtotime($row['tgl_pulang'])) . '</td>
        <td>' . $row['lama_hari'] . '</td>
    </tr>';
}

$html .= '</tbody></table>';

// Buat PDF
$dompdf = new Dompdf();
$dompdf->setPaper('A4', 'landscape');
$dompdf->loadHtml($html);
$dompdf->render();

// Nama file
$filename = 'LAPORAN_SPPD_' . date('dmY') . '.pdf';

// Output
$dompdf->stream($filename, ['Attachment' => true]);