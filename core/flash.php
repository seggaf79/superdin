<?php
if (!function_exists('set_flash')) {
    function set_flash($message) {
        $_SESSION['flash'] = $message;
    }
}

if (!function_exists('get_flash')) {
    function get_flash() {
        if (isset($_SESSION['flash'])) {
            $msg = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $msg;
        }
        return null;
    }
}

function showFlash($key)
{
    if (!isset($_SESSION[$key])) {
        return '';
    }

    $message = $_SESSION[$key];
    unset($_SESSION[$key]);

    return '<div class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-300 text-sm">' . htmlspecialchars($message) . '</div>';
}