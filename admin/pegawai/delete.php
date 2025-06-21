<?php
require_once '../../config/init.php';
require_login();

// Ambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Cek apakah data ada
    $stmt = $pdo->prepare("SELECT * FROM pegawai WHERE id = ?");
    $stmt->execute([$id]);
    $pegawai = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pegawai) {
        // Lakukan penghapusan
        $delete = $pdo->prepare("DELETE FROM pegawai WHERE id = ?");
        $delete->execute([$id]);
        set_Flash('success', 'Data pegawai berhasil dihapus.');
    } else {
        set_Flash('error', 'Data tidak ditemukan.');
    }
} else {
    set_Flash('error', 'ID tidak valid.');
}

redirect('index.php');