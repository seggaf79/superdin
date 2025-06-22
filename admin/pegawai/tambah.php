<?php
require_once '../../config/init.php';
require_login();

if (is_post()) {
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $jabatan = $_POST['jabatan'];
    $pangkat = $_POST['pangkat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $status_asn = $_POST['status_asn'];

    $stmt = $pdo->prepare("INSERT INTO pegawai (nama, nip, jabatan, pangkat_golongan, jenis_kelamin, status_asn) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nama, $nip, $jabatan, $pangkat, $jenis_kelamin, $status_asn]);

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
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>

 <?php include '../partials/footer.php'; ?>
  </div>
</div>
