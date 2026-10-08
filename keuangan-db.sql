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

-- 3. KATEGORI (jenis menentukan pemasukan / pengeluaran) --
CREATE TABLE kategori (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         INT UNSIGNED NOT NULL,
    nama_kategori   VARCHAR(50) NOT NULL,
    jenis           ENUM('pemasukan','pengeluaran') NOT NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_kategori_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 4. TRANSFER (pindah saldo antar dompet) --------------
-- Bukan pemasukan/pengeluaran: total saldo tidak berubah, hanya berpindah dompet.
-- Biaya transfer (jika > 0) dicatat sebagai transaksi pengeluaran yang menunjuk
-- ke transfer ini lewat transaksi.transfer_id.
CREATE TABLE transfer (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         INT UNSIGNED NOT NULL,
    dari_dompet_id  INT UNSIGNED NOT NULL,
    ke_dompet_id    INT UNSIGNED NOT NULL,
    tanggal         DATE NOT NULL,
    jumlah          DECIMAL(15,2) NOT NULL,
    keterangan      VARCHAR(255) NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_tf_user_tanggal (user_id, tanggal),
    CONSTRAINT chk_tf_beda_dompet CHECK (dari_dompet_id <> ke_dompet_id),
    CONSTRAINT fk_tf_user FOREIGN KEY (user_id)         REFERENCES users(id)    ON DELETE CASCADE,
    CONSTRAINT fk_tf_dari FOREIGN KEY (dari_dompet_id)  REFERENCES dompet(id)   ON DELETE RESTRICT,
    CONSTRAINT fk_tf_ke   FOREIGN KEY (ke_dompet_id)    REFERENCES dompet(id)   ON DELETE RESTRICT
) ENGINE=InnoDB;