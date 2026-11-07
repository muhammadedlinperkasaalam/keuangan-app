<?php
//SEMENTARA: hanya di pakai untuk redirect dari register agar tidak 404 dan flash message terlihat.
//file ini akan di timpa penuh part 4
require dirname(__DIR__) . '/includes/init.php';
if (is_logged_in()) redirect('dashboard/');

// ---- BLOK 1: proses login -------
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $email      = trim($_POST['email'] ?? '');
    $password   = $_POST['password'] ?? '';

    $st = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $st->execute([$email]);
    $user = $st->fetch();

    // ---- BLOK 2 : cek password & buat session ---
    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        redirect('dashboard/');
    }
    $error = 'Email atau password salah !';
}

// ----- BLOK 3 : tampilan -----
$judul = 'login';
include ROOT_PATH . '/layouts/header.php';
?>
<div class="auth-box">
    <div class="card p-4">
        <h4 class="mb-3 text-center"><?= APP_NAME ?></h4>
        <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
            <form method="post">
                <?= csrf_field() ?>
                <div class="mb-3"><label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required autofocus></div>
                <div class="mb-3"><label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required></div>
                <button class="btn btn-primary w-100">Masuk</button>
            </form>
            <p class="text-center" mt-3 mb-0>Belum Punya Akun ? <a href="register.php">Daftar</a></p>
    </div>
</div>
<?php include ROOT_PATH . '/layouts/footer.php'; ?>