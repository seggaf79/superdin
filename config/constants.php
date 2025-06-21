<?php
// config/constants.php

// Nama aplikasi
define('APP_NAME', 'SPPD OPD BULUNGAN');

// Base URL (jika aplikasi berada dalam subfolder, sesuaikan)
define('BASE_URL', '/sppd_opd_bulungan/');

// Lokasi folder upload (absolut & relatif)
define('UPLOAD_DIR', __DIR__ . '/../admin/uploads/');
define('UPLOAD_URL', BASE_URL . 'admin/uploads/');

// Default timezone
date_default_timezone_set('Asia/Makassar');