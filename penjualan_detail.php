<?php
// ============================================================
// kasirsmk/penjualan_detail.php
// READ: detail satu nota penjualan + dampak mutasi stok keluar.
// ============================================================
require __DIR__ . '/config/database.php';
require __DIR__ . '/transaksi_helper.php';

$noPenjualan = trim($_GET['no'] ?? '');
$error = [];
$nota = null;
$detail = [];
$mutasiStok = [];

if ($noPenjualan === '') {
    $error[] = 'Nomor penjualan tidak dikirim. Silakan pilih nota dari daftar.';
} else {
    $stmt = mysqli_prepare(
        $koneksi,
        'SELECT pj.no_penjualan, pj.tanggal, pj.id_kasir, pj.metode_bayar,
                k.nama_kasir
         FROM penjualan pj
         LEFT JOIN kasir k ON k.id_kasir = pj.id_kasir
         WHERE pj.no_penjualan = ?'
    );

    if (!$stmt) {
        $error[] = 'Tabel penjualan belum siap: ' . mysqli_error($koneksi);
    } else {
        mysqli_stmt_bind_param($stmt, 's', $noPenjualan);
        mysqli_stmt_execute($stmt);
        $hasil = mysqli_stmt_get_result($stmt);
        $nota = mysqli_fetch_assoc($hasil);
        mysqli_stmt_close($stmt);

        if (!$nota) {
            $error[] = 'Nota penjualan dengan nomor ' . htmlspecialchars($noPenjualan) . ' tidak ditemukan.';
        }
    }
}

if ($nota) {
    // Ambil rincian barang dari detail_penjualan
    $stmt = mysqli_prepare(
        $koneksi,
        'SELECT id_detail, kode_produk, nama_produk, jumlah, harga_satuan
         FROM detail_penjualan
         WHERE no_penjualan = ?
         ORDER BY id_detail'
    );

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $noPenjualan);
        mysqli_stmt_execute($stmt);
        $hasil = mysqli_stmt_get_result($stmt);

        while ($baris = mysqli_fetch_assoc($hasil)) {
            $detail[] = $baris;
        }

        mysqli_stmt_close($stmt);
    }

    // Ambil data mutasi stok keluar dari tabel stok
    $stmt = mysqli_prepare(
        $koneksi,
        'SELECT tanggal, kode_produk, jumlah_keluar, saldo_awal, saldo_akhir
         FROM stok
         WHERE no_penjualan = ?
         ORDER BY id_stok'
    );

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $noPenjualan);
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
    $total += (float) $baris['jumlah'] * (float) $baris['harga_satuan'];
    $totalQty += (int) $baris['jumlah'];
}

$judul = 'Detail Nota ' . ($nota['no_penjualan'] ?? '');
$halaman = 'penjualan';
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <div>
    <span class="badge text-bg-success mb-2">DETAIL TRANSAKSI</span>
    <h1 class="h3 mb-1">Nota Penjualan</h1>
    <p class="text-secondary mb-0">Rincian belanja barang keluar &middot; Toko Maju Jaya</p>
  </div>
  <div class="d-flex gap-2 no-print">
    <button class="btn btn-outline-secondary" type="button" onclick="window.print()">Cetak Nota</button>
    <a class="btn btn-primary" href="penjualan_tambah.php">+ Transaksi Baru</a>
    <a class="btn btn-outline-primary" href="penjualan.php">Daftar Penjualan</a>
  </div>
</div>

