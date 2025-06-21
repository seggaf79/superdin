<?php
require_once '../../config/init.php';
require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    setFlash('error', 'Data user tidak ditemukan.');
    redirect('index.php');
}
?>

<?php include '../partials/header.php'; ?>
<div class="flex">
<?php include '../partials/sidebar.php'; ?>
<div class="flex flex-col min-h-screen w-full">

<div class="p-4 max-w-xl">
    <h1 class="text-2xl font-bold mb-4">Detail Pengguna</h1>

    <?= showFlash('error') ?>

    <div class="bg-white shadow rounded p-4 space-y-3">
        <div><strong>Nama Lengkap:</strong><br> <?= e($user['nama']) ?></div>
        <div><strong>Username:</strong><br> <?= e($user['username']) ?></div>
    </div>

    <div class="mt-4">
        <a href="index.php" class="bg-gray-600 text-white px-4 py-2 rounded inline-block">← Kembali</a>
        <a href="edit.php?id=<?= $user['id'] ?>" class="bg-green-600 text-white px-4 py-2 rounded inline-block ml-2">Edit</a>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
</div>
</div>