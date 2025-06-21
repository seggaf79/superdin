<?php
require_once '../../config/init.php';
require_login();

// Proses simpan
if (is_post()) {
    $bidang = $_POST['bidang'];
    $kode = $_POST['kode'];

    // Simpan ke DB
    $stmt = $pdo->prepare("INSERT INTO rekening (bidang, kode_rekening) VALUES (?, ?)");
    $stmt->execute([$bidang, $kode]);

    set_Flash('success', 'Data rekening berhasil ditambahkan.');
    redirect('index.php');
}
?>

<?php include '../partials/header.php'; ?>
<div class="flex">
<?php include '../partials/sidebar.php'; ?>
<div class="flex flex-col min-h-screen w-full">

<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Tambah Data Rekening</h1>

    <?= showFlash('success') ?>

    <form method="POST" class="space-y-4 bg-white p-4 rounded shadow max-w-xl">
        <div>
            <label>Bidang</label>
            <input type="text" name="bidang" class="w-full border px-2 py-1 rounded" required>
        </div>
        <div>
            <label>Nomor Kode Rekening</label>
            <input type="text" name="kode" class="w-full border px-2 py-1 rounded" required>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>

<?php include '../partials/footer.php'; ?>
</div>
</div>