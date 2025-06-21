<?php
require_once '../config/init.php';

// Hapus session
session_unset();
session_destroy();

// Redirect ke halaman login
redirect('login.php');