<?php
require_once '../../config/init.php';
require_login();

// Ambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data dari database
$stmt = $pdo->prepare("SELECT * FROM pegawai WHERE id = ?");
$stmt->execute([$id]);
$pegawai = $stmt->fetch(PDO::FETCH_ASSOC);



// Jika tidak ditemukan
if (!$pegawai) {
    set_Flash('error', 'Data pegawai tidak ditemukan.');
    redirect('index.php');
}

// Proses update saat form disubmit
if (is_post()) {
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $jabatan = $_POST['jabatan'];
    $pangkat = $_POST['pangkat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $status_asn = $_POST['status_asn'];

    $stmt = $pdo->prepare("UPDATE pegawai SET nama = ?, nip = ?, jabatan = ?, pangkat_golongan = ?, jenis_kelamin = ?, status_asn = ? WHERE id = ?");
    $stmt->execute([$nama, $nip, $jabatan, $pangkat, $jenis_kelamin, $status_asn, $id]);

    set_Flash('success', 'Data pegawai berhasil diperbarui.');
    redirect('index.php');
}
?>

<?php include '../partials/header.php'; ?>
<div class="flex">
  <?php include '../partials/sidebar.php'; ?>

  <div class="flex flex-col min-h-screen w-full">

<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Data Pegawai</h1>

    <?= showFlash('error') ?>
    <?= showFlash('success') ?>

    <form method="POST" class="space-y-4 bg-white p-4 rounded shadow max-w-xl">
        <div>
            <label>Nama Pegawai</label>
            <input type="text" name="nama" value="<?= e($pegawai['nama']) ?>" class="w-full border px-2 py-1 rounded" required>
        </div>
        <div>
            <label>NIP</label>
            <input type="text" name="nip" value="<?= e($pegawai['nip']) ?>" class="w-full border px-2 py-1 rounded" required>
        </div>
        <div>
            <label>Jabatan</label>
            <input type="text" name="jabatan" value="<?= e($pegawai['jabatan']) ?>" class="w-full border px-2 py-1 rounded" required>
        </div>
        <div>
            <label>Pangkat Golongan</label>
            <input type="text" name="pangkat" value="<?= e($pegawai['pangkat_golongan']) ?>" class="w-full border px-2 py-1 rounded" required>
        </div>
        <div>
            <label for="jenis_kelamin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            <label for="status_asn" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status ASN</label>
                <select name="status_asn" id="status_asn" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="PNS">PNS</option>
                    <option value="PPPK">PPPK</option>
		    <option value="Honorer">Honorer</option>
                </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Perbarui</button>
    </form>
</div>

<?php include '../partials/footer.php'; ?>
  </div>
</div>