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

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <div>
    <span class="badge text-bg-success mb-2">Master Data</span>
    <h1 class="h3 mb-1">Daftar Supplier</h1>
    <p class="text-secondary mb-0">Mitra pemasok Toko Maju Jaya &middot; database <code>db_penjualan</code></p>
  </div>
  <div class="d-flex gap-2">
    <a class="btn btn-primary" href="supplier_tambah.php">+ Tambah Supplier</a>
  </div>
</div>

<?php if ($errorTabel !== ''): ?>
  <div class="alert alert-danger">
    <strong>Tabel supplier belum bisa dibaca.</strong>
    <div class="small mt-1">Pesan MySQL: <?= htmlspecialchars($errorTabel) ?></div>
  </div>
<?php endif; ?>

<?php if (isset($pesanStatus[$status])): ?>
  <div class="alert alert-<?= $pesanStatus[$status][0] ?> alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($pesanStatus[$status][1]) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="text-secondary small">Total Supplier</div>
        <div class="fs-3 fw-bold"><?= $jumlahSupplier ?></div>
      </div>
    </div>
  </div>
</div>

<div class="card mb-4">
  <div class="card-body">
    <form method="get" action="supplier.php" class="row g-2 align-items-center mb-3">
      <div class="col-auto flex-grow-1">
        <input class="form-control" type="text" name="cari"
               placeholder="Cari nama supplier atau kota..."
               value="<?= htmlspecialchars($cari) ?>">
      </div>
      <div class="col-auto">
        <button class="btn btn-outline-primary" type="submit">Cari</button>
        <?php if ($cari !== ''): ?>
          <a class="btn btn-outline-secondary" href="supplier.php">Reset</a>
        <?php endif; ?>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
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
              <td colspan="4" class="text-center text-secondary py-4">
                <?= $cari !== '' ? 'Tidak ada supplier yang cocok dengan kata kunci pencarian.' : 'Belum ada data supplier.' ?>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($daftarSupplier as $s): ?>
              <tr>
                <td><?= (int) $s['id_supplier'] ?></td>
                <td class="fw-semibold"><?= htmlspecialchars($s['nama_supplier']) ?></td>
                <td><?= $s['kota'] !== null && $s['kota'] !== '' ? htmlspecialchars($s['kota']) : '<span class="text-secondary">-</span>' ?></td>
                <td class="text-end">
                  <a class="btn btn-sm btn-outline-primary" href="supplier_edit.php?id_supplier=<?= (int) $s['id_supplier'] ?>">Edit</a>
                  <a class="btn btn-sm btn-outline-danger" href="supplier_hapus.php?id_supplier=<?= (int) $s['id_supplier'] ?>">Hapus</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
