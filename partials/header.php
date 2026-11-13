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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/nature-background.css">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body class="nature-active">
  <!-- 3D Nature Canvas Fixed Background -->
  <div id="nature-3d-bg"></div>
  <div class="vignette-overlay"></div>

  <!-- View Mode Switcher (Hide/Show UI) -->
  <button class="view-mode-toggle" id="btnToggleUI" title="Lihat Pemandangan 3D Tanpa UI">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
      <circle cx="12" cy="12" r="3"></circle>
    </svg>
    <span id="uiToggleText">Sembunyikan UI</span>
  </button>

  <div class="website-container" id="websiteContent">
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top glass-navbar">
      <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="index.php">
          <span class="brand-badge-nature">🌿</span> KasirSMK
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#menuUtama" aria-controls="menuUtama"
                aria-expanded="false" aria-label="Buka menu">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuUtama">
          <ul class="navbar-nav ms-auto align-items-lg-center">
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
            <li class="nav-item ms-lg-2">
              <a class="btn btn-sm btn-outline-success text-white px-3 py-1 rounded-pill" href="nature-demo.html" target="_blank">
                ✨ Showcase
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <main class="container py-4">
