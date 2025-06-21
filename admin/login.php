<?php
require_once '../config/init.php';

$errors = [];

if (is_post()) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === '' || $password === '') {
        $errors[] = 'Username dan password wajib diisi.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            redirect('dashboard/index.php');
        } else {
            $errors[] = 'Username atau password salah.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | E-SPPD OPD Bulungan</title>
  <link href="../assets/css/tailwind.min.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-gray-100 flex">

  <!-- Kiri: Gambar Background -->
  <div class="w-1/2 hidden md:block relative">
    <img src="../assets/images/background2.jpg" class="absolute inset-0 w-full h-full object-cover" alt="Background">
  </div>

  <!-- Kanan: Form Login -->
  <div class="w-full md:w-1/2 flex flex-col justify-center items-center px-6 py-10 bg-white relative">

    <img src="../assets/images/logobulungan.png" alt="Logo Bulungan" class="w-16 h-16 mb-4">

    <h1 class="text-2xl font-bold text-gray-900 mb-6">Aplikasi SPPD OPD Pemkab. Bulungan</h1>

    <?php if (!empty($errors)): ?>
      <div class="bg-red-100 text-red-700 p-3 rounded w-full max-w-sm mb-4">
        <?= implode('<br>', array_map('e', $errors)) ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="w-full max-w-sm space-y-4">
      <div>
        <label class="block text-gray-600 mb-1">Username</label>
        <input type="text" name="username" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>
      <div>
        <label class="block text-gray-600 mb-1">Password</label>
        <input type="password" name="password" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Login</button>
    </form>

    <!-- Footer -->
    <div class="absolute bottom-4 flex flex-col items-center text-gray-500 text-sm">
      <img src="../assets/images/logodkip.png" alt="Logo DKIP" class="w-10 h-10 mb-1">
      <p class="text-xs">E-SPPD OPD Bulungan by Seggaf - DKIP Bulungan</p>
    </div>

  </div>

</body>
</html>