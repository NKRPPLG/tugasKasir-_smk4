<?php
require __DIR__ . '/config/database.php';

$cari = trim($_GET['cari'] ?? '');
$errorTabel = '';

if ($cari !== '') {
    $stmt = mysqli_prepare(
        $koneksi,
        'SELECT kode_produk, nama_produk, harga_beli, harga_jual, stok_awal
         FROM produk
         WHERE kode_produk LIKE ? OR nama_produk LIKE ?
         ORDER BY kode_produk'
    );

    if (!$stmt) {
        $errorTabel = mysqli_error($koneksi);
        $hasil = false;
    } else {
        $kataKunci = '%' . $cari . '%';
        mysqli_stmt_bind_param($stmt, 'ss', $kataKunci, $kataKunci);
        mysqli_stmt_execute($stmt);
        $hasil = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
    }
} else {
    $hasil = mysqli_query(
        $koneksi,
        'SELECT kode_produk, nama_produk, harga_beli, harga_jual, stok_awal
         FROM produk
         ORDER BY kode_produk'
    );

    if (!$hasil) {
        $errorTabel = mysqli_error($koneksi);
    }
}

$daftarProduk = [];
if ($hasil) {
    while ($baris = mysqli_fetch_assoc($hasil)) {
        $daftarProduk[] = $baris;
    }
}

$jumlahProduk = count($daftarProduk);
$totalStok = 0;
$stokMenipis = 0;

foreach ($daftarProduk as $baris) {
    $totalStok += (int) $baris['stok_awal'];
    if ((int) $baris['stok_awal'] <= 5) {
        $stokMenipis++;
    }
}

$pesanStatus = [
    'tambah' => ['success', 'Produk baru berhasil ditambahkan.'],
    'edit'   => ['success', 'Perubahan produk berhasil disimpan.'],
    'hapus'  => ['success', 'Produk berhasil dihapus.'],
];
$status = $_GET['status'] ?? '';

$judul = 'Daftar Produk';
$halaman = 'produk';
require __DIR__ . '/partials/header.php';
?>

<!-- Page Header -->
<div class="ks-page-header mb-4">
  <div class="ks-page-header-left">
    <span class="ks-badge ks-badge-neutral mb-2">Master Data</span>
    <h1 class="ks-page-title">Daftar Produk</h1>
    <p class="ks-page-subtitle">Koperasi Merah Hitam</p>
  </div>
  <div class="d-flex gap-2 flex-wrap">
    <a class="ks-btn ks-btn-primary ks-btn-sm" href="produk_tambah.php">+ Tambah Produk</a>
  </div>
</div>

<?php if ($errorTabel !== ''): ?>
  <div class="ks-alert ks-alert-danger mb-3">
    <span class="ks-alert-icon">⚠️</span>
    <div>
      <strong>Tabel produk belum bisa dibaca.</strong>
      <div class="ks-text-sm mt-1">Pesan MySQL: <?= htmlspecialchars($errorTabel) ?></div>
    </div>
  </div>
<?php endif; ?>

<?php if (isset($pesanStatus[$status])): ?>
  <?php $tipe = $pesanStatus[$status][0] === 'success' ? 'ks-alert-success' : 'ks-alert-danger'; ?>
  <div class="ks-alert <?= $tipe ?> mb-3">
    <span class="ks-alert-icon"><?= $pesanStatus[$status][0] === 'success' ? '✅' : '❌' ?></span>
    <span><?= htmlspecialchars($pesanStatus[$status][1]) ?></span>
  </div>
<?php endif; ?>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
  <div class="col-sm-4">
    <div class="ks-stat d-flex align-items-center gap-3">
      <div class="ks-stat-icon teal">📦</div>
      <div>
        <div class="ks-stat-label">Jumlah Produk</div>
        <div class="ks-stat-value"><?= $jumlahProduk ?></div>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="ks-stat d-flex align-items-center gap-3">
      <div class="ks-stat-icon green">📊</div>
      <div>
        <div class="ks-stat-label">Total Stok</div>
        <div class="ks-stat-value"><?= number_format($totalStok, 0, ',', '.') ?></div>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="ks-stat d-flex align-items-center gap-3">
      <div class="ks-stat-icon red">⚠️</div>
      <div>
        <div class="ks-stat-label">Stok Menipis (≤5)</div>
        <div class="ks-stat-value text-danger"><?= $stokMenipis ?></div>
      </div>
    </div>
  </div>
</div>

<!-- Search -->
<div class="ks-card mb-4">
  <div class="ks-card-body">
    <form method="get" action="produk.php" class="ks-search-wrap">
      <input class="ks-input ks-search-input" type="text" name="cari"
             value="<?= htmlspecialchars($cari) ?>"
             placeholder="🔍  Cari kode atau nama produk...">
      <button class="ks-btn ks-btn-primary" type="submit">Cari</button>
      <?php if ($cari !== ''): ?>
        <a class="ks-btn ks-btn-ghost" href="produk.php">Reset</a>
      <?php endif; ?>
    </form>
    <?php if ($cari !== ''): ?>
      <p class="ks-text-sm ks-text-muted mt-2 mb-0">
        Hasil untuk: <strong><?= htmlspecialchars($cari) ?></strong>
      </p>
    <?php endif; ?>
  </div>
</div>

<!-- Tabel Produk -->
<div class="ks-card">
  <div class="ks-card-header">
    <span>Daftar Produk</span>
    <span class="ks-badge ks-badge-neutral"><?= $jumlahProduk ?> produk</span>
  </div>
  <div class="ks-table-wrap">
    <table class="ks-table">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Nama Produk</th>
          <th class="text-end">Harga Beli</th>
          <th class="text-end">Harga Jual</th>
          <th class="text-end">Stok</th>
          <th>Status</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($jumlahProduk === 0): ?>
          <tr>
            <td colspan="7" class="text-center py-5 ks-text-muted">
              <?= $cari !== '' ? '🔍 Tidak ada produk yang cocok.' : '📭 Belum ada produk.' ?>
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($daftarProduk as $produk): ?>
            <tr>
              <td><code><?= htmlspecialchars($produk['kode_produk']) ?></code></td>
              <td><?= htmlspecialchars($produk['nama_produk']) ?></td>
              <td class="text-end">Rp <?= number_format((float) $produk['harga_beli'], 0, ',', '.') ?></td>
              <td class="text-end">Rp <?= number_format((float) $produk['harga_jual'], 0, ',', '.') ?></td>
              <td class="text-end"><?= (int) $produk['stok_awal'] ?></td>
              <td>
                <?php if ((int) $produk['stok_awal'] <= 5): ?>
                  <span class="ks-badge ks-badge-danger">Menipis</span>
                <?php else: ?>
                  <span class="ks-badge ks-badge-success">Aman</span>
                <?php endif; ?>
              </td>
              <td class="text-end">
                <a class="ks-btn ks-btn-ghost ks-btn-sm"
                   href="produk_edit.php?kode=<?= urlencode($produk['kode_produk']) ?>">✏️ Edit</a>
                <a class="ks-btn ks-btn-outline-danger ks-btn-sm"
                   href="produk_hapus.php?kode=<?= urlencode($produk['kode_produk']) ?>">🗑️ Hapus</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
