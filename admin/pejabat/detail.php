<?php
require_once '../../config/init.php';
require_login();

// Ambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data dari database
$stmt = $pdo->prepare("SELECT * FROM pejabat WHERE id = ?");
$stmt->execute([$id]);
$pejabat = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika data tidak ditemukan
if (!$pejabat) {
    setFlash('error', 'Data pejabat tidak ditemukan.');
    redirect('index.php');
}
?>

<?php include '../partials/header.php'; ?>
<div class="flex">
<?php include '../partials/sidebar.php'; ?>
  <div class="flex flex-col min-h-screen w-full">

<div class="p-4 max-w-xl">
    <h1 class="text-2xl font-bold mb-4">Detail Pejabat</h1>

    <?= showFlash('error') ?>

    <div class="bg-white shadow rounded p-4 space-y-3">
        <div><strong>Nama Pejabat:</strong><br> <?= e($pejabat['nama']) ?></div>
        <div><strong>NIP:</strong><br> <?= e($pejabat['nip']) ?></div>
        <div><strong>Jabatan:</strong><br> <?= e($pejabat['jabatan']) ?></div>
        <div><strong>Pangkat Golongan:</strong><br> <?= e($pejabat['pangkat_golongan']) ?></div>
    </div>

    <div class="mt-4">
        <a href="index.php" class="bg-gray-600 text-white px-4 py-2 rounded inline-block">← Kembali</a>
        <a href="edit.php?id=<?= $pejabat['id'] ?>" class="bg-green-600 text-white px-4 py-2 rounded inline-block ml-2">Edit</a>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
</div>
</div>