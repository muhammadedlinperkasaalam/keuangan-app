<?php
// ---- BLOK 1: cek status login ----
function is_logged_in(): bool {
    return isset($_SESSION['user_id']);
}

function user_is(): int {
    return (int) ($_SESSION['user_id'] ?? 0);
}

// ---- BLOK 2: wajib login (taruh di halaman yang diproteksi) ----
function require_login(): void {
    if (!is_logged_in()) {
        redirect('auth/login.php');
    }
}