<?php
require_once '../../config/init.php';
require_login();

// Ambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data dari DB
$stmt = $pdo->prepare("SELECT * FROM rekening WHERE id = ?");
$stmt->execute([$id]);
$rekening = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika data tidak ditemukan
if (!$rekening) {
    setFlash('error', 'Data rekening tidak ditemukan.');
    redirect('index.php');
}

// Proses update
if (is_post()) {
    $bidang = $_POST['bidang'];
    $kode = $_POST['kode'];

    $stmt = $pdo->prepare("UPDATE rekening SET bidang = ?, kode_rekening = ? WHERE id = ?");
    $stmt->execute([$bidang, $kode, $id]);

    set_Flash('success', 'Data rekening berhasil diperbarui.');
    redirect('index.php');
}
?>

<?php include '../partials/header.php'; ?>
<div class="flex">
<?php include '../partials/sidebar.php'; ?>
<div class="flex flex-col min-h-screen w-full">

<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Data Rekening</h1>

    <?= showFlash('error') ?>
    <?= showFlash('success') ?>

    <form method="POST" class="space-y-4 bg-white p-4 rounded shadow max-w-xl">
        <div>
            <label>Bidang</label>
            <input type="text" name="bidang" value="<?= e($rekening['bidang']) ?>" class="w-full border px-2 py-1 rounded" required>
        </div>
        <div>
            <label>Nomor Kode Rekening</label>
            <input type="text" name="kode" value="<?= e($rekening['kode_rekening']) ?>" class="w-full border px-2 py-1 rounded" required>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Perbarui</button>
    </form>
</div>

<?php include '../partials/footer.php'; ?>
</div>
</div>