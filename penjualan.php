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

<div class="ks-page-header mb-4">
  <div class="ks-page-header-left">
    <span class="ks-badge ks-badge-neutral mb-2">Barang Keluar</span>
    <h1 class="ks-page-title">Daftar Penjualan</h1>
    <p class="ks-page-subtitle">
      Riwayat transaksi kasir, metode pembayaran, dan rincian omzet penjualan.
    </p>
  </div>
  <div class="d-flex gap-2">
    <a class="ks-btn ks-btn-primary" href="penjualan_tambah.php">+ Tambah Penjualan</a>
  </div>
</div>

<?php if ($errorTabel !== ''): ?>
  <div class="ks-alert ks-alert-danger mb-3">
    <span class="ks-alert-icon">⚠️</span>
    <div>
      <strong>Tabel penjualan belum bisa dibaca.</strong>
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

<!-- Kartu Statistik Penjualan -->
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="ks-stat d-flex align-items-center gap-3">
      <div class="ks-stat-icon teal">🧾</div>
      <div>
        <div class="ks-stat-label">Total Nota Penjualan</div>
        <div class="ks-stat-value"><?= $jumlahNota ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="ks-stat d-flex align-items-center gap-3">
      <div class="ks-stat-icon green">📦</div>
      <div>
        <div class="ks-stat-label">Total Item Terjual</div>
        <div class="ks-stat-value"><?= number_format($totalItem, 0, ',', '.') ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="ks-stat d-flex align-items-center gap-3">
      <div class="ks-stat-icon red">💰</div>
      <div>
        <div class="ks-stat-label">Total Omzet Penjualan</div>
        <div class="ks-stat-value"><?= rupiah($totalNilai) ?></div>
      </div>
    </div>
  </div>
</div>

<!-- Tabel Daftar Penjualan -->
<div class="ks-card mb-4">
  <div class="ks-card-body">
    <form method="get" action="penjualan.php" class="ks-search-wrap mb-3">
      <input class="ks-input ks-search-input" type="text" name="cari"
             placeholder="🔍  Cari nomor nota (PJ-...), kasir, atau metode bayar..."
             value="<?= htmlspecialchars($cari) ?>">
      <button class="ks-btn ks-btn-primary" type="submit">Cari</button>
      <?php if ($cari !== ''): ?>
        <a class="ks-btn ks-btn-ghost" href="penjualan.php">Reset</a>
      <?php endif; ?>
    </form>
  </div>

  <div class="ks-table-wrap">
    <table class="ks-table">
      <thead>
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
            <td colspan="7" class="text-center ks-text-muted py-4">
              <?= $cari !== '' ? 'Tidak ada nota penjualan yang cocok dengan kata kunci pencarian.' : 'Belum ada data transaksi penjualan.' ?>
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($daftarPenjualan as $pj): ?>
            <tr>
              <td>
                <span class="ks-badge ks-badge-brand" style="font-family:monospace; font-size: 0.825rem;">
                  <?= htmlspecialchars($pj['no_penjualan']) ?>
                </span>
              </td>
              <td><?= htmlspecialchars($pj['tanggal']) ?></td>
              <td class="fw-semibold">
                <?= $pj['nama_kasir'] ? htmlspecialchars($pj['nama_kasir']) : '<span class="ks-text-muted">(Kasir dihapus)</span>' ?>
              </td>
              <td>
                <?php
                $metode = $pj['metode_bayar'] ?? 'Tunai';
                $badgeClass = 'ks-badge-neutral';
                if ($metode === 'Tunai') $badgeClass = 'ks-badge-success';
                elseif ($metode === 'QRIS') $badgeClass = 'ks-badge-warning';
                elseif ($metode === 'Debit') $badgeClass = 'ks-badge-brand';
                ?>
                <span class="ks-badge <?= $badgeClass ?>">
                  <?= htmlspecialchars($metode) ?>
                </span>
              </td>
              <td class="text-center"><?= (int) $pj['jumlah_item'] ?></td>
              <td class="text-end fw-bold">
                <?= rupiah($pj['total']) ?>
              </td>
              <td class="text-end">
                <a class="ks-btn ks-btn-ghost ks-btn-sm"
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

<?php require __DIR__ . '/partials/footer.php'; ?>
