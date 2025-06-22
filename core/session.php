<?php
// core/session.php

// Pastikan session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sedang login
function is_user_logged_in() {
    return isset($_SESSION['user']);
}

// Ambil data user yang sedang login
function get_user_login() {
    return $_SESSION['user'] ?? null;
}

// Paksa redirect jika belum login
function require_login() {
    if (!is_user_logged_in()) {
        header('Location: /admin/login.php');
        exit;
    }
}