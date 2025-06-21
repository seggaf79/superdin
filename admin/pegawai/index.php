<?php
include_once '../../config/init.php';

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Get total count
$total = $pdo->query("SELECT COUNT(*) FROM pegawai")->fetchColumn();
$pages = ceil($total / $limit);

// Get data
$stmt = $pdo->prepare("SELECT * FROM pegawai ORDER BY id DESC LIMIT :start, :limit");
$stmt->bindValue(':start', $start, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$pegawais = $stmt->fetchAll();
?>

<?php include '../partials/header.php'; ?>
<div class="flex">
  <?php include '../partials/sidebar.php'; ?>

  <div class="flex flex-col min-h-screen w-full">


<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold text-gray-700">Data Pegawai</h1>
        <a href="tambah.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah Pegawai</a>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-blue-100 dark:text-blue-100">
            <thead class="text-xs text-white uppercase bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 dark:text-white">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Nama Pegawai</th>
                    <th class="px-4 py-3">NIP</th>
                    <th class="px-4 py-3">Jabatan</th>
                    <th class="px-4 py-3">Pangkat/Golongan</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 font-medium text-gray-900 whitespace-nowrap dark:text-white border-gray-400">
                <?php $no = $start + 1; ?>
                <?php foreach ($pegawais as $p): ?>
                    <tr>
                        <td class="px-4 py-2"><?= $no++ ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($p['nama']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($p['nip']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($p['jabatan']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($p['pangkat_golongan']) ?></td>
                        <td class="px-4 py-2 text-center space-x-1">
                            <button type="button" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 "><a href="detail.php?id=<?= $p['id'] ?>" class="text-white-600">Detail</a></button>
                            <button type="button" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><a href="edit.php?id=<?= $p['id'] ?>" class="text-white-600">Edit</a></button>
                            <button type="button" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><a href="delete.php?id=<?= $p['id'] ?>" class="text-white-600" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a></button>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-center space-x-1">
        <?php for ($i = 1; $i <= $pages; $i++): ?>
            <a href="?page=<?= $i ?>" class="px-3 py-1 border rounded <?= $i == $page ? 'bg-blue-600 text-white' : 'bg-white text-gray-700' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
</div>

    <?php include '../partials/footer.php'; ?>
  </div>
</div>