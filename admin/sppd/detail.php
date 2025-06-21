<?php
include_once '../../config/init.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("SELECT s.*, 
    p.nama AS nama_pegawai, p.nip AS nip_pegawai, p.jabatan AS jabatan_pegawai, p.pangkat_golongan,
    r.bidang, r.kode_rekening,
    pj.nama AS nama_pejabat, pj.nip AS nip_pejabat, pj.jabatan AS jabatan_pejabat
    FROM sppd s
    JOIN pegawai p ON s.pegawai_id = p.id
    JOIN rekening r ON s.rekening_id = r.id
    JOIN pejabat pj ON s.pejabat_id = pj.id
    WHERE s.id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch();

if (!$data) {
    echo "<p class='text-red-600'>Data tidak ditemukan.</p>";
    exit;
}
?>

<?php include '../partials/header.php'; ?>
<div class="flex">
  <?php include '../partials/sidebar.php'; ?>

  <div class="flex flex-col min-h-screen w-full">
<div class="p-6 max-w-4xl mx-auto bg-white shadow-md rounded-lg mt-6">
    <h1 class="text-2xl font-bold mb-6">Detail Data SPPD</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <div><strong>No. Surat Tugas:</strong> <?= htmlspecialchars($data['no_surat']) ?></div>
        <div><strong>Nama Pegawai:</strong> <?= htmlspecialchars($data['nama_pegawai']) ?></div>
        <div><strong>NIP Pegawai:</strong> <?= htmlspecialchars($data['nip_pegawai']) ?></div>
        <div><strong>Jabatan Pegawai:</strong> <?= htmlspecialchars($data['jabatan_pegawai']) ?></div>
        <div><strong>Pangkat/Golongan:</strong> <?= htmlspecialchars($data['pangkat_golongan']) ?></div>
        <div><strong>Maksud:</strong> <?= nl2br(htmlspecialchars($data['maksud'])) ?></div>
        <div><strong>Transportasi:</strong> <?= htmlspecialchars($data['transportasi']) ?></div>
        <div><strong>Tujuan:</strong> <?= htmlspecialchars($data['tujuan']) ?></div>
        <div><strong>Tanggal Berangkat:</strong> <?= htmlspecialchars($data['tgl_berangkat']) ?></div>
        <div><strong>Tanggal Pulang:</strong> <?= htmlspecialchars($data['tgl_pulang']) ?></div>
        <div><strong>Tanggal Dibuat:</strong> <?= htmlspecialchars($data['tgl_input']) ?></div>
        <div><strong>Bidang:</strong> <?= htmlspecialchars($data['bidang']) ?></div>
        <div><strong>Kode Rekening:</strong> <?= htmlspecialchars($data['kode_rekening']) ?></div>
        <div><strong>Nama Penandatangan:</strong> <?= htmlspecialchars($data['nama_pejabat']) ?></div>
        <div><strong>NIP Penandatangan:</strong> <?= htmlspecialchars($data['nip_pejabat']) ?></div>
        <div><strong>Jabatan Penandatangan:</strong> <?= htmlspecialchars($data['jabatan_pejabat']) ?></div>
        <div><strong>Lama Hari:</strong> <?= htmlspecialchars($data['lama_hari']) ?></div>
    </div>

    <div class="mt-6">
        <a href="index.php" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kembali</a>
    </div>
</div>

<?php include '../partials/footer.php'; ?>

</div>
</div>
