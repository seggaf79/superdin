<?php
require_once '../../config/init.php';
require_login();

$limit = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Hitung total data
$totalQuery = $pdo->query("SELECT COUNT(*) FROM sppd");
$totalData = $totalQuery->fetchColumn();
$totalPages = ceil($totalData / $limit);

// Ambil data dengan paginasi
// Ambil data dengan paginasi dan join pegawai
$stmt = $pdo->prepare(
    "SELECT s.id, s.no_surat, s.tujuan, s.tgl_input, s.tgl_berangkat,
            p.nama AS nama_pegawai
     FROM sppd s
     JOIN pegawai p ON s.pegawai_id = p.id
     ORDER BY s.tgl_input DESC
     LIMIT :limit OFFSET :offset"
);

$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$sppds = $stmt->fetchAll();

$total_pegawai = $pdo->query("SELECT COUNT(*) FROM pegawai")->fetchColumn();
$total_sppd = $pdo->query("SELECT COUNT(*) FROM sppd")->fetchColumn();
?>

<?php include '../partials/header.php'; ?>
<div class="flex">
  <?php include '../partials/sidebar.php'; ?>

  <div class="flex flex-col min-h-screen w-full">
    <main class="flex-grow p-4 space-y-6">
      <h1 class="text-2xl font-bold text-gray-700">Daftar SPPD</h1>

      <!-- Tile Statistik -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-blue-600 text-white p-6 rounded-lg shadow text-center">
          <div class="text-sm">Jumlah Pegawai</div>
          <div class="text-3xl font-bold"><?= $total_pegawai ?></div>
        </div>
        <div class="bg-green-600 text-white p-6 rounded-lg shadow text-center">
          <div class="text-sm">Jumlah SPPD</div>
          <div class="text-3xl font-bold"><?= $total_sppd ?></div>
        </div>
      </div>

      <!-- Tombol Tambah -->
      <div class="flex justify-end">
        <a href="tambah.php" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded text-sm mb-2">+ Tambah SPPD</a>
      </div>

      <!-- Tabel SPPD -->
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-blue-100 dark:text-blue-100">
            <thead class="text-xs text-white uppercase bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 dark:text-white">
            <tr>
              <th class="px-4 py-2">No</th>
              <th class="px-4 py-2">No Surat Tugas</th>
              <th class="px-4 py-2">Nama</th>
              <th class="px-4 py-2">Tujuan</th>
              <th class="px-4 py-2">Tanggal Dibuat</th>
              <th class="px-4 py-2">Tanggal Berangkat</th>
              <th class="px-4 py-2">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($sppds as $row): ?>
              <tr class="bg-white dark:bg-gray-800 font-medium text-gray-900 whitespace-nowrap dark:text-white hover:bg-gray-50">
                <td class="px-4 py-2"><?= $no++ ?></td>
                <td class="px-4 py-2"><?= e($row['no_surat']) ?></td>
                <td class="px-4 py-2"><?= e($row['nama_pegawai']) ?></td>
                <td class="px-4 py-2"><?= e($row['tujuan']) ?></td>
                <td class="px-4 py-2"><?= date('d-m-Y', strtotime($row['tgl_input'])) ?></td>
                <td class="px-4 py-2"><?= date('d-m-Y', strtotime($row['tgl_berangkat'])) ?></td>
                <td class="px-4 py-2 space-y-1">
                  <button type="button" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 "><a href="detail.php?id=<?= $row['id'] ?>" class="block text-white-600">Detail</a></button>
                  <button type="button" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><a href="edit.php?id=<?= $row['id'] ?>" class="block text-black-600">Edit</a></button>
                  <button type="button" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')" class="block text-white-600">Hapus</a></button>
                  <br>
                  <button type="button" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><a href="export_pdf_sppd.php?id=<?= $row['id'] ?>" class="block text-white-600">PDF SPPD</a></button>
                  <button type="button" class="text-white bg-gradient-to-r from-pink-400 via-pink-500 to-pink-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-pink-300 dark:focus:ring-pink-800 shadow-lg shadow-pink-500/50 dark:shadow-lg dark:shadow-pink-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><a href="export_pdf_surat_tugas.php?id=<?= $row['id'] ?>" class="block text-white-600 hover:underline">PDF Surat Tugas</a></button>
                  </td>
              </tr>
            <?php endforeach; ?>
            <?php if (count($sppds) === 0): ?>
              <tr>
                <td colspan="7" class="text-center px-4 py-3 text-gray-500">Belum ada data SPPD</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </main>

    <div class="mt-4 flex justify-center gap-2">
  <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="?page=<?= $i ?>" class="px-3 py-1 rounded border <?= $i == $page ? 'bg-blue-600 text-white' : 'bg-white text-gray-700' ?>">
      <?= $i ?>
    </a>
  <?php endfor; ?>
</div>
<br>

    <?php include '../partials/footer.php'; ?>
  </div>
</div>
