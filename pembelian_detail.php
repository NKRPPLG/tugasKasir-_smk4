<?php
// ============================================================
// kasirsmk/pembelian_detail.php
// READ: detail satu nota pembelian + dampak ke stok.
// ============================================================
require __DIR__ . '/config/database.php';
require __DIR__ . '/transaksi_helper.php';

$noPembelian = trim($_GET['no'] ?? '');
$error = [];
$nota = null;
$detail = [];
$mutasiStok = [];

if ($noPembelian === '') {
    $error[] = 'Nomor pembelian tidak dikirim.';
} else {
    $stmt = mysqli_prepare(
        $koneksi,
        'SELECT p.no_pembelian, p.tanggal, p.id_kasir, p.id_supplier,
                k.nama_kasir, s.nama_supplier, s.kota
         FROM pembelian p
         LEFT JOIN kasir k ON k.id_kasir = p.id_kasir
         LEFT JOIN supplier s ON s.id_supplier = p.id_supplier
         WHERE p.no_pembelian = ?'
    );

    if (!$stmt) {
        $error[] = 'Tabel pembelian belum siap: ' . mysqli_error($koneksi);
    } else {
        mysqli_stmt_bind_param($stmt, 's', $noPembelian);
        mysqli_stmt_execute($stmt);
        $hasil = mysqli_stmt_get_result($stmt);
        $nota = mysqli_fetch_assoc($hasil);
        mysqli_stmt_close($stmt);

        if (!$nota) {
            $error[] = 'Pembelian dengan nomor ' . $noPembelian . ' tidak ditemukan.';
        }
    }
}

if ($nota) {
    $stmt = mysqli_prepare(
        $koneksi,
        'SELECT id_detail, kode_produk, nama_produk, jumlah, harga_beli
         FROM detail_pembelian
         WHERE no_pembelian = ?
         ORDER BY id_detail'
    );

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $noPembelian);
        mysqli_stmt_execute($stmt);
        $hasil = mysqli_stmt_get_result($stmt);

        while ($baris = mysqli_fetch_assoc($hasil)) {
            $detail[] = $baris;
        }

        mysqli_stmt_close($stmt);
    }

    $stmt = mysqli_prepare(
        $koneksi,
        'SELECT tanggal, kode_produk, jumlah_masuk, saldo_awal, saldo_akhir
         FROM stok
         WHERE no_pembelian = ?
         ORDER BY id_stok'
    );

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $noPembelian);
        mysqli_stmt_execute($stmt);
        $hasil = mysqli_stmt_get_result($stmt);

        while ($baris = mysqli_fetch_assoc($hasil)) {
            $mutasiStok[] = $baris;
        }

        mysqli_stmt_close($stmt);
    }
}

$total = 0;
$totalQty = 0;
foreach ($detail as $baris) {
    $total += (float) $baris['jumlah'] * (float) $baris['harga_beli'];
    $totalQty += (int) $baris['jumlah'];
}

$judul = 'Detail Pembelian';
$halaman = 'pembelian';
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <div>
    <span class="badge text-bg-success mb-2">DETAIL</span>
    <h1 class="h3 mb-1">Nota Pembelian</h1>
    <p class="text-secondary mb-0">Data kepala nota, isi nota, dan mutasi stok.</p>
  </div>
  <a class="btn btn-outline-secondary" href="pembelian.php">Kembali</a>
</div>

<?php if (count($error) > 0): ?>
  <div class="alert alert-danger">
    <ul class="mb-0">
      <?php foreach ($error as $pesan): ?>
        <li><?= htmlspecialchars($pesan) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php else: ?>
  <?php if (($_GET['status'] ?? '') === 'tambah'): ?>
    <div class="alert alert-success">
      Pembelian berhasil disimpan dan stok sudah diperbarui.
    </div>
  <?php endif; ?>

  <div class="card mb-4">
    <div class="card-body">
      <div class="d-flex flex-wrap justify-content-between gap-2 border-bottom pb-3 mb-3">
        <div>
          <h2 class="h4 mb-1"><?= htmlspecialchars($nota['no_pembelian']) ?></h2>
          <div class="text-secondary small">
            <?= htmlspecialchars($nota['tanggal']) ?> &middot;
            Supplier: <?= htmlspecialchars($nota['nama_supplier'] ?? '-') ?> &middot;
            Kasir: <?= htmlspecialchars($nota['nama_kasir'] ?? '-') ?>
          </div>
        </div>
        <div class="text-end">
          <div class="text-secondary small">Total Nota</div>
          <div class="fs-4 fw-bold text-primary"><?= rupiah($total) ?></div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-sm align-middle">
          <thead class="table-light">
            <tr>
              <th>Kode</th>
              <th>Nama Produk</th>
              <th class="text-end">Jumlah</th>
              <th class="text-end">Harga Beli</th>
              <th class="text-end">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($detail as $baris): ?>
              <tr>
                <td><code><?= htmlspecialchars($baris['kode_produk']) ?></code></td>
                <td><?= htmlspecialchars($baris['nama_produk']) ?></td>
                <td class="text-end"><?= (int) $baris['jumlah'] ?></td>
                <td class="text-end"><?= rupiah($baris['harga_beli']) ?></td>
                <td class="text-end"><?= rupiah((float) $baris['jumlah'] * (float) $baris['harga_beli']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="text-end text-secondary">
        Total <?= (int) $totalQty ?> barang
      </div>
    </div>
  </div>

  <div class="card mb-4">
    <div class="card-header bg-white fw-semibold">Dampak ke Stok</div>
    <div class="card-body">
      <p class="text-secondary small">
        Baris di bawah berasal dari tabel <code>stok</code> dengan
        <code>no_pembelian = <?= htmlspecialchars($noPembelian) ?></code>.
      </p>

      <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Tanggal</th>
              <th>Kode Produk</th>
              <th class="text-end">Masuk</th>
              <th class="text-end">Saldo Awal</th>
              <th class="text-end">Saldo Akhir</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($mutasiStok) === 0): ?>
              <tr>
                <td colspan="5" class="text-center text-secondary py-4">
                  Belum ada mutasi stok untuk nota ini.
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($mutasiStok as $stok): ?>
                <tr>
                  <td><?= htmlspecialchars($stok['tanggal']) ?></td>
                  <td><code><?= htmlspecialchars($stok['kode_produk']) ?></code></td>
                  <td class="text-end text-success">+<?= (int) $stok['jumlah_masuk'] ?></td>
                  <td class="text-end"><?= (int) $stok['saldo_awal'] ?></td>
                  <td class="text-end fw-semibold"><?= (int) $stok['saldo_akhir'] ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="d-flex flex-wrap gap-2">
    <a class="btn btn-primary" href="pembelian_tambah.php">Pembelian Lagi</a>
    <a class="btn btn-outline-secondary" href="pembelian.php">Daftar Pembelian</a>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/partials/footer.php'; ?>
