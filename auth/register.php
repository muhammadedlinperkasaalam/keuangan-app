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
    $password = trim($_POST['password'] ?? '');
    $konfirm = trim($_POST['konfirmasi'] ?? '');

// ----- BLOK 2: validasi -------
    if ($nama === '' || $email === '' || $password === '') {
        $error = 'Semua field wajib diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid.';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter.';
    } elseif ($password !== $konfirm) {
        $error = 'Konfirmasi password tidak sama.';
    } else {
        $cek = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $cek->execute([$email]);
        if ($cek->fetch()) {
            $error = 'Email sudah terdaftar.';
        } else {
            // ------ BLOK 3: simpan user + data awal ---------
            $st = $pdo->prepare('INSERT INTO users (nama, email, password) VALUES (?, ?, ?)');
            $st->execute([$nama, $email, password_hash($password, PASSWORD_DEFAULT)]);
            seed_default($pdo, (int) $pdo->lastInsertId());
            set_flash('success', 'Registrasi berhasil, silahkan login.');
            redirect('auth/login.php');
        }
    }
} 