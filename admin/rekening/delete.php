<?php
require_once '../../config/init.php';
require_login();

// Ambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Cek apakah data ada
    $stmt = $pdo->prepare("SELECT * FROM rekening WHERE id = ?");
    $stmt->execute([$id]);
    $rekening = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($rekening) {
        // Hapus data
        $delete = $pdo->prepare("DELETE FROM rekening WHERE id = ?");
        $delete->execute([$id]);

        set_Flash('success', 'Data rekening berhasil dihapus.');
    } else {
        set_Flash('error', 'Data tidak ditemukan.');
    }
} else {
    set_Flash('error', 'ID tidak valid.');
}

redirect('index.php');