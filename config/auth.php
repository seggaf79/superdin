<?php
// config/auth.php

function login($user) {
    $_SESSION['user'] = [
        'id' => $user['id'],
        'nama' => $user['nama'],
        'username' => $user['username']
    ];
}

function logout() {
    session_destroy();
    header("Location: login.php");
    exit;
}

function currentUser() {
    return isset($_SESSION['user']) ? $_SESSION['user'] : null;
}

function isLoggedIn() {
    return isset($_SESSION['user']);
}