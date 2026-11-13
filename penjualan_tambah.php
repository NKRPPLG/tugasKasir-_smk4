<?php
// ============================================================
// kasirsmk/penjualan_tambah.php
// CREATE: form multi-baris transaksi penjualan (barang keluar).
// Dilengkapi validasi cek stok sebelum menyimpan & transaksi database.
// ============================================================
require __DIR__ . '/config/database.php';
require __DIR__ . '/transaksi_helper.php';

$error = [];
$tanggal = date('Y-m-d');
$idKasir = 0;
$metodeBayar = 'Tunai';
$items = [
    ['kode_produk' => '', 'jumlah' => '1', 'harga_satuan' => ''],
];

$daftarKasir = ambil_kasir_aktif($koneksi);
$daftarProduk = ambil_produk($koneksi);

$petaKasir = [];
foreach ($daftarKasir as $kasir) {
    $petaKasir[(int) $kasir['id_kasir']] = $kasir;
}

$petaProduk = [];
$stokProduk = [];
foreach ($daftarProduk as $produk) {
    $petaProduk[$produk['kode_produk']] = $produk;
    $stokProduk[$produk['kode_produk']] = saldo_stok_terakhir($koneksi, $produk['kode_produk']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = trim($_POST['tanggal'] ?? '');
    $idKasir = (int) ($_POST['id_kasir'] ?? 0);
    $metodeBayar = trim($_POST['metode_bayar'] ?? 'Tunai');

    $kodeArray = $_POST['kode_produk'] ?? [];
    $jumlahArray = $_POST['jumlah'] ?? [];
    $hargaArray = $_POST['harga_satuan'] ?? [];

    $items = [];
    $jumlahBaris = max(count($kodeArray), count($jumlahArray), count($hargaArray));

    for ($i = 0; $i < $jumlahBaris; $i++) {
        $kode = trim((string) ($kodeArray[$i] ?? ''));
        $jumlahInput = trim((string) ($jumlahArray[$i] ?? ''));
        $hargaInput = trim((string) ($hargaArray[$i] ?? ''));

        if ($kode === '' && $jumlahInput === '' && $hargaInput === '') {
            continue;
        }

        $items[] = [
            'kode_produk' => $kode,
            'jumlah' => $jumlahInput,
            'harga_satuan' => $hargaInput,
        ];
    }

    if (count($items) === 0) {
        $items[] = ['kode_produk' => '', 'jumlah' => '1', 'harga_satuan' => ''];
    }

    // Validasi Tanggal
    $tanggalObj = DateTime::createFromFormat('Y-m-d', $tanggal);
    if (!$tanggalObj || $tanggalObj->format('Y-m-d') !== $tanggal) {
        $error[] = 'Tanggal penjualan tidak valid.';
    }

    // Validasi Kasir
    if (!isset($petaKasir[$idKasir])) {
        $error[] = 'Kasir yang dipilih tidak ditemukan atau sudah nonaktif.';
    }

    // Validasi Metode Bayar
    if (!in_array($metodeBayar, ['Tunai', 'QRIS', 'Debit'], true)) {
        $error[] = 'Metode pembayaran harus Tunai, QRIS, atau Debit.';
    }

    // Validasi Item Barang
    $itemsValid = [];
    $kebutuhanStok = [];
    $adaBaris = false;

    foreach ($items as $index => $item) {
        $nomorBaris = $index + 1;

        if ($item['kode_produk'] === '') {
            if ($item['jumlah'] !== '' || $item['harga_satuan'] !== '') {
                $error[] = 'Baris ' . $nomorBaris . ': pilih produk terlebih dahulu.';
            }
            continue;
        }

        $adaBaris = true;

        if (!isset($petaProduk[$item['kode_produk']])) {
            $error[] = 'Baris ' . $nomorBaris . ': produk tidak ditemukan.';
            continue;
        }

        $jumlah = filter_var($item['jumlah'], FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1],
        ]);

        if ($jumlah === false) {
            $error[] = 'Baris ' . $nomorBaris . ': jumlah harus bilangan bulat minimal 1.';
            continue;
        }

        if ($item['harga_satuan'] === '' || !is_numeric($item['harga_satuan']) || (float) $item['harga_satuan'] < 0) {
            $error[] = 'Baris ' . $nomorBaris . ': harga satuan harus angka 0 atau lebih.';
            continue;
        }

        $produk = $petaProduk[$item['kode_produk']];
        $itemsValid[] = [
            'kode_produk' => $item['kode_produk'],
            'nama_produk' => $produk['nama_produk'],
            'jumlah' => (int) $jumlah,
            'harga_satuan' => (float) $item['harga_satuan'],
        ];

        // Akumulasi kebutuhan stok untuk cek stok
        $kebutuhanStok[$item['kode_produk']] = ($kebutuhanStok[$item['kode_produk']] ?? 0) + (int) $jumlah;
    }

    if (!$adaBaris) {
        $error[] = 'Isi minimal satu produk barang pada nota penjualan.';
    }

    // CEK STOK: Tolak transaksi jika barang melebihi stok yang tersedia
    foreach ($kebutuhanStok as $kodeProduk => $totalMinta) {
        $stokTersedia = saldo_stok_terakhir($koneksi, $kodeProduk);
        if ($totalMinta > $stokTersedia) {
            $namaBarang = $petaProduk[$kodeProduk]['nama_produk'] ?? $kodeProduk;
            $error[] = "Stok untuk '{$namaBarang}' tidak cukup! (Tersedia: {$stokTersedia}, Diminta: {$totalMinta}).";
        }
    }

    // Jika semua validasi lolos, simpan ke database dengan Transaksi
    if (count($error) === 0) {
        mysqli_begin_transaction($koneksi);

        try {
            $noPenjualan = buat_nomor($koneksi, 'PJ-', 'penjualan', 'no_penjualan');

            // 1. Simpan Kepala Nota Penjualan
            $stmt = mysqli_prepare(
                $koneksi,
                'INSERT INTO penjualan (no_penjualan, tanggal, id_kasir, metode_bayar)
                 VALUES (?, ?, ?, ?)'
            );

            if (!$stmt) {
                throw new Exception('Gagal menyiapkan nota penjualan: ' . mysqli_error($koneksi));
            }

            mysqli_stmt_bind_param($stmt, 'ssis', $noPenjualan, $tanggal, $idKasir, $metodeBayar);

            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception(mysqli_stmt_error($stmt));
            }

            mysqli_stmt_close($stmt);

            // 2. Simpan Detail Barang & Rekam Stok Keluar
            foreach ($itemsValid as $item) {
                // INSERT ke detail_penjualan
                $stmtDetail = mysqli_prepare(
                    $koneksi,
                    'INSERT INTO detail_penjualan
                        (no_penjualan, kode_produk, nama_produk, jumlah, harga_satuan)
                     VALUES (?, ?, ?, ?, ?)'
                );

                if (!$stmtDetail) {
                    throw new Exception('Gagal menyimpan rincian barang: ' . mysqli_error($koneksi));
                }

                mysqli_stmt_bind_param(
                    $stmtDetail,
                    'sssid',
                    $noPenjualan,
                    $item['kode_produk'],
                    $item['nama_produk'],
                    $item['jumlah'],
                    $item['harga_satuan']
                );

                if (!mysqli_stmt_execute($stmtDetail)) {
                    throw new Exception(mysqli_stmt_error($stmtDetail));
                }

                mysqli_stmt_close($stmtDetail);

                // INSERT mutasi stok keluar ke tabel stok
                $saldoAwal = saldo_stok_terakhir($koneksi, $item['kode_produk']);
                $saldoAkhir = $saldoAwal - $item['jumlah'];
                $jumlahMasuk = 0;
                $jumlahKeluar = $item['jumlah'];
                $noPembelian = null;
                $keterangan = 'Jual ke pembeli';

                $stmtStok = mysqli_prepare(
                    $koneksi,
                    'INSERT INTO stok
                        (kode_produk, tanggal, jumlah_masuk, jumlah_keluar,
                         saldo_awal, saldo_akhir, no_penjualan, no_pembelian, keterangan)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
                );

                if (!$stmtStok) {
                    throw new Exception('Gagal memperbarui stok: ' . mysqli_error($koneksi));
                }

                mysqli_stmt_bind_param(
                    $stmtStok,
                    'ssiiiisss',
                    $item['kode_produk'],
                    $tanggal,
                    $jumlahMasuk,
                    $jumlahKeluar,
                    $saldoAwal,
                    $saldoAkhir,
                    $noPenjualan,
                    $noPembelian,
                    $keterangan
                );

                if (!mysqli_stmt_execute($stmtStok)) {
                    throw new Exception(mysqli_stmt_error($stmtStok));
                }

                mysqli_stmt_close($stmtStok);
            }

            // Jika seluruh baris sukses, commit transaksi
            mysqli_commit($koneksi);
            header('Location: penjualan_detail.php?no=' . urlencode($noPenjualan) . '&status=tambah');
            exit;
        } catch (Exception $e) {
            mysqli_rollback($koneksi);
            $error[] = 'Gagal memproses transaksi penjualan: ' . $e->getMessage();
        }
    }
}

