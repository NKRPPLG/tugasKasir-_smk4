<?php
// ============================================================
// kasirsmk/config/database.php
// Satu koneksi MySQLi untuk seluruh halaman proyek KasirSMK.
// Database: db_penjualan
// ============================================================

mysqli_report(MYSQLI_REPORT_OFF);

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'penjualan_lengkap';

$koneksi = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$koneksi) {
    $pesan = htmlspecialchars(mysqli_connect_error(), ENT_QUOTES, 'UTF-8');
    die(
        '<div class="container py-5">' .
        '<div class="alert alert-danger">' .
        '<h1 class="h4">Koneksi database gagal</h1>' .
        '<p>Pesan MySQL: <strong>' . $pesan . '</strong></p>' .
        '<p>Periksa MySQL sudah menyala dan database <code>db_penjualan</code> sudah tersedia.</p>' .
        '</div>' .
        '</div>'
    );
}

mysqli_set_charset($koneksi, 'utf8mb4');
