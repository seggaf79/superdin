<?php
require_once '../../config/init.php';
require_login();

// Ambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data rekening dari database
$stmt = $pdo->prepare("SELECT * FROM rekening WHERE id = ?");
$stmt->execute([$id]);
$rekening = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika data tidak ditemukan
if (!$rekening) {
    set_Flash('error', 'Data rekening tidak ditemukan.');
    redirect('index.php');
}
?>

<?php include '../partials/header.php'; ?>
<div class="flex">
<?php include '../partials/sidebar.php'; ?>
<div class="flex flex-col min-h-screen w-full">

<div class="p-4 max-w-xl">
    <h1 class="text-2xl font-bold mb-4">Detail Rekening</h1>

    <?= showFlash('error') ?>

    <div class="bg-white shadow rounded p-4 space-y-3">
        <div><strong>Bidang:</strong><br> <?= e($rekening['bidang']) ?></div>
        <div><strong>Nomor Kode Rekening:</strong><br> <?= e($rekening['kode_rekening']) ?></div>
    </div>

    <div class="mt-4">
        <a href="index.php" class="bg-gray-600 text-white px-4 py-2 rounded inline-block">← Kembali</a>
        <a href="edit.php?id=<?= $rekening['id'] ?>" class="bg-green-600 text-white px-4 py-2 rounded inline-block ml-2">Edit</a>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
</div>
</div>