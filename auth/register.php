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

// -------- BLOK 4: tampilan ----------
$judul = 'Daftar';
include ROOT_PATH . '/layouts/header.php';
?>
<div class="auth-box">
    <div class="card p-4">
        <h4 class="mb-3 text-center">Buat Akun</h4>
        <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
            <form method="post">
                <?= csrf_field() ?>
                <div class="mb-3"><label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" value="<?= e($nama) ?>" required></div>
                <div class="mb-3"><label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= e($email) ?>" required></div>
                <div class="mb-3"><label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Konfirmasi Password</label>
                <input type="password" name="konfirmasi" class="form-control" required></div>
                <button class="btn btn-primary w-100">Daftar</button>
            </form>
            <p class="text-center mt-3 mb-0">Sudah punya akun ? <a href="login.php">Login</a></p>
    </div>
</div>
<?php include ROOT_PATH . '/layouts/footer.php'; ?>