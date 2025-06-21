<?php
require_once '../../config/init.php'; // pastikan path ke init.php benar

// Validasi ID
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Ambil data SPPD
$stmt = $conn->prepare("SELECT * FROM sppd WHERE id = ?");
$stmt->execute([$id]);
$sppd = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$sppd) {
    die("Data SPPD tidak ditemukan.");
}

// Ambil data pegawai
$pegawai = $conn->query("SELECT * FROM pegawai WHERE id = {$sppd['pegawai_id']}")->fetch(PDO::FETCH_ASSOC);

// Ambil data rekening
$rekening = $conn->query("SELECT * FROM rekening WHERE id = {$sppd['rekening_id']}")->fetch(PDO::FETCH_ASSOC);

// Ambil data setting
$setting = $conn->query("SELECT * FROM setting LIMIT 1")->fetch(PDO::FETCH_ASSOC);



// Hitung lama hari
if (empty($sppd['lama_hari'])) {
    $start = new DateTime($sppd['tgl_berangkat']);
    $end = new DateTime($sppd['tgl_pulang']);
    $sppd['lama_hari'] = $start->diff($end)->days + 1;
}

// Load template HTML
$template = file_get_contents('template_pdf_sppd.html');

// Replace semua variabel template
$replacements = [
    '{{ $setting -> nama_kantor }}' => $setting['nama_kantor'],
    '{{ $setting -> alamat }}' => $setting['alamat'],
    '{{ $setting -> email }}' => $setting['email'],
    '{{ $setting -> website }}' => $setting['website'],
    '{{ $sppd->no_surat}}' => $sppd['no_surat'],
    '{{ $sppd -> maksud }}' => $sppd['maksud'],
    '{{ $sppd -> transportasi }}' => $sppd['transportasi'],
    '{{ $sppd -> tujuan }}' => $sppd['tujuan'],
    '{{ $sppd -> lama_hari }}' => $sppd['lama_hari'],
    '{{ $sppd -> tgl_berangkat }}' => formatTanggal($sppd['tgl_berangkat']),
    '{{ $sppd -> tgl_pulang }}' => formatTanggal($sppd['tgl_pulang']),
    '{{ $sppd -> tgl_input }}' => formatTanggal($sppd['tgl_input']),
    '{{ $rekening_id -> kode_rekening }}' => $rekening['kode_rekening'],
    '{{ $sppd -> pegawai_id -> nama }}' => $pegawai['nama'],
    '{{ $sppd -> pegawai_id -> nip }}' => $pegawai['nip'],
    '{{ $sppd -> pegawai_id -> jabatan }}' => $pegawai['jabatan'],
    '{{ $sppd -> pegawai_id -> jabatan_golongan }}' => $pegawai['pangkat_golongan'],
];

foreach ($replacements as $placeholder => $value) {
    $template = str_replace($placeholder, $value, $template);
}

// Tampilkan hasil
echo $template;
?>
