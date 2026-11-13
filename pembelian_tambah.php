<?php
// ============================================================
// kasirsmk/pembelian_tambah.php
// CREATE: satu nota pembelian berisi banyak barang.
//
// Urutan: validasi -> begin_transaction -> INSERT kepala nota
// -> INSERT detail + stok masuk -> commit.
// ============================================================
require __DIR__ . '/config/database.php';
require __DIR__ . '/transaksi_helper.php';

$error = [];
$tanggal = date('Y-m-d');
$idKasir = 0;
$idSupplier = 0;
$items = [
    ['kode_produk' => '', 'jumlah' => '1', 'harga_beli' => ''],
];

$daftarKasir = ambil_kasir_aktif($koneksi);
$daftarSupplier = ambil_supplier($koneksi);
$daftarProduk = ambil_produk($koneksi);

$petaKasir = [];
foreach ($daftarKasir as $kasir) {
    $petaKasir[(int) $kasir['id_kasir']] = $kasir;
}

$petaSupplier = [];
foreach ($daftarSupplier as $supplier) {
    $petaSupplier[(int) $supplier['id_supplier']] = $supplier;
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
    $idSupplier = (int) ($_POST['id_supplier'] ?? 0);

    $kodeArray = $_POST['kode_produk'] ?? [];
    $jumlahArray = $_POST['jumlah'] ?? [];
    $hargaArray = $_POST['harga_beli'] ?? [];

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
            'harga_beli' => $hargaInput,
        ];
    }

    if (count($items) === 0) {
        $items[] = ['kode_produk' => '', 'jumlah' => '1', 'harga_beli' => ''];
    }

    $tanggalObj = DateTime::createFromFormat('Y-m-d', $tanggal);
    if (!$tanggalObj || $tanggalObj->format('Y-m-d') !== $tanggal) {
        $error[] = 'Tanggal pembelian tidak valid.';
    }

    if (!isset($petaKasir[$idKasir])) {
        $error[] = 'Kasir yang dipilih tidak ditemukan atau sudah nonaktif.';
    }

    if (!isset($petaSupplier[$idSupplier])) {
        $error[] = 'Supplier yang dipilih tidak ditemukan.';
    }

    $itemsValid = [];
    $adaBaris = false;

    foreach ($items as $index => $item) {
        $nomorBaris = $index + 1;

        if ($item['kode_produk'] === '') {
            if ($item['jumlah'] !== '' || $item['harga_beli'] !== '') {
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
            $error[] = 'Baris ' . $nomorBaris . ': jumlah harus bilangan bulat 1 atau lebih.';
            continue;
        }

        if ($item['harga_beli'] === '' || !is_numeric($item['harga_beli']) || (float) $item['harga_beli'] < 0) {
            $error[] = 'Baris ' . $nomorBaris . ': harga beli harus angka 0 atau lebih.';
            continue;
        }

        $produk = $petaProduk[$item['kode_produk']];
        $itemsValid[] = [
            'kode_produk' => $item['kode_produk'],
            'nama_produk' => $produk['nama_produk'],
            'jumlah' => (int) $jumlah,
            'harga_beli' => (float) $item['harga_beli'],
        ];
    }

    if (!$adaBaris) {
        $error[] = 'Isi minimal satu barang pada nota pembelian.';
    }

    if (count($error) === 0) {
        mysqli_begin_transaction($koneksi);

        try {
            $noPembelian = buat_nomor($koneksi, 'PB-', 'pembelian', 'no_pembelian');

            $stmt = mysqli_prepare(
                $koneksi,
                'INSERT INTO pembelian (no_pembelian, tanggal, id_kasir, id_supplier)
                 VALUES (?, ?, ?, ?)'
            );

            if (!$stmt) {
                throw new Exception(mysqli_error($koneksi));
            }

            mysqli_stmt_bind_param($stmt, 'ssii', $noPembelian, $tanggal, $idKasir, $idSupplier);

            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception(mysqli_stmt_error($stmt));
            }

            mysqli_stmt_close($stmt);

            foreach ($itemsValid as $item) {
                $stmtDetail = mysqli_prepare(
                    $koneksi,
                    'INSERT INTO detail_pembelian
                        (no_pembelian, kode_produk, nama_produk, jumlah, harga_beli)
                     VALUES (?, ?, ?, ?, ?)'
                );

                if (!$stmtDetail) {
                    throw new Exception(mysqli_error($koneksi));
                }

                mysqli_stmt_bind_param(
                    $stmtDetail,
                    'sssid',
                    $noPembelian,
                    $item['kode_produk'],
                    $item['nama_produk'],
                    $item['jumlah'],
                    $item['harga_beli']
                );

                if (!mysqli_stmt_execute($stmtDetail)) {
                    throw new Exception(mysqli_stmt_error($stmtDetail));
                }

                mysqli_stmt_close($stmtDetail);

                $saldoAwal = saldo_stok_terakhir($koneksi, $item['kode_produk']);
                $saldoAkhir = $saldoAwal + $item['jumlah'];
                $jumlahMasuk = $item['jumlah'];
                $jumlahKeluar = 0;
                $noPenjualan = null;
                $keterangan = 'Beli dari supplier';

                $stmtStok = mysqli_prepare(
                    $koneksi,
                    'INSERT INTO stok
                        (kode_produk, tanggal, jumlah_masuk, jumlah_keluar,
                         saldo_awal, saldo_akhir, no_penjualan, no_pembelian, keterangan)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
                );

                if (!$stmtStok) {
                    throw new Exception(mysqli_error($koneksi));
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

            mysqli_commit($koneksi);
            header('Location: pembelian_detail.php?no=' . urlencode($noPembelian) . '&status=tambah');
            exit;
        } catch (Exception $e) {
            mysqli_rollback($koneksi);
            $error[] = 'Gagal menyimpan pembelian: ' . $e->getMessage();
        }
    }
}

$renderOpsi = function (string $terpilih) use ($daftarProduk, $stokProduk) {
    echo '<option value="">-- pilih produk --</option>';

    foreach ($daftarProduk as $produk) {
        $stok = $stokProduk[$produk['kode_produk']] ?? 0;
        $selected = $terpilih === $produk['kode_produk'] ? ' selected' : '';

        echo '<option value="' . htmlspecialchars($produk['kode_produk'], ENT_QUOTES, 'UTF-8') . '"'
            . ' data-nama="' . htmlspecialchars($produk['nama_produk'], ENT_QUOTES, 'UTF-8') . '"'
            . ' data-harga="' . (float) $produk['harga_beli'] . '"'
            . ' data-stok="' . (int) $stok . '"' . $selected . '>'
            . htmlspecialchars($produk['kode_produk'] . ' - ' . $produk['nama_produk'])
            . '</option>';
    }
};

$judul = 'Tambah Pembelian';
$halaman = 'pembelian';
$pakai_transaksi = true;
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <div>
    <span class="badge text-bg-success mb-2">CREATE</span>
    <h1 class="h3 mb-1">Tambah Pembelian</h1>
    <p class="text-secondary mb-0">
      Satu nota boleh berisi banyak produk. Stok akan bertambah otomatis.
    </p>
  </div>
  <a class="btn btn-outline-secondary" href="pembelian.php">Kembali</a>
</div>

<?php if (count($error) > 0): ?>
  <div class="alert alert-danger">
    <strong>Pembelian belum bisa disimpan:</strong>
    <ul class="mb-0 mt-2">
      <?php foreach ($error as $pesan): ?>
        <li><?= htmlspecialchars($pesan) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<div class="alert alert-info">
  <strong>Urutan aman:</strong> validasi dulu semua baris, baru buka transaksi
  database. Jika satu barang gagal disimpan, seluruh nota dibatalkan
  (<code>rollback</code>).
</div>

<div class="card mb-4">
  <div class="card-body">
    <form method="post" action="pembelian_tambah.php">
      <div class="row g-3 mb-4">
        <div class="col-md-4">
          <label class="form-label" for="tanggal">Tanggal Pembelian</label>
          <input class="form-control" type="date" id="tanggal" name="tanggal"
                 value="<?= htmlspecialchars($tanggal) ?>" required>
        </div>

        <div class="col-md-4">
          <label class="form-label" for="id_kasir">Kasir</label>
          <select class="form-select" id="id_kasir" name="id_kasir" required>
            <option value="">-- pilih kasir --</option>
            <?php foreach ($daftarKasir as $kasir): ?>
              <option value="<?= (int) $kasir['id_kasir'] ?>"
                <?= $idKasir === (int) $kasir['id_kasir'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($kasir['nama_kasir']) ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div class="form-text">Hanya kasir aktif yang muncul.</div>
        </div>

        <div class="col-md-4">
          <label class="form-label" for="id_supplier">Supplier</label>
          <select class="form-select" id="id_supplier" name="id_supplier" required>
            <option value="">-- pilih supplier --</option>
            <?php foreach ($daftarSupplier as $supplier): ?>
              <option value="<?= (int) $supplier['id_supplier'] ?>"
                <?= $idSupplier === (int) $supplier['id_supplier'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($supplier['nama_supplier']) ?>
                <?= $supplier['kota'] ? ' - ' . htmlspecialchars($supplier['kota']) : '' ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <h2 class="h5 mb-3">Isi Nota</h2>

      <div class="table-responsive">
        <table class="table align-middle" id="tabel-item">
          <thead class="table-light">
            <tr>
              <th style="width: 38%;">Produk</th>
              <th style="width: 12%;">Jumlah</th>
              <th style="width: 18%;">Harga Beli</th>
              <th style="width: 17%;" class="text-end">Subtotal</th>
              <th style="width: 15%;" class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($items as $item): ?>
              <?php
              $subtotalAwal = 0;
              if (is_numeric($item['jumlah']) && is_numeric($item['harga_beli'])) {
                  $subtotalAwal = (float) $item['jumlah'] * (float) $item['harga_beli'];
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
                  <input class="form-control input-harga" type="number" name="harga_beli[]"
                         min="0" step="0.01" value="<?= htmlspecialchars($item['harga_beli']) ?>" required>
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

      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 bg-primary text-white rounded p-3 my-3">
        <span>Total Pembelian</span>
        <strong class="fs-4" id="total-nota">Rp 0</strong>
      </div>

      <div class="d-flex flex-wrap gap-2">
        <button class="btn btn-outline-primary" type="button" id="btn-tambah-baris">Tambah Baris</button>
        <button class="btn btn-primary" type="submit">Simpan Pembelian</button>
        <a class="btn btn-outline-secondary" href="pembelian.php">Batal</a>
      </div>
    </form>
  </div>
</div>

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
      <input class="form-control input-harga" type="number" name="harga_beli[]"
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

<div class="alert alert-info mt-4 mb-0">
  Ingin membaca langkahnya? Buka
  <a class="alert-link" href="panduan.php#alur-pembelian">Alur Pembelian</a>
  di panduan.
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
