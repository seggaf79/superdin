<?php
require_once '../../config/init.php';
require_login();

// Pagination
$perPage = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$start = ($page - 1) * $perPage;

// Total data
$totalStmt = $pdo->query("SELECT COUNT(*) FROM users");
$totalData = $totalStmt->fetchColumn();
$totalPages = ceil($totalData / $perPage);

// Ambil data user
$stmt = $pdo->prepare("SELECT * FROM users ORDER BY nama ASC LIMIT :start, :limit");
$stmt->bindValue(':start', $start, PDO::PARAM_INT);
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../partials/header.php'; ?>
<div class="flex">
<?php include '../partials/sidebar.php'; ?>
<div class="flex flex-col min-h-screen w-full">

<div class="p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Data Pengguna</h1>
        <a href="tambah.php" class="bg-green-600 text-white px-4 py-2 rounded">+ Tambah</a>
    </div>

    <?= showFlash('success') ?>
    <?= showFlash('error') ?>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-blue-100 dark:text-blue-100">
            <thead class="text-xs text-white uppercase bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 dark:text-white">
                <tr>
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Username</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $index => $user): ?>
                    <tr class="bg-white dark:bg-gray-800 font-medium text-gray-900 whitespace-nowrap dark:text-white hover:bg-gray-50">
                        <td class="px-4 py-2 border"><?= $start + $index + 1 ?></td>
                        <td class="px-4 py-2 border"><?= e($user['nama']) ?></td>
                        <td class="px-4 py-2 border"><?= e($user['username']) ?></td>
                        <td class="px-4 py-2 border space-x-1">
                            <a href="detail.php?id=<?= $user['id'] ?>" class="text-blue-600 hover:underline">Detail</a>
                            <a href="edit.php?id=<?= $user['id'] ?>" class="text-green-600 hover:underline">Edit</a>
                            <a href="delete.php?id=<?= $user['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center text-gray-500">Belum ada data pengguna.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginasi -->
    <div class="mt-4">
        <nav class="inline-flex space-x-1">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>" class="px-3 py-1 border rounded <?= $i == $page ? 'bg-blue-600 text-white' : 'bg-white text-gray-700' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </nav>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
</div>
</div>