// Helper untuk render opsi produk di select option
$renderOpsi = function (string $terpilih) use ($daftarProduk, $stokProduk) {
    echo '<option value="">-- pilih produk --</option>';

    foreach ($daftarProduk as $produk) {
        $stok = $stokProduk[$produk['kode_produk']] ?? 0;
        $selected = $terpilih === $produk['kode_produk'] ? ' selected' : '';

        echo '<option value="' . htmlspecialchars($produk['kode_produk'], ENT_QUOTES, 'UTF-8') . '"'
            . ' data-nama="' . htmlspecialchars($produk['nama_produk'], ENT_QUOTES, 'UTF-8') . '"'
            . ' data-harga="' . (float) $produk['harga_jual'] . '"'
            . ' data-stok="' . (int) $stok . '"' . $selected . '>'
            . htmlspecialchars($produk['kode_produk'] . ' - ' . $produk['nama_produk'])
            . ' (stok ' . (int) $stok . ')'
            . '</option>';
    }
};

$judul = 'Tambah Penjualan';
$halaman = 'penjualan';
$pakai_transaksi = true; // Memuat jQuery & assets/transaksi.js
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <div>
    <span class="badge text-bg-success mb-2">CREATE</span>
    <h1 class="h3 mb-1">Transaksi Penjualan Baru</h1>
    <p class="text-secondary mb-0">
      Pilih kasir, masukkan barang belanjaan pembeli, dan cek ketersediaan stok.
    </p>
  </div>
  <a class="btn btn-outline-secondary" href="penjualan.php">Kembali ke Daftar</a>
