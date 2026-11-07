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

    $st = $pdo->prepare('SELECT * FROM users WHERE email = ?');\
    $st->execute([$email]);
    $user = $st->fetch();
}
$judul = 'login';
include ROOT_PATH . '/layouts/header.php';
?>
<h4 class="text-center">Halaman login (sementara)</h4>
<?php include ROOT_PATH . '/layouts/footer.php'; ?>