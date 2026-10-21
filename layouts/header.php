<?php
$flash = get_flash();
$modul = basename(dirname($_SERVER['SCRIPT_NAME'])); //nama folder modul aktif
$menu  = [
    'dashboard' => 'Dashboard',
    'transaksi' => 'Transaksi',
    'transfer'  => 'Transfer',
    'dompet'    => 'Dompet',
    'kategori'  => 'Kategori',
    'anggaran'  => 'Anggaran',
    'laporan'   => 'Laporan',
];
?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= e($judul ?? APP_NAME) ?> - <?= APP_NAME ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= BASE_URL ?>/assets/css/style.css" rel="stylesheet">
    </head>
    <body>
        <?php if (is_logged_in()): ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand fw-bold" href="<?= url('dashboard/') ?>"><?= APP_NAME ?></a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="nav">
                    <ul class="navbar-nav me-auto">
                        <?php foreach ($menu as $folder => $label): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $modul === $folder ? 'active' : '' ?> " href="<?= url($folder . '/') ?>"><?= $label ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <span class="navbar-text me-3">Halo, <?= e($_SESSION['nama'] ?? '') ?></span>
                    <a class="btn btn-sm btn-light" href="<?= url('auth/logout.php') ?>">Keluar</a>
                </div>
            </div>
        </nav>
        <?php endif; ?>
        <main class="container py-4">
        <?php if ($flash): ?> 
        <div class="alert alert-<?= e($flash['tipe']) ?> alert-dismissible fade show">
            <?= e($flash['pesan']) ?>
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        </main>
        <footer class="text-center text-muted small py-3">
            &copy; <?= date('Y') ?> <?= APP_NAME ?> &middot; PHP Native + MySQL
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="<?= BASE_URL ?>/assets/js/app.js"></script>
    </body>
    </html>