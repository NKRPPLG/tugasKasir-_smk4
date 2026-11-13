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

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <div>
    <span class="badge text-bg-success mb-2">Barang Masuk</span>
    <h1 class="h3 mb-1">Daftar Pembelian</h1>
    <p class="text-secondary mb-0">
      Nota pembelian dibaca dari tabel <code>pembelian</code> dan
      <code>detail_pembelian</code>. Total dihitung dari detail.
    </p>
  </div>
  <div class="d-flex gap-2">
    <a class="btn btn-primary" href="pembelian_tambah.php">Tambah Pembelian</a>
    <a class="btn btn-outline-secondary" href="panduan.php#alur-pembelian">Panduan</a>
  </div>
</div>

<?php if ($errorTabel !== ''): ?>
  <div class="alert alert-danger">
    <strong>Tabel pembelian belum bisa dibaca.</strong>
    <div class="small mt-1">Pesan MySQL: <?= htmlspecialchars($errorTabel) ?></div>
  </div>
<?php endif; ?>

<?php if (($_GET['status'] ?? '') === 'tambah'): ?>
  <div class="alert alert-success">Pembelian baru berhasil disimpan.</div>
<?php endif; ?>

<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="text-secondary small">Jumlah Nota</div>
        <div class="fs-3 fw-bold"><?= $jumlahNota ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="text-secondary small">Total Nilai</div>
        <div class="fs-4 fw-bold text-primary"><?= rupiah($totalNilai) ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="text-secondary small">Baris Barang</div>
        <div class="fs-3 fw-bold"><?= $totalItem ?></div>
      </div>
    </div>
  </div>
</div>

<div class="card mb-4">
  <div class="card-body">
    <form class="row g-2 mb-3" method="get" action="pembelian.php">
      <div class="col-md-6">
        <input class="form-control" type="text" name="cari"
               value="<?= htmlspecialchars($cari) ?>"
               placeholder="Cari nomor nota, kasir, atau supplier...">
      </div>
      <div class="col-auto">
        <button class="btn btn-primary" type="submit">Cari</button>
      </div>
      <?php if ($cari !== ''): ?>
        <div class="col-auto">
          <a class="btn btn-outline-secondary" href="pembelian.php">Reset</a>
        </div>
      <?php endif; ?>
    </form>

    <?php if ($cari !== ''): ?>
      <p class="text-secondary small">
        Hasil pencarian untuk: <strong><?= htmlspecialchars($cari) ?></strong>
      </p>
    <?php endif; ?>

    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
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
              <td colspan="7" class="text-center text-secondary py-4">
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
                  <a class="btn btn-sm btn-outline-primary"
                     href="pembelian_detail.php?no=<?= urlencode($nota['no_pembelian']) ?>">Detail</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="alert alert-info mb-0">
  <strong>Latihan:</strong> buka salah satu detail pembelian, lalu cocokkan
  total nota dengan <code>SUM(jumlah * harga_beli)</code> di phpMyAdmin.
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
