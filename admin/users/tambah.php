<?php
require_once '../../config/init.php';
require_login();

if (is_post()) {
    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi sederhana
    if ($nama && $username && $password) {
        // Hash password
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (nama, username, password) VALUES (?, ?, ?)");
        $stmt->execute([$nama, $username, $hashed]);

        set_Flash('success', 'User berhasil ditambahkan.');
        redirect('index.php');
    } else {
        set_Flash('error', 'Semua field wajib diisi.');
    }
}
?>

<?php include '../partials/header.php'; ?>
<div class="flex">
<?php include '../partials/sidebar.php'; ?>
<div class="flex flex-col min-h-screen w-full">

<div class="p-4 max-w-xl">
    <h1 class="text-2xl font-bold mb-4">Tambah User Baru</h1>

    <?= showFlash('success') ?>
    <?= showFlash('error') ?>

    <form method="POST" class="space-y-4 bg-white p-4 rounded shadow">
        <div>
            <label>Nama Lengkap</label>
            <input type="text" name="nama" class="w-full border px-2 py-1 rounded" required>
        </div>
        <div>
            <label>Username</label>
            <input type="text" name="username" class="w-full border px-2 py-1 rounded" required>
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" class="w-full border px-2 py-1 rounded" required>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>

<?php include '../partials/footer.php'; ?>
</div>
</div>