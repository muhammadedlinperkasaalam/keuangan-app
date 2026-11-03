<?php
// blok 1 helper

function e($s): string{
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
}

// blok 2 url('dompet/') -> /keuangan-app/dompet/
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

// blok 3 flash message
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

// blok 4 proteksi CSRF
function csrf_token(): string {
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

// blok 5 helper bulan (format YYYY-MM)

function bulan_valid(?string $b): string {
    return ($b && preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $b)) ? $b : date('Y-m');
}

function rentang_bulan(string $bulan): array {
    $awal = $bulan . '-01';
    return [$awal, date('Y-m-t', strtotime($awal))];
}

// blok 6: data awal untuk user baru
function seed_detault(PDO $pdo, int $uid): void {
    $pdo->prepare("INSERT INTO dompet (user_id, nama_dompet, saldo_awal) VALUES (?, 'Tunai', 0)")
    ->execute([$uid]);
    $kat = [
        ['Gaji', 'pemasukan'], ['Bonus', 'pemasukan'], ['Lainnya', 'pemasukan'],
        ['Makan & Minum', 'pengeluaran'], ['Transportasi', 'pengeluaran'],
        ['Belanja', 'pengeluaran'], ['Tagihan', 'pengeluaran'], ['Hiburan', 'pengeluaran'],
        ['Biaya Admin', 'pengeluaran'],
    ];
    $st = $pdo->prepare('INSERT INTO kategori (user_id, nama_kategori, jenis) VALUES (?, ?, ?)');
    foreach ($kat as [$nama, $jenis]) {
        $st->execute([$uid, $nama, $jenis]);
    }
}