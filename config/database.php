<?php
//----- BLOK 1: konfigurasi database -----------
$DB_HOST = 'localhost';
$DB_NAME = 'keuangan_db';
$DB_USER = 'root';
$DB_PASS = '';

//---- BLOK 2: koneksi PDO --------
try {
    $pdo = new PDO(
        "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",
        $DB_USER,
        $DB_USER,
        [
            PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES      => false,
        ]
    );
} catch (PDOExeption $e) {
    die('Koneksi database gagal: ' . $e->getMessage());
}