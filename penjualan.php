<?php
// ============================================================
// kasirsmk/penjualan.php
// READ: daftar riwayat nota penjualan (barang keluar).
// ============================================================
require __DIR__ . '/config/database.php';
require __DIR__ . '/transaksi_helper.php';

$cari = trim($_GET['cari'] ?? '');
$errorTabel = '';

$sqlDasar = "SELECT pj.no_penjualan, pj.tanggal, pj.id_kasir, pj.metode_bayar,
                    k.nama_kasir,
                    COALESCE(SUM(d.jumlah * d.harga_satuan), 0) AS total,
                    COUNT(d.id_detail) AS jumlah_item
             FROM penjualan pj
             LEFT JOIN kasir k ON k.id_kasir = pj.id_kasir
             LEFT JOIN detail_penjualan d ON d.no_penjualan = pj.no_penjualan";

if ($cari !== '') {
    $sql = $sqlDasar . "
            WHERE pj.no_penjualan LIKE ?
               OR k.nama_kasir LIKE ?
               OR pj.metode_bayar LIKE ?
            GROUP BY pj.no_penjualan, pj.tanggal, pj.id_kasir, pj.metode_bayar, k.nama_kasir
            ORDER BY pj.tanggal DESC, pj.no_penjualan DESC";
    $stmt = mysqli_prepare($koneksi, $sql);

    if (!$stmt) {
        $errorTabel = mysqli_error($koneksi);
        $hasil = false;
    } else {
        $kataKunci = '%' . $cari . '%';
        mysqli_stmt_bind_param($stmt, 'sss', $kataKunci, $kataKunci, $kataKunci);
        mysqli_stmt_execute($stmt);
        $hasil = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
    }
} else {
    $sql = $sqlDasar . "
            GROUP BY pj.no_penjualan, pj.tanggal, pj.id_kasir, pj.metode_bayar, k.nama_kasir
            ORDER BY pj.tanggal DESC, pj.no_penjualan DESC";
    $hasil = mysqli_query($koneksi, $sql);

    if (!$hasil) {
        $errorTabel = mysqli_error($koneksi);
    }
}

$daftarPenjualan = [];
if ($hasil) {
    while ($baris = mysqli_fetch_assoc($hasil)) {
        $daftarPenjualan[] = $baris;
    }
}

$jumlahNota = count($daftarPenjualan);
$totalNilai = 0;
$totalItem = 0;

foreach ($daftarPenjualan as $nota) {
    $totalNilai += (float) $nota['total'];
    $totalItem += (int) $nota['jumlah_item'];
}

$pesanStatus = [
    'tambah' => ['success', 'Transaksi penjualan baru berhasil disimpan.'],
];
$status = $_GET['status'] ?? '';

$judul = 'Daftar Penjualan';
$halaman = 'penjualan';
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <div>
    <span class="badge text-bg-success mb-2">Barang Keluar</span>
    <h1 class="h3 mb-1">Daftar Penjualan</h1>
    <p class="text-secondary mb-0">
      Riwayat transaksi kasir, metode pembayaran, dan rincian omzet penjualan.
    </p>
  </div>
  <div class="d-flex gap-2">
    <a class="btn btn-primary" href="penjualan_tambah.php">+ Tambah Penjualan</a>
  </div>
</div>

<?php if ($errorTabel !== ''): ?>
  <div class="alert alert-danger">
    <strong>Tabel penjualan belum bisa dibaca.</strong>
    <div class="small mt-1">Pesan MySQL: <?= htmlspecialchars($errorTabel) ?></div>
  </div>
<?php endif; ?>

<?php if (isset($pesanStatus[$status])): ?>
  <div class="alert alert-<?= $pesanStatus[$status][0] ?> alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($pesanStatus[$status][1]) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<!-- Kartu Statistik Penjualan -->
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="text-secondary small">Total Nota Penjualan</div>
        <div class="fs-3 fw-bold"><?= $jumlahNota ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="text-secondary small">Total Item Terjual</div>
        <div class="fs-3 fw-bold"><?= number_format($totalItem, 0, ',', '.') ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="text-secondary small">Total Omzet Penjualan</div>
        <div class="fs-4 fw-bold text-primary"><?= rupiah($totalNilai) ?></div>
      </div>
    </div>
  </div>
</div>

<!-- Tabel Daftar Penjualan -->
<div class="card mb-4">
  <div class="card-body">
    <form method="get" action="penjualan.php" class="row g-2 align-items-center mb-3">
      <div class="col-auto flex-grow-1">
        <input class="form-control" type="text" name="cari"
               placeholder="Cari nomor nota (PJ-...), kasir, atau metode bayar..."
               value="<?= htmlspecialchars($cari) ?>">
      </div>
      <div class="col-auto">
        <button class="btn btn-outline-primary" type="submit">Cari</button>
        <?php if ($cari !== ''): ?>
          <a class="btn btn-outline-secondary" href="penjualan.php">Reset</a>
        <?php endif; ?>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>No. Nota</th>
            <th>Tanggal</th>
            <th>Kasir</th>
            <th>Metode Bayar</th>
            <th class="text-center">Item</th>
            <th class="text-end">Total Belanja</th>
            <th class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($jumlahNota === 0): ?>
            <tr>
              <td colspan="7" class="text-center text-secondary py-4">
                <?= $cari !== '' ? 'Tidak ada nota penjualan yang cocok dengan kata kunci pencarian.' : 'Belum ada data transaksi penjualan.' ?>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($daftarPenjualan as $pj): ?>
              <tr>
                <td>
                  <span class="badge text-bg-primary font-monospace" style="font-size: 0.825rem;">
                    <?= htmlspecialchars($pj['no_penjualan']) ?>
                  </span>
                </td>
                <td><?= htmlspecialchars($pj['tanggal']) ?></td>
                <td class="fw-semibold">
                  <?= $pj['nama_kasir'] ? htmlspecialchars($pj['nama_kasir']) : '<span class="text-muted">(Kasir dihapus)</span>' ?>
                </td>
                <td>
                  <?php
                  $metode = $pj['metode_bayar'] ?? 'Tunai';
                  $badgeColor = 'text-bg-secondary';
                  if ($metode === 'Tunai') $badgeColor = 'text-bg-success';
                  elseif ($metode === 'QRIS') $badgeColor = 'text-bg-warning';
                  elseif ($metode === 'Debit') $badgeColor = 'text-bg-primary';
                  ?>
                  <span class="badge <?= $badgeColor ?>">
                    <?= htmlspecialchars($metode) ?>
                  </span>
                </td>
                <td class="text-center"><?= (int) $pj['jumlah_item'] ?></td>
                <td class="text-end fw-bold text-primary">
                  <?= rupiah($pj['total']) ?>
                </td>
                <td class="text-end">
                  <a class="btn btn-sm btn-outline-primary"
                     href="penjualan_detail.php?no=<?= urlencode($pj['no_penjualan']) ?>">
                    Detail Nota
                  </a>
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
