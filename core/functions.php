<?php
// core/functions.php

// Fungsi redirect
function redirect($url) {
    header("Location: $url");
    exit;
}

// Fungsi untuk e() atau escape HTML output
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Fungsi format tanggal lokal (Indonesia)
function formatTanggal($tanggal) {
    if (!$tanggal || $tanggal === '0000-00-00') return '-';
    return date('d/m/Y', strtotime($tanggal));
}

// Fungsi format waktu lengkap
function formatTanggalLengkap($tanggal) {
    if (!$tanggal) return '-';
    return date('d/m/Y H:i', strtotime($tanggal));
}
