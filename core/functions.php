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

function formatTanggalIndo($tanggal) {
    $tanggal = substr($tanggal, 0, 10);
    $bulan = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    ];

    // Format masukan yang didukung: dd-mm-yyyy atau yyyy-mm-dd
    if (strpos($tanggal, '-') !== false) {
        $pecah = explode('-', $tanggal);
        if (strlen($pecah[0]) == 4) {
            // Format yyyy-mm-dd
            return $pecah[2] . ' ' . $bulan[$pecah[1]] . ' ' . $pecah[0];
        } else {
            // Format dd-mm-yyyy
            return $pecah[0] . ' ' . $bulan[$pecah[1]] . ' ' . $pecah[2];
        }
    }

    return $tanggal; // fallback kalau formatnya aneh
}
