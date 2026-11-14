<?php
$judul   = 'Dashboard';
$halaman = 'dashboard';
require __DIR__ . '/partials/header.php';
?>

<!-- Hero Banner -->
<div class="ks-hero">
  <h1>Dashboard Kasir KMH</h1>
  <p>Koperasi Merah Hitam</p>
</div>

<!-- Modul Cards -->
<div class="row g-3 mb-4">

  <!-- Produk -->
  <div class="col-sm-6 col-xl-3">
    <div class="ks-card h-100">
      <div class="ks-card-body d-flex flex-column gap-2">
        <span class="ks-badge ks-badge-neutral">Master Data</span>
        <h2 class="h5 fw-bold mb-1" style="color:var(--gray-900)">📦 Produk</h2>
        <p class="ks-text-sm ks-text-muted flex-grow-1 mb-2">
          Kelola daftar produk: tambah, edit, hapus, dan pantau stok barang.
        </p>
        <div class="d-flex flex-wrap gap-2">
          <a class="ks-btn ks-btn-primary ks-btn-sm" href="produk.php">Buka Produk</a>
          <a class="ks-btn ks-btn-ghost ks-btn-sm"  href="produk_tambah.php">+ Tambah</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Kasir -->
  <div class="col-sm-6 col-xl-3">
    <div class="ks-card h-100">
      <div class="ks-card-body d-flex flex-column gap-2">
        <span class="ks-badge ks-badge-neutral">Master Data</span>
        <h2 class="h5 fw-bold mb-1" style="color:var(--gray-900)">👤 Kasir</h2>
        <p class="ks-text-sm ks-text-muted flex-grow-1 mb-2">
          Manajemen akun kasir: tambah, edit, dan nonaktifkan kasir.
        </p>
        <div class="d-flex flex-wrap gap-2">
          <a class="ks-btn ks-btn-primary ks-btn-sm"  href="kasir.php">Buka Kasir</a>
          <a class="ks-btn ks-btn-ghost ks-btn-sm"    href="kasir_tambah.php">+ Tambah</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Supplier -->
  <div class="col-sm-6 col-xl-3">
    <div class="ks-card h-100">
      <div class="ks-card-body d-flex flex-column gap-2">
        <span class="ks-badge ks-badge-neutral">Master Data</span>
        <h2 class="h5 fw-bold mb-1" style="color:var(--gray-900)">🏭 Supplier</h2>
        <p class="ks-text-sm ks-text-muted flex-grow-1 mb-2">
          Kelola data mitra pemasok Koperasi Merah Hitam.
        </p>
        <div class="d-flex flex-wrap gap-2">
          <a class="ks-btn ks-btn-primary ks-btn-sm" href="supplier.php">Buka Supplier</a>
          <a class="ks-btn ks-btn-ghost ks-btn-sm"   href="supplier_tambah.php">+ Tambah</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Profil Tim -->
  <div class="col-sm-6 col-xl-3">
    <div class="ks-card h-100">
      <div class="ks-card-body d-flex flex-column gap-2">
        <span class="ks-badge ks-badge-neutral">Informasi</span>
        <h2 class="h5 fw-bold mb-1" style="color:var(--gray-900)">🎓 Profil Tim</h2>
        <p class="ks-text-sm ks-text-muted flex-grow-1 mb-2">
          Profil anggota tim pengelola Koperasi Merah Hitam.
        </p>
        <a class="ks-btn ks-btn-ghost ks-btn-sm" href="profil.php">Buka Profil</a>
      </div>
    </div>
  </div>

</div>

<!-- Pembelian & Penjualan -->
<div class="row g-3 mb-4">

  <div class="col-md-6">
    <div class="ks-card h-100">
      <div class="ks-card-body d-flex flex-column gap-2">
        <span class="ks-badge ks-badge-neutral">Transaksi</span>
        <h2 class="h5 fw-bold mb-1" style="color:var(--gray-900)">🛒 Pembelian</h2>
        <p class="ks-text-sm ks-text-muted flex-grow-1 mb-2">
          Nota barang masuk: pilih supplier &amp; kasir, isi banyak barang, simpan, stok bertambah.
        </p>
        <div class="d-flex flex-wrap gap-2">
          <a class="ks-btn ks-btn-primary ks-btn-sm" href="pembelian.php">Buka Pembelian</a>
          <a class="ks-btn ks-btn-ghost ks-btn-sm"   href="pembelian_tambah.php">+ Tambah</a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="ks-card h-100">
      <div class="ks-card-body d-flex flex-column gap-2">
        <span class="ks-badge ks-badge-neutral">Transaksi</span>
        <h2 class="h5 fw-bold mb-1" style="color:var(--gray-900)">🧾 Penjualan</h2>
        <p class="ks-text-sm ks-text-muted flex-grow-1 mb-2">
          Transaksi barang keluar: cek stok, simpan nota, dan kurangi stok otomatis.
        </p>
        <div class="d-flex flex-wrap gap-2">
          <a class="ks-btn ks-btn-primary ks-btn-sm" href="penjualan.php">Buka Penjualan</a>
          <a class="ks-btn ks-btn-ghost ks-btn-sm"   href="penjualan_tambah.php">+ Tambah</a>
        </div>
      </div>
    </div>
  </div>

</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
