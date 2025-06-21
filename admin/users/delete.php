<?php
require_once '../../config/init.php';
require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Cek apakah user ada
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $delete = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $delete->execute([$id]);

        set_Flash('success', 'User berhasil dihapus.');
    } else {
        set_Flash('error', 'User tidak ditemukan.');
    }
} else {
    set_Flash('error', 'ID tidak valid.');
}

redirect('index.php');