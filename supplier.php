<?php
require __DIR__ . '/config/database.php';

$cari = trim($_GET['cari'] ?? '');
$errorTabel = '';

if ($cari !== '') {
    $stmt = mysqli_prepare(
        $koneksi,
        'SELECT id_supplier, nama_supplier, kota
         FROM supplier
         WHERE nama_supplier LIKE ? OR kota LIKE ?
         ORDER BY id_supplier'
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
        'SELECT id_supplier, nama_supplier, kota
         FROM supplier
         ORDER BY id_supplier'
    );

    if (!$hasil) {
        $errorTabel = mysqli_error($koneksi);
    }
}

$daftarSupplier = [];
if ($hasil) {
    while ($baris = mysqli_fetch_assoc($hasil)) {
        $daftarSupplier[] = $baris;
    }
}

$jumlahSupplier = count($daftarSupplier);

$pesanStatus = [
    'tambah' => ['success', 'Supplier baru berhasil ditambahkan.'],
    'edit'   => ['success', 'Perubahan supplier berhasil disimpan.'],
    'hapus'  => ['success', 'Supplier berhasil dihapus.'],
];
$status = $_GET['status'] ?? '';

$judul = 'Daftar Supplier';
$halaman = 'supplier';
require __DIR__ . '/partials/header.php';
?>

<div class="ks-page-header mb-4">
  <div class="ks-page-header-left">
    <span class="ks-badge ks-badge-neutral mb-2">Master Data</span>
    <h1 class="ks-page-title">Daftar Supplier</h1>
    <p class="ks-page-subtitle">Mitra pemasok Koperasi Merah Hitam</p>
  </div>
  <div class="d-flex gap-2">
    <a class="ks-btn ks-btn-primary" href="supplier_tambah.php">+ Tambah Supplier</a>
  </div>
</div>

<?php if ($errorTabel !== ''): ?>
  <div class="ks-alert ks-alert-danger mb-3">
    <span class="ks-alert-icon">⚠️</span>
    <div>
      <strong>Tabel supplier belum bisa dibaca.</strong>
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

<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="ks-stat d-flex align-items-center gap-3">
      <div class="ks-stat-icon teal">🏭</div>
      <div>
        <div class="ks-stat-label">Total Supplier</div>
        <div class="ks-stat-value"><?= $jumlahSupplier ?></div>
      </div>
    </div>
  </div>
</div>

<div class="ks-card mb-4">
  <div class="ks-card-body">
    <form method="get" action="supplier.php" class="ks-search-wrap mb-3">
      <input class="ks-input ks-search-input" type="text" name="cari"
             placeholder="🔍  Cari nama supplier atau kota..."
             value="<?= htmlspecialchars($cari) ?>">
      <button class="ks-btn ks-btn-primary" type="submit">Cari</button>
      <?php if ($cari !== ''): ?>
        <a class="ks-btn ks-btn-ghost" href="supplier.php">Reset</a>
      <?php endif; ?>
    </form>
  </div>

  <div class="ks-table-wrap">
    <table class="ks-table">
      <thead>
        <tr>
          <th style="width: 80px;">ID</th>
          <th>Nama Supplier</th>
          <th>Kota</th>
          <th class="text-end" style="width: 180px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($jumlahSupplier === 0): ?>
          <tr>
            <td colspan="4" class="text-center ks-text-muted py-4">
              <?= $cari !== '' ? 'Tidak ada supplier yang cocok dengan kata kunci pencarian.' : 'Belum ada data supplier.' ?>
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($daftarSupplier as $s): ?>
            <tr>
              <td><?= (int) $s['id_supplier'] ?></td>
              <td class="fw-semibold"><?= htmlspecialchars($s['nama_supplier']) ?></td>
              <td><?= $s['kota'] !== null && $s['kota'] !== '' ? htmlspecialchars($s['kota']) : '<span class="ks-text-muted">-</span>' ?></td>
              <td class="text-end">
                <a class="ks-btn ks-btn-ghost ks-btn-sm" href="supplier_edit.php?id_supplier=<?= (int) $s['id_supplier'] ?>">Edit</a>
                <a class="ks-btn ks-btn-outline-danger ks-btn-sm" href="supplier_hapus.php?id_supplier=<?= (int) $s['id_supplier'] ?>">Hapus</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
