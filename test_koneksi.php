<?php
// file sementara untuk part 1 (hapus setelah part 1 selesai)
require __DIR__ . '/config/app.php';
require __DIR__ . '/config/database.php';

echo '<h2>' . APP_NAME . '</h2>';
echo '<p>Koneksi database: <b style="color:green">BERHASIL</b></p>';
echo '<p>Timezone: ' . date_default_timezone_get() . ' | waktu server: ' . date('d/m/Y H:i:s') . '</p>'; 
echo '<p>BASE_URL: <code>' . BASE_URL . '</code></p>';

//daftar tabel yang berhasil dibuat
$tabel = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
echo '<p>Jumlah tabel: ' . count($tabel) . '</p><ul>';
foreach ($tabel as $t) {
    echo '<li>' . $t . '</li>';
}
echo '</ul>';

//Contoh prepare statement (tanda ? diisi lewat execute)
$st = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
$st->execute(['demo@keuangan.test']);
echo '<p>User dengan email demo: ' . $st->fetchColumn() . '</p>';