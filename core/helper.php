<?php
// core/helper.php

// Fungsi untuk membuat slug dari teks
function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);

    return empty($text) ? 'n-a' : $text;
}

// Fungsi untuk memotong string panjang
function truncate($string, $length = 100) {
    if (strlen($string) <= $length) return $string;
    return substr($string, 0, $length) . '...';
}

// Fungsi untuk generate kode random
function generateKode($prefix = '', $length = 5) {
    return $prefix . strtoupper(bin2hex(random_bytes($length)));
}

// Fungsi cek apakah request POST
function is_post() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}