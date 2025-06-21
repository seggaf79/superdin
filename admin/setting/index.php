<?php
require_once '../../config/init.php';

// Ambil data setting (karena cuma 1 baris, id = 1)
$stmt = $pdo->prepare("SELECT * FROM setting WHERE id = 1 LIMIT 1");
$stmt->execute();
$setting = $stmt->fetch(PDO::FETCH_ASSOC);

// Proses simpan/update
if (is_post()) {
    $nama_kantor = $_POST['nama_kantor'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $website = $_POST['website'];

    if ($setting) {
        // Update
        $stmt = $pdo->prepare("UPDATE setting SET nama_kantor=?, alamat=?, telepon=?, email=?, website=? WHERE id = 1");
        $stmt->execute([$nama_kantor, $alamat, $telepon, $email, $website]);
        set_Flash('success', 'Data berhasil diperbarui.');
    } else {
        // Insert awal
        $stmt = $pdo->prepare("INSERT INTO setting (id, nama_kantor, alamat, telepon, email, website) VALUES (1, ?, ?, ?, ?, ?)");
        $stmt->execute([$nama_kantor, $alamat, $telepon, $email, $website]);
        set_Flash('success', 'Data berhasil disimpan.');
    }

    redirect('index.php');
}
?>

<?php include '../partials/header.php'; ?>
<div class="flex">
<?php include '../partials/sidebar.php'; ?>
<div class="flex flex-col min-h-screen w-full">

<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Pengaturan Aplikasi</h1>
    <?= showFlash('success') ?>

    <form method="POST" class="space-y-4 bg-white p-4 rounded shadow max-w-xl">
        <div>
            <label>Nama Kantor</label>
            <input type="text" name="nama_kantor" value="<?= e($setting['nama_kantor'] ?? '') ?>" class="w-full border px-2 py-1 rounded" required>
        </div>
        <div>
            <label>Alamat</label>
            <textarea name="alamat" class="w-full border px-2 py-1 rounded" required><?= e($setting['alamat'] ?? '') ?></textarea>
        </div>
        <div>
            <label>Nomor Telepon</label>
            <input type="text" name="telepon" value="<?= e($setting['telepon'] ?? '') ?>" class="w-full border px-2 py-1 rounded">
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" value="<?= e($setting['email'] ?? '') ?>" class="w-full border px-2 py-1 rounded">
        </div>
        <div>
            <label>Website</label>
            <input type="text" name="website" value="<?= e($setting['website'] ?? '') ?>" class="w-full border px-2 py-1 rounded">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>

<?php include '../partials/footer.php'; ?>
</div>
</div>