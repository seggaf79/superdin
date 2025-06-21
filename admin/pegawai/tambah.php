<?php
require_once '../../config/init.php';
require_login();

if (is_post()) {
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $jabatan = $_POST['jabatan'];
    $pangkat = $_POST['pangkat'];

    $stmt = $pdo->prepare("INSERT INTO pegawai (nama, nip, jabatan, pangkat_golongan) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nama, $nip, $jabatan, $pangkat]);

    set_Flash('success', 'Data pegawai berhasil ditambahkan.');
    redirect('index.php');
}
?>

<?php include '../partials/header.php'; ?>
<div class="flex">
  <?php include '../partials/sidebar.php'; ?>

  <div class="flex flex-col min-h-screen w-full">


<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Tambah Data Pegawai</h1>

    <?= showFlash('success') ?>

    <form method="POST" class="space-y-4 bg-white p-4 rounded shadow max-w-xl">
        <div>
            <label>Nama Pegawai</label>
            <input type="text" name="nama" class="w-full border px-2 py-1 rounded" required>
        </div>
        <div>
            <label>NIP</label>
            <input type="text" name="nip" class="w-full border px-2 py-1 rounded" required>
        </div>
        <div>
            <label>Jabatan</label>
            <input type="text" name="jabatan" class="w-full border px-2 py-1 rounded" required>
        </div>
        <div>
            <label>Pangkat Golongan</label>
            <input type="text" name="pangkat" class="w-full border px-2 py-1 rounded" required>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>

 <?php include '../partials/footer.php'; ?>
  </div>
</div>
