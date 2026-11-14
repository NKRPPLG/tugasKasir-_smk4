<?php
$judul = $judul ?? 'KasirSMK';
$halaman = $halaman ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($judul) ?> - KasirSMK</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="index.php">KasirSMK</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#menuUtama" aria-controls="menuUtama"
              aria-expanded="false" aria-label="Buka menu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="menuUtama">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link <?= $halaman === 'dashboard' ? 'active' : '' ?>" href="index.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $halaman === 'produk' ? 'active' : '' ?>" href="produk.php">Produk</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $halaman === 'kasir' ? 'active' : '' ?>" href="kasir.php">Kasir</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $halaman === 'pembelian' ? 'active' : '' ?>" href="pembelian.php">Pembelian</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $halaman === 'penjualan' ? 'active' : '' ?>" href="penjualan.php">Penjualan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $halaman === 'supplier' ? 'active' : '' ?>" href="supplier.php">Supplier</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $halaman === 'checklist' ? 'active' : '' ?>" href="checklist.php">Checklist</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $halaman === 'panduan' ? 'active' : '' ?>" href="panduan.php">Panduan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $halaman === 'profil' ? 'active' : '' ?>" href="profil.php">Profil Tim</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <main class="container py-4">
