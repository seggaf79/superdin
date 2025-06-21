<?php
require '../../vendor/autoload.php';
use Dompdf\Dompdf;

require '../../config/db.php';

// Ambil ID SPPD
$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID tidak ditemukan.");
}

// Ambil data dari database
$query = $pdo->prepare("
    SELECT sppd.*, 
           pegawai.nama AS pegawai_nama, pegawai.nip AS pegawai_nip, 
           pegawai.jabatan AS pegawai_jabatan, pegawai.pangkat_golongan, 
           pejabat.nama AS pejabat_nama, pejabat.nip AS pejabat_nip, pejabat.jabatan AS pejabat_jabatan, 
           rekening.kode_rekening, 
           setting.nama_kantor, setting.alamat, setting.email, setting.website
    FROM sppd
    LEFT JOIN pegawai ON sppd.pegawai_id = pegawai.id
    LEFT JOIN pejabat ON sppd.pejabat_id = pejabat.id
    LEFT JOIN rekening ON sppd.rekening_id = rekening.id
    LEFT JOIN setting ON setting.id = 1
    WHERE sppd.id = :id
");
$query->execute(['id' => $id]);
$sppd = $query->fetch(PDO::FETCH_ASSOC);

if (!$sppd) {
    die("Data tidak ditemukan.");
}

// Ambil isi file HTML template
$template = file_get_contents('template/surat_tugas.html');

// Ganti placeholder dengan data dari DB
$replacements = [
    '{{ $sppd -> no_surat }}' => $sppd['no_surat'],
    '{{ $sppd -> maksud }}' => $sppd['maksud'],
    '{{ $sppd -> tujuan }}' => $sppd['tujuan'],
    '{{ $sppd -> lama_hari }}' => $sppd['lama_hari'],
    '{{ $sppd -> tgl_berangkat }}' => date('d-m-Y', strtotime($sppd['tgl_berangkat'])),
    '{{ $sppd -> tgl_pulang }}' => date('d-m-Y', strtotime($sppd['tgl_pulang'])),
    '{{ $sppd -> tgl_input }}' => date('d-m-Y', strtotime($sppd['tgl_input'])),
    '{{ $sppd -> pegawai_id -> nama }}' => $sppd['pegawai_nama'],
    '{{ $sppd -> pegawai_id -> jabatan }}' => $sppd['pegawai_jabatan'],
    '{{ $sppd -> pegawai_id -> nip }}' => $sppd['pegawai_nip'],
    '{{ $sppd -> pegawai_id -> jabatan_golongan }}' => $sppd['pangkat_golongan'],
    '{{ $sppd -> pejabat_id -> nama }}' => $sppd['pejabat_nama'],
    '{{ $sppd -> pejabat_id -> nip }}' => $sppd['pejabat_nip'],
    '{{ $sppd -> pejabat_id -> jabatan }}' => $sppd['pejabat_jabatan'],
    '{{ $sppd -> rekening_id -> kode_rekening }}' => $sppd['kode_rekening'],
    '{{ $setting -> nama_kantor }}' => $sppd['nama_kantor'],
    '{{ $setting -> alamat }}' => $sppd['alamat'],
    '{{ $setting -> email }}' => $sppd['email'],
    '{{ $setting -> website }}' => $sppd['website'],
];

// Ganti semua placeholder
$html = strtr($template, $replacements);

// Konversi src logo ke base64 agar muncul di PDF
$logoPath = '../../assets/images/logobulungan.png';
$logoData = base64_encode(file_get_contents($logoPath));
$html = str_replace(
    'src="images/logobulungan.png"',
    'src="data:image/png;base64,' . $logoData . '"',
    $html
);

// Generate PDF dengan Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Surat_Tugas_DKIP.pdf", ['Attachment' => false]);
exit;