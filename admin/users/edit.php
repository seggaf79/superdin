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

if (is_post()) {
    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($nama && $username) {
        if (!empty($password)) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE users SET nama = ?, username = ?, password = ? WHERE id = ?");
            $update->execute([$nama, $username, $hashed, $id]);
        } else {
            $update = $pdo->prepare("UPDATE users SET nama = ?, username = ? WHERE id = ?");
            $update->execute([$nama, $username, $id]);
        }

        set_Flash('success', 'Data user berhasil diperbarui.');
        redirect('index.php');
    } else {
        set_Flash('error', 'Nama dan username wajib diisi.');
    }
}
?>

<?php include '../partials/header.php'; ?>
<div class="flex">
<?php include '../partials/sidebar.php'; ?>
<div class="flex flex-col min-h-screen w-full">

<div class="p-4 max-w-xl">
    <h1 class="text-2xl font-bold mb-4">Edit Pengguna</h1>

    <?= showFlash('error') ?>
    <?= showFlash('success') ?>

    <form method="POST" class="space-y-4 bg-white p-4 rounded shadow">
        <div>
            <label>Nama Lengkap</label>
            <input type="text" name="nama" value="<?= e($user['nama']) ?>" class="w-full border px-2 py-1 rounded" required>
        </div>
        <div>
            <label>Username</label>
            <input type="text" name="username" value="<?= e($user['username']) ?>" class="w-full border px-2 py-1 rounded" required>
        </div>
        <div>
            <label>Password (biarkan kosong jika tidak ingin mengubah)</label>
            <input type="password" name="password" class="w-full border px-2 py-1 rounded">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Perbarui</button>
    </form>
</div>

<?php include '../partials/footer.php'; ?>
</div>
</div>