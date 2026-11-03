<?php
// blok 1 Baca data form
require dirname(__DIR__) . '/includes/init.php';
if (is_logged_in()) redirect('dashboard/');

//----- BLOK 1: proses form register -----
$error = '';
$nama = $email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $passord = trim($_POST['password'] ?? '');
    $konfirm = trim($_POST['konfirmasi'] ?? '');

    // (blok 2 menyusul di sini)
} 