</div>

<?php if (count($error) > 0): ?>
  <div class="alert alert-danger">
    <strong>Transaksi penjualan belum bisa disimpan:</strong>
    <ul class="mb-0 mt-2">
      <?php foreach ($error as $pesan): ?>
        <li><?= htmlspecialchars($pesan) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<div class="card mb-4">
  <div class="card-body">
    <form method="post" action="penjualan_tambah.php">
      <div class="row g-3 mb-4">
        <div class="col-md-4">
          <label class="form-label" for="tanggal">Tanggal Penjualan</label>
          <input class="form-control" type="date" id="tanggal" name="tanggal"
                 value="<?= htmlspecialchars($tanggal) ?>" required>
        </div>

        <div class="col-md-4">
          <label class="form-label" for="id_kasir">Kasir yang Bertugas</label>
          <select class="form-select" id="id_kasir" name="id_kasir" required>
            <option value="">-- pilih kasir --</option>
            <?php foreach ($daftarKasir as $kasir): ?>
              <option value="<?= (int) $kasir['id_kasir'] ?>"
                <?= $idKasir === (int) $kasir['id_kasir'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($kasir['nama_kasir']) ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div class="form-text">Hanya kasir berstatus aktif yang ditampilkan.</div>
        </div>

        <div class="col-md-4">
          <label class="form-label" for="metode_bayar">Metode Pembayaran</label>
          <select class="form-select" id="metode_bayar" name="metode_bayar" required>
            <option value="Tunai" <?= $metodeBayar === 'Tunai' ? 'selected' : '' ?>>Tunai</option>
            <option value="QRIS" <?= $metodeBayar === 'QRIS' ? 'selected' : '' ?>>QRIS</option>
            <option value="Debit" <?= $metodeBayar === 'Debit' ? 'selected' : '' ?>>Debit</option>
          </select>
        </div>
      </div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0 fw-bold">Daftar Barang Belanjaan</h2>
        <span class="text-secondary small">Harga otomatis terisi dari harga jual produk</span>
      </div>

      <div class="table-responsive">
        <table class="table align-middle" id="tabel-item">
          <thead class="table-light">
            <tr>
              <th style="width: 38%;">Produk</th>
              <th style="width: 12%;">Jumlah</th>
              <th style="width: 18%;">Harga Satuan</th>
              <th style="width: 17%;" class="text-end">Subtotal</th>
              <th style="width: 15%;" class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($items as $item): ?>
              <?php
              $subtotalAwal = 0;
              if (is_numeric($item['jumlah']) && is_numeric($item['harga_satuan'])) {
                  $subtotalAwal = (float) $item['jumlah'] * (float) $item['harga_satuan'];
              }

              $infoText = 'Pilih produk untuk melihat stok.';
              if ($item['kode_produk'] !== '' && isset($petaProduk[$item['kode_produk']])) {
                  $infoText = $petaProduk[$item['kode_produk']]['nama_produk']
                      . ' | stok tersedia: '
                      . ($stokProduk[$item['kode_produk']] ?? 0);
              }
              ?>
              <tr class="baris-item">
                <td>
                  <select class="form-select pilih-produk" name="kode_produk[]" required>
                    <?php $renderOpsi($item['kode_produk']); ?>
                  </select>
                  <div class="form-text info-produk"><?= htmlspecialchars($infoText) ?></div>
                </td>
                <td>
                  <input class="form-control input-jumlah" type="number" name="jumlah[]"
                         min="1" step="1" value="<?= htmlspecialchars($item['jumlah']) ?>" required>
                </td>
                <td>
                  <input class="form-control input-harga" type="number" name="harga_satuan[]"
                         min="0" step="0.01" value="<?= htmlspecialchars($item['harga_satuan']) ?>" required>
                </td>
                <td class="text-end">
                  <span class="fw-semibold subtotal" data-subtotal><?= rupiah($subtotalAwal) ?></span>
                </td>
                <td class="text-end">
                  <button class="btn btn-sm btn-outline-danger btn-hapus-baris" type="button">Hapus</button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Banner Total Belanja -->
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 bg-primary text-white rounded p-3 my-3 shadow-sm">
        <span class="fw-medium">Total Pembayaran</span>
        <strong class="fs-3 font-monospace" id="total-nota">Rp 0</strong>
      </div>

      <div class="d-flex flex-wrap gap-2 mt-4">
        <button class="btn btn-outline-primary" type="button" id="btn-tambah-baris">+ Tambah Baris Barang</button>
        <button class="btn btn-primary px-4" type="submit">Simpan &amp; Proses Penjualan</button>
        <a class="btn btn-outline-secondary" href="penjualan.php">Batal</a>
      </div>
    </form>
  </div>
</div>

<!-- Template untuk Tambah Baris via transaksi.js -->
<template id="template-baris">
  <tr class="baris-item">
    <td>
      <select class="form-select pilih-produk" name="kode_produk[]" required>
        <?php $renderOpsi(''); ?>
      </select>
      <div class="form-text info-produk">Pilih produk untuk melihat stok.</div>
    </td>
    <td>
      <input class="form-control input-jumlah" type="number" name="jumlah[]"
             min="1" step="1" value="1" required>
    </td>
    <td>
      <input class="form-control input-harga" type="number" name="harga_satuan[]"
             min="0" step="0.01" value="" required>
    </td>
    <td class="text-end">
      <span class="fw-semibold subtotal" data-subtotal>Rp 0</span>
    </td>
    <td class="text-end">
      <button class="btn btn-sm btn-outline-danger btn-hapus-baris" type="button">Hapus</button>
    </td>
  </tr>
</template>

<?php require __DIR__ . '/partials/footer.php'; ?>
