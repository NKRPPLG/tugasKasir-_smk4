<?php
// ============================================================
// kasirsmk/pembelian.php
// READ: daftar nota pembelian (barang masuk).
// ============================================================
require __DIR__ . '/config/database.php';
require __DIR__ . '/transaksi_helper.php';

$cari = trim($_GET['cari'] ?? '');
$errorTabel = '';

$sqlDasar = "SELECT p.no_pembelian, p.tanggal, p.id_kasir, p.id_supplier,
                    k.nama_kasir, s.nama_supplier,
                    COALESCE(SUM(d.jumlah * d.harga_beli), 0) AS total,
                    COUNT(d.id_detail) AS jumlah_item
             FROM pembelian p
             LEFT JOIN kasir k ON k.id_kasir = p.id_kasir
             LEFT JOIN supplier s ON s.id_supplier = p.id_supplier
             LEFT JOIN detail_pembelian d ON d.no_pembelian = p.no_pembelian";

if ($cari !== '') {
    $sql = $sqlDasar . "
            WHERE p.no_pembelian LIKE ?
               OR k.nama_kasir LIKE ?
               OR s.nama_supplier LIKE ?
            GROUP BY p.no_pembelian, p.tanggal, p.id_kasir, p.id_supplier,
                     k.nama_kasir, s.nama_supplier
            ORDER BY p.tanggal DESC, p.no_pembelian DESC";
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
            GROUP BY p.no_pembelian, p.tanggal, p.id_kasir, p.id_supplier,
                     k.nama_kasir, s.nama_supplier
            ORDER BY p.tanggal DESC, p.no_pembelian DESC";
    $hasil = mysqli_query($koneksi, $sql);

    if (!$hasil) {
        $errorTabel = mysqli_error($koneksi);
    }
}

$daftarPembelian = [];

if ($hasil) {
    while ($baris = mysqli_fetch_assoc($hasil)) {
        $daftarPembelian[] = $baris;
    }
}

$jumlahNota = count($daftarPembelian);
$totalNilai = 0;
$totalItem = 0;

foreach ($daftarPembelian as $nota) {
    $totalNilai += (float) $nota['total'];
    $totalItem += (int) $nota['jumlah_item'];
}

$judul = 'Daftar Pembelian';
$halaman = 'pembelian';
require __DIR__ . '/partials/header.php';
?>

<div class="ks-page-header mb-4">
  <div class="ks-page-header-left">
    <span class="ks-badge ks-badge-neutral mb-2">Barang Masuk</span>
    <h1 class="ks-page-title">Daftar Pembelian</h1>
    <p class="ks-page-subtitle">Riwayat transaksi barang masuk Koperasi Merah Hitam</p>
  </div>
  <div class="d-flex gap-2">
    <a class="ks-btn ks-btn-primary" href="pembelian_tambah.php">Tambah Pembelian</a>
  </div>
</div>

<?php if ($errorTabel !== ''): ?>
  <div class="ks-alert ks-alert-danger mb-3">
    <span class="ks-alert-icon">⚠️</span>
    <div>
      <strong>Tabel pembelian belum bisa dibaca.</strong>
      <div class="ks-text-sm mt-1">Pesan MySQL: <?= htmlspecialchars($errorTabel) ?></div>
    </div>
  </div>
<?php endif; ?>

<?php if (($_GET['status'] ?? '') === 'tambah'): ?>
  <div class="ks-alert ks-alert-success mb-3">
    <span class="ks-alert-icon">✅</span>
    <span>Pembelian baru berhasil disimpan.</span>
  </div>
<?php endif; ?>

<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="ks-stat d-flex align-items-center gap-3">
      <div class="ks-stat-icon teal">🧾</div>
      <div>
        <div class="ks-stat-label">Jumlah Nota</div>
        <div class="ks-stat-value"><?= $jumlahNota ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="ks-stat d-flex align-items-center gap-3">
      <div class="ks-stat-icon green">💰</div>
      <div>
        <div class="ks-stat-label">Total Nilai</div>
        <div class="ks-stat-value"><?= rupiah($totalNilai) ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="ks-stat d-flex align-items-center gap-3">
      <div class="ks-stat-icon red">📦</div>
      <div>
        <div class="ks-stat-label">Baris Barang</div>
        <div class="ks-stat-value"><?= $totalItem ?></div>
      </div>
    </div>
  </div>
</div>

<div class="ks-card mb-4">
  <div class="ks-card-body">
    <form class="ks-search-wrap mb-3" method="get" action="pembelian.php">
      <input class="ks-input ks-search-input" type="text" name="cari"
             value="<?= htmlspecialchars($cari) ?>"
             placeholder="🔍  Cari nomor nota, kasir, atau supplier...">
      <button class="ks-btn ks-btn-primary" type="submit">Cari</button>
      <?php if ($cari !== ''): ?>
        <a class="ks-btn ks-btn-ghost" href="pembelian.php">Reset</a>
      <?php endif; ?>
    </form>

    <?php if ($cari !== ''): ?>
      <p class="ks-text-sm ks-text-muted mb-3">
        Hasil pencarian untuk: <strong><?= htmlspecialchars($cari) ?></strong>
      </p>
    <?php endif; ?>
  </div>

  <div class="ks-table-wrap">
    <table class="ks-table">
      <thead>
        <tr>
          <th>No. Pembelian</th>
          <th>Tanggal</th>
          <th>Supplier</th>
          <th>Kasir</th>
          <th class="text-end">Item</th>
          <th class="text-end">Total</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($jumlahNota === 0): ?>
          <tr>
            <td colspan="7" class="text-center ks-text-muted py-4">
              <?= $cari !== '' ? 'Tidak ada pembelian yang cocok.' : 'Belum ada pembelian. Klik "Tambah Pembelian".' ?>
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($daftarPembelian as $nota): ?>
            <tr>
              <td><code><?= htmlspecialchars($nota['no_pembelian']) ?></code></td>
              <td><?= htmlspecialchars($nota['tanggal']) ?></td>
              <td><?= htmlspecialchars($nota['nama_supplier'] ?? '-') ?></td>
              <td><?= htmlspecialchars($nota['nama_kasir'] ?? '-') ?></td>
              <td class="text-end"><?= (int) $nota['jumlah_item'] ?></td>
              <td class="text-end"><?= rupiah($nota['total']) ?></td>
              <td class="text-end">
                <a class="ks-btn ks-btn-ghost ks-btn-sm"
                   href="pembelian_detail.php?no=<?= urlencode($nota['no_pembelian']) ?>">Detail</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
