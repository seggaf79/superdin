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

// Proses update data
if (is_post()) {
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $jabatan = $_POST['jabatan'];
    $pangkat = $_POST['pangkat'];

    $stmt = $pdo->prepare("UPDATE pejabat SET nama = ?, nip = ?, jabatan = ?, pangkat_golongan = ? WHERE id = ?");
    $stmt->execute([$nama, $nip, $jabatan, $pangkat, $id]);

    set_Flash('success', 'Data pejabat berhasil diperbarui.');
    redirect('index.php');
}
?>

<?php include '../partials/header.php'; ?>
<div class="flex">
<?php include '../partials/sidebar.php'; ?>
<div class="flex flex-col min-h-screen w-full">

<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Data Pejabat</h1>

    <?= showFlash('error') ?>
    <?= showFlash('success') ?>

    <form method="POST" class="space-y-4 bg-white p-4 rounded shadow max-w-xl">
        <div>
            <label>Nama Pejabat</label>
            <input type="text" name="nama" value="<?= e($pejabat['nama']) ?>" class="w-full border px-2 py-1 rounded" required>
        </div>
        <div>
            <label>NIP</label>
            <input type="text" name="nip" value="<?= e($pejabat['nip']) ?>" class="w-full border px-2 py-1 rounded" required>
        </div>
        <div>
            <label>Jabatan</label>
            <input type="text" name="jabatan" value="<?= e($pejabat['jabatan']) ?>" class="w-full border px-2 py-1 rounded" required>
        </div>
        <div>
            <label>Pangkat Golongan</label>
            <input type="text" name="pangkat" value="<?= e($pejabat['pangkat_golongan']) ?>" class="w-full border px-2 py-1 rounded" required>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Perbarui</button>
    </form>
</div>

<?php include '../partials/footer.php'; ?>
</div>
</div>