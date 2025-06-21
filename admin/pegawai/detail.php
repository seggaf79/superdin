<?php
include_once '../../config/init.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM pegawai WHERE id = ?");
$stmt->execute([$id]);
$pegawai = $stmt->fetch();

if (!$pegawai) {
    echo "<div class='text-center text-red-600 mt-10'>Data tidak ditemukan.</div>";
    exit;
}
?>

<?php include '../partials/header.php'; ?>
<div class="flex">
  <?php include '../partials/sidebar.php'; ?>
<div class="flex flex-col min-h-screen w-full">

<div class="p-4 max-w-xl">
    <h1 class="text-2xl font-bold mb-4">Detail Pegawai</h1>

    <?= showFlash('error') ?>

    <div class="bg-white shadow rounded p-4 space-y-3">
        <div><strong>Nama Pegawai:</strong><br> <?= e($pegawai['nama']) ?></div>
        <div><strong>NIP:</strong><br> <?= e($pegawai['nip']) ?></div>
        <div><strong>Jabatan:</strong><br> <?= e($pegawai['jabatan']) ?></div>
        <div><strong>Pangkat Golongan:</strong><br> <?= e($pegawai['pangkat_golongan']) ?></div>
    </div>

    <div class="mt-4">
        <a href="index.php" class="bg-gray-600 text-white px-4 py-2 rounded inline-block">← Kembali</a>
        <a href="edit.php?id=<?= $pegawai['id'] ?>" class="bg-green-600 text-white px-4 py-2 rounded inline-block ml-2">Edit</a>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
  </div>
</div>