<?php if (count($error) > 0): ?>
  <div class="alert alert-danger">
    <strong>Nota tidak dapat dimuat:</strong>
    <ul class="mb-0 mt-2">
      <?php foreach ($error as $pesan): ?>
        <li><?= htmlspecialchars($pesan) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<?php if (($_GET['status'] ?? '') === 'tambah'): ?>
  <div class="alert alert-success alert-dismissible fade show no-print" role="alert">
    <strong>Transaksi Berhasil!</strong> Nota penjualan telah disimpan dan saldo stok barang otomatis berkurang.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if ($nota): ?>
  <!-- Kartu Nota Penjualan -->
  <div class="card mb-4">
    <div class="card-body p-4">
      <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 border-bottom pb-4 mb-4">
        <div>
          <span class="text-secondary small text-uppercase fw-semibold">Nomor Nota</span>
          <h2 class="h3 mb-1 text-primary font-monospace fw-bold">
            <?= htmlspecialchars($nota['no_penjualan']) ?>
          </h2>
          <div class="text-secondary small mt-1">
            <span>Tanggal: <strong><?= htmlspecialchars($nota['tanggal']) ?></strong></span>
            <span class="mx-2">&bull;</span>
            <span>Kasir: <strong><?= htmlspecialchars($nota['nama_kasir'] ?? 'Kasir') ?></strong></span>
          </div>
        </div>
        <div class="text-end">
          <span class="text-secondary small text-uppercase fw-semibold">Metode Pembayaran</span>
          <div>
            <?php
            $metode = $nota['metode_bayar'] ?? 'Tunai';
            $badgeColor = 'text-bg-secondary';
            if ($metode === 'Tunai') $badgeColor = 'text-bg-success';
            elseif ($metode === 'QRIS') $badgeColor = 'text-bg-warning';
            elseif ($metode === 'Debit') $badgeColor = 'text-bg-primary';
            ?>
            <span class="badge <?= $badgeColor ?> fs-6 mt-1 px-3 py-2">
              <?= htmlspecialchars($metode) ?>
            </span>
          </div>
        </div>
      </div>

      <!-- Tabel Rincian Barang -->
      <h3 class="h6 text-uppercase fw-bold text-secondary mb-3">Item Pembelian</h3>
      <div class="table-responsive mb-4">
        <table class="table align-middle">
          <thead class="table-light">
            <tr>
              <th style="width: 15%;">Kode</th>
              <th>Nama Produk</th>
              <th style="width: 15%;" class="text-center">Jumlah</th>
              <th style="width: 20%;" class="text-end">Harga Satuan</th>
              <th style="width: 20%;" class="text-end">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($detail as $item): ?>
              <?php $subtotal = (float) $item['jumlah'] * (float) $item['harga_satuan']; ?>
              <tr>
                <td>
                  <span class="badge text-bg-secondary font-monospace">
                    <?= htmlspecialchars($item['kode_produk']) ?>
                  </span>
                </td>
                <td class="fw-semibold"><?= htmlspecialchars($item['nama_produk']) ?></td>
                <td class="text-center"><?= (int) $item['jumlah'] ?></td>
                <td class="text-end"><?= rupiah($item['harga_satuan']) ?></td>
                <td class="text-end fw-bold"><?= rupiah($subtotal) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot class="table-light">
            <tr>
              <td colspan="2" class="fw-bold">Total Barang Terjual</td>
              <td class="text-center fw-bold"><?= number_format($totalQty, 0, ',', '.') ?></td>
              <td class="text-end fw-bold">Total Nilai Nota</td>
              <td class="text-end fs-5 fw-bold text-primary font-monospace"><?= rupiah($total) ?></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>

  <!-- Kartu Mutasi Pengurangan Stok -->
  <div class="card mb-4">
    <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
      <span>Dampak ke Saldo Stok (Barang Keluar)</span>
      <span class="badge text-bg-secondary"><?= count($mutasiStok) ?> Baris Mutasi</span>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Tanggal</th>
              <th>Kode Produk</th>
              <th class="text-center">Jumlah Keluar</th>
              <th class="text-end">Saldo Awal</th>
              <th class="text-end">Saldo Akhir</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($mutasiStok) === 0): ?>
              <tr>
                <td colspan="5" class="text-center text-secondary py-3">Tidak ada data mutasi stok untuk nota ini.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($mutasiStok as $stok): ?>
                <tr>
                  <td><?= htmlspecialchars($stok['tanggal']) ?></td>
                  <td>
                    <span class="badge text-bg-secondary font-monospace">
                      <?= htmlspecialchars($stok['kode_produk']) ?>
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="badge text-bg-danger">-<?= (int) $stok['jumlah_keluar'] ?></span>
                  </td>
                  <td class="text-end text-secondary"><?= (int) $stok['saldo_awal'] ?></td>
                  <td class="text-end fw-bold text-success"><?= (int) $stok['saldo_akhir'] ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/partials/footer.php'; ?>
