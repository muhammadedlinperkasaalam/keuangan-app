<?php
//---- BLOK 1: pengaturan umum -----
define('APP_NAME', 'Catatan Keuangan');
date_default_timezone_set('Asia/Jakarta');

//BLOK 2: path & URL dasar (otomatis, aman dipindah nama folder) ----
define('ROOT_PATH', str_replace('\\', '/', dirname(__DIR__)));
$docRoot = rtrim(str_replace('\\', '/', (string) realpath($_SERVER['DOCUMENT_ROOT'] ?? '')), '/');
define('BASE_URL', rtrim(str_replace($docRoot, '', ROOT_PATH), '/'));

//----- BLOK 3: mulai session ----
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}