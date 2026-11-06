<?php
$judul = 'Dashboard';
$halaman = 'dashboard';
require __DIR__ . '/partials/header.php';
?>

<div class="page-hero p-4 p-md-5 mb-4">
  <span class="badge text-bg-warning mb-2">Proyek Akhir P15-P16</span>
  <h1 class="display-6 fw-bold">KasirSMK</h1>
  <p class="lead mb-3">
    Proyek CRUD Toko Maju Jaya memakai PHP natif, MySQLi, dan Bootstrap.
    Modul produk sudah lengkap sebagai contoh. Tugasmu melengkapi modul kasir
    dan supplier.
  </p>
  <a class="btn btn-warning fw-semibold" href="panduan.php">Buka Panduan</a>
  <a class="btn btn-outline-light" href="presentasi.php">Mode Presentasi</a>
  <a class="btn btn-outline-light" href="panduan.php#produk">Penjelasan Produk</a>
  <a class="btn btn-outline-light" href="produk.php">Lihat Hasil Produk</a>
</div>

<div class="row g-4 mb-4">
  <div class="col-md-6 col-xl-3">
    <div class="card h-100 done-card">
      <div class="card-body d-flex flex-column">
        <span class="badge text-bg-success align-self-start mb-2">Contoh selesai</span>
        <h2 class="h4">Produk</h2>
        <p class="text-secondary flex-grow-1">
          Daftar, cari, tambah, edit, dan hapus produk. Penjelasan per form dan
          jQuery tersedia di panduan.
        </p>
        <div class="d-flex flex-wrap gap-2">
          <a class="btn btn-primary" href="produk.php">Buka Produk</a>
          <a class="btn btn-outline-primary" href="panduan.php#produk">Penjelasan</a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-xl-3">
    <div class="card h-100 task-card">
      <div class="card-body d-flex flex-column">
        <span class="badge text-bg-warning align-self-start mb-2">Contoh + Tugas</span>
        <h2 class="h4">Kasir</h2>
        <p class="text-secondary flex-grow-1">
          Daftar kasir dan contoh form sudah tersedia. Tugasmu melengkapi proses
          simpan, edit, dan nonaktifkan.
        </p>
        <a class="btn btn-outline-primary" href="kasir.php">Buka Kasir</a>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-xl-3">
    <div class="card h-100 task-card">
      <div class="card-body d-flex flex-column">
        <span class="badge text-bg-warning align-self-start mb-2">Tugas dari Nol</span>
        <h2 class="h4">Supplier</h2>
        <p class="text-secondary flex-grow-1">
          Buat sendiri daftar, tambah, edit, dan hapus supplier. Cek dulu
          pemakaian supplier di tabel pembelian.
        </p>
        <a class="btn btn-outline-primary" href="panduan.php#tugas-supplier">Lihat Brief Supplier</a>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-xl-3">
    <div class="card h-100">
      <div class="card-body d-flex flex-column">
        <span class="badge text-bg-primary align-self-start mb-2">Materi</span>
        <h2 class="h4">Panduan</h2>
        <p class="text-secondary flex-grow-1">
          Peta folder, Bootstrap, koneksi database, penjelasan produk per form,
          jQuery, hasil akhir, brief tugas, checklist, dan rubrik.
        </p>
        <a class="btn btn-outline-primary" href="panduan.php">Buka Panduan</a>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-7">
    <div class="card h-100">
      <div class="card-header bg-white fw-semibold">Alur Proyek</div>
      <div class="card-body">
        <ol class="mb-0">
          <li class="mb-2">Pelajari penjelasan produk per form, lalu coba hasil akhirnya.</li>
          <li class="mb-2">Baca brief kasir di panduan, lalu isi file tugas kasir.</li>
          <li class="mb-2">Baca brief supplier, lalu isi file tugas supplier.</li>
          <li class="mb-2">Uji semua fitur dengan data nyata dari database.</li>
          <li>Presentasikan hasil proyek pada pertemuan showcase.</li>
        </ol>
      </div>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="card h-100">
      <div class="card-header bg-white fw-semibold">Informasi Proyek</div>
      <div class="card-body">
        <table class="table table-sm mb-0">
          <tbody>
            <tr>
              <th>Database</th>
              <td><code>db_penjualan</code></td>
            </tr>
            <tr>
              <th>Tabel contoh</th>
              <td><code>produk</code></td>
            </tr>
            <tr>
              <th>Tugas</th>
              <td><code>kasir</code>, <code>supplier</code></td>
            </tr>
            <tr>
              <th>Tampilan</th>
              <td>Bootstrap 5 lokal</td>
            </tr>
            <tr>
              <th>Interaksi</th>
              <td>jQuery 3.7.1 lokal</td>
            </tr>
            <tr>
              <th>Folder</th>
              <td><code>smk4/kasirsmk/</code></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
