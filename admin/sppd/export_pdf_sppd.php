<?php
require_once '../../vendor/autoload.php';
require_once '../../config/init.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID SPPD tidak ditemukan.");
}

function imageToBase64($path) {
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    return 'data:image/' . $type . ';base64,' . base64_encode($data);
}

$stmt = $pdo->prepare("
    SELECT sppd.*, 
           pegawai.nama AS pegawai_nama, pegawai.nip AS pegawai_nip, pegawai.jabatan AS pegawai_jabatan, pegawai.pangkat_golongan AS pegawai_golongan,
           pejabat.nama AS pejabat_nama, pejabat.nip AS pejabat_nip, pejabat.jabatan AS pejabat_jabatan, pejabat.pangkat_golongan AS pejabat_golongan,
           rekening.kode_rekening,
           setting.nama_kantor, setting.alamat, setting.email, setting.website
    FROM sppd
    JOIN pegawai ON sppd.pegawai_id = pegawai.id
    JOIN pejabat ON sppd.pejabat_id = pejabat.id
    JOIN rekening ON sppd.rekening_id = rekening.id
    JOIN setting ON setting.id = 1
    WHERE sppd.id = :id
");
$stmt->execute(['id' => $id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die("Data SPPD tidak ditemukan.");
}

// Ambil template HTML
$template = file_get_contents('template_pdf_sppd.html'); // rename sppd.html jadi template_pdf_sppd.html dan taruh di folder ini

$logoBase64 = imageToBase64('../../assets/images/logobulungan.png');
$template = str_replace('src="images/logobulungan.png"', 'src="' . $logoBase64 . '"', $template);

// Ganti placeholder dengan data dari DB
$replacements = [
    '{{ $setting -> nama_kantor }}' => $data['nama_kantor'],
    '{{ $setting -> alamat }}' => $data['alamat'],
    '{{ $setting -> email }}' => $data['email'],
    '{{ $setting -> website }}' => $data['website'],
    '{{ $sppd->no_surat}}' => $data['no_surat'],
    '{{ $sppd -> pegawai_id -> nama }}' => $data['pegawai_nama'],
    '{{ $sppd -> pegawai_id -> nip }}' => $data['pegawai_nip'],
    '{{ $sppd -> pegawai_id -> jabatan }}' => $data['pegawai_jabatan'],
    '{{ $sppd -> pegawai_id -> jabatan_golongan }}' => $data['pegawai_golongan'],
    '{{ $sppd -> maksud }}' => $data['maksud'],
    '{{ $sppd -> transportasi }}' => $data['transportasi'],
    '{{ $sppd -> tujuan }}' => $data['tujuan'],
    '{{ $sppd -> lama_hari }}' => $data['lama_hari'],
    '{{ $sppd -> tgl_berangkat }}' => formatTanggalIndo($data['tgl_berangkat']),
    '{{ $sppd->tgl_berangkat }}' => formatTanggalIndo($data['tgl_berangkat']),
    '{{ $sppd -> tgl_pulang }}' => formatTanggalIndo($data['tgl_pulang']),
    '{{ $sppd->tgl_pulang }}' => formatTanggalIndo($data['tgl_pulang']),
    '{{ $sppd -> tgl_input }}' => formatTanggalIndo($data['tgl_input']),
    '{{ $rekening_id -> kode_rekening }}' => $data['kode_rekening']
];

$html = strtr($template, $replacements);

$nama_pegawai = str_replace(' ', '_', $data['pegawai_nama']);
$tanggal_dibuat = date('dmY', strtotime($data['tgl_input']));
$nama_file = "SPPD_{$nama_pegawai}_{$tanggal_dibuat}.pdf";

// Load PDF
$options = new Options();
$options->set('isRemoteEnabled', true); // supaya bisa load logo
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($nama_file, array("Attachment" => true));