<?php
//helper

function e($s): string{
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
}

// url('dompet/') -> /keuangan-app/dompet/
function url(string $path = ''): string {
    return BASE_URL . '/' . ltrim($path, '/');
}

function redirect(string $path): void {
    header('Location: ' . url($path));
    exit;
}

function rupiah($n): string {
    return 'Rp ' . number_format((float) $n, 0, ',', '.');
}

function tgl(string $d): string {
    return date('d/m/Y', strtotime($d));
}

//flash message
function set_flash(string $tipe, string $pesan): void {
    $_SESSION['flash'] = ['tipe' => $tipe, 'pesan' => $pesan];
}

function get_flash(): ?array {
    if (isset($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}

//proteksi CSRF
function csrt_token(): string {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string {
    return '<input type="hidden" name="csrf" value="' . csrf_token() . '">';
}

function csrf_check(): void {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(419);
        die('Token tidak valid. Silahkan muat ulang halaman.');
    }
}

//helper bulan (format YYYY-MM)

function bulan_valid(?string $b): string {
    return ($b && preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $b)) ? $b : date('Y-m');
}

function rentang_bulan(string $bulan): array {
    $awal = $bulan . '-01';
    return [$awal, date('Y-m-t', strtotime($awal))];
}