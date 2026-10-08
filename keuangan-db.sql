-- =====================================================
-- DATABASE : keuangan_db (Aplikasi Pencatat Keuangan)
-- Import lewat phpMyAdmin atau: mysql -u root < keuangan_db.sql
-- =====================================================
CREATE DATABASE IF NOT EXISTS keuangan_db
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE keuangan_db;

-- 1. USERS --------------------------------------------
CREATE TABLE users (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama        VARCHAR(100) NOT NULL,
    email       VARCHAR(100) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,   -- hasil password_hash()
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
) ENGINE=InnoDB;

-- 1. DOMPET (rekening / tempat menimpan uang)----------
CREATE TABLE dompet (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     INT UNSIGNED NOT NULL,
    nama_dompet VARCHAR(50) NOT NULL,
    saldo_awal  DECIMAL(15,2) NOT NULL DEFAULT 0,
    keterangan  VARCHAR(150) NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_dompet_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;