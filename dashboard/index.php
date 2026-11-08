<?php
//sementara : hanya untuk menguji login. diperbarui di video berikutnya
require dirname(__DIR__) . '/includes/init.php';
require_login();

$judul = 'Dashboard';
include ROOT_PATH . '/layouts/header.php';
?>
<h4>Selamat datang, <?= e($_SESSION['nama']) ?></h4>
<p>Login Berhasil. Ini halaman Dashboard sementara.</p>
<?php include ROOT_PATH . '/layouts/footer.php'; ?>