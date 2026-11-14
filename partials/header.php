<?php
$judul   = $judul   ?? 'Kasir KMH';
$halaman = $halaman ?? '';

// Daftar menu sidebar
$menu = [
    ['href' => 'index.php',    'key' => 'dashboard', 'icon' => '🏠', 'label' => 'Dashboard'],
    ['href' => 'produk.php',   'key' => 'produk',    'icon' => '📦', 'label' => 'Produk'],
    ['href' => 'kasir.php',    'key' => 'kasir',     'icon' => '👤', 'label' => 'Kasir'],
    ['href' => 'supplier.php', 'key' => 'supplier',  'icon' => '🏭', 'label' => 'Supplier'],
    ['divider' => true],
    ['href' => 'pembelian.php',  'key' => 'pembelian',  'icon' => '🛒', 'label' => 'Pembelian'],
    ['href' => 'penjualan.php',  'key' => 'penjualan',  'icon' => '🧾', 'label' => 'Penjualan'],
    ['divider' => true],
    ['href' => 'profil.php',    'key' => 'profil',    'icon' => '🎓', 'label' => 'Profil Tim'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($judul) ?> - Kasir KMH</title>
  <!-- Bootstrap 5 tetap dipakai untuk komponen (grid, modal, dsb.) -->
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <!-- Tema kustom kita: layout sidebar + komponen sendiri -->
  <link rel="stylesheet" href="assets/tema.css">
</head>
<body>

<!-- Overlay mobile -->
<div class="ks-overlay" id="ksOverlay"></div>

<!-- ============ LAYOUT WRAPPER ============ -->
<div class="ks-layout">

  <!-- ======== SIDEBAR ======== -->
  <aside class="ks-sidebar" id="ksSidebar">

    <!-- Brand / Logo -->
    <a class="ks-brand" href="index.php">
      <span class="ks-brand-icon">🧾</span>
      <span>
        <span class="ks-brand-name">Kasir KMH</span><br>
        <span class="ks-brand-sub">Koperasi Merah Hitam</span>
      </span>
    </a>

    <!-- Navigation -->
    <ul class="ks-nav">
      <li class="ks-nav-label">Menu Utama</li>
      <?php foreach ($menu as $item): ?>
        <?php if (!empty($item['divider'])): ?>
          <li><div class="ks-nav-divider"></div></li>
        <?php else: ?>
          <li class="ks-nav-item">
            <a href="<?= $item['href'] ?>"
               class="ks-nav-link <?= $halaman === $item['key'] ? 'active' : '' ?>">
              <span class="ks-nav-icon"><?= $item['icon'] ?></span>
              <?= $item['label'] ?>
            </a>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>

    <!-- Sidebar footer -->
    <div class="ks-sidebar-footer">
      Kasir KMH &middot; Koperasi Merah Hitam<br>
      <?= date('Y') ?>
    </div>
  </aside>
  <!-- ======== END SIDEBAR ======== -->

  <!-- ======== AREA KONTEN ======== -->
  <div class="ks-content">

    <!-- Topbar -->
    <header class="ks-topbar">
      <!-- Tombol hamburger (hanya muncul di mobile) -->
      <button class="ks-hamburger" id="ksHamburger" aria-label="Buka menu">
        ☰
      </button>
      <span class="ks-topbar-title"><?= htmlspecialchars($judul) ?></span>
      <span class="ks-topbar-breadcrumb ks-text-muted ks-text-sm d-none d-md-block">
        Kasir KMH &gt; <?= htmlspecialchars($judul) ?>
      </span>
    </header>

    <!-- Konten halaman -->
    <main class="ks-main">
