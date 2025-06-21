<?php
require_once '../../config/init.php';
require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Pastikan data ada
$stmt = $pdo->prepare("SELECT id FROM sppd WHERE id = ?");
$stmt->execute([$id]);
if (!$stmt->fetch()) {
    setFlash('error', 'Data tidak ditemukan.');
    redirect('index.php');
}

// Hapus data
$delete = $pdo->prepare("DELETE FROM sppd WHERE id = ?");
$delete->execute([$id]);

set_Flash('success', 'Data berhasil dihapus.');
redirect('index.php');