<?php
require __DIR__ . '/config/database.php';

$error = [];
$namaSupplier = '';
$kota = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaSupplier = trim($_POST['nama_supplier'] ?? '');
    $kota = trim($_POST['kota'] ?? '');

    if ($namaSupplier === '') {
        $error[] = 'Nama supplier wajib diisi.';
    } elseif (mb_strlen($namaSupplier) > 50) {
        $error[] = 'Nama supplier maksimal 50 karakter.';
    }

    if (mb_strlen($kota) > 30) {
        $error[] = 'Kota maksimal 30 karakter.';
    }

    if (count($error) === 0) {
        $stmt = mysqli_prepare(
            $koneksi,
            'INSERT INTO supplier (nama_supplier, kota) VALUES (?, ?)'
        );

        if (!$stmt) {
            $error[] = 'Gagal menyiapkan query: ' . mysqli_error($koneksi);
        } else {
            $kotaSimpan = $kota !== '' ? $kota : null;
            mysqli_stmt_bind_param($stmt, 'ss', $namaSupplier, $kotaSimpan);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                header('Location: supplier.php?status=tambah');
                exit;
            }

            $error[] = 'Gagal menyimpan supplier: ' . mysqli_stmt_error($stmt);
            mysqli_stmt_close($stmt);
        }
    }
}

$judul = 'Tambah Supplier';
$halaman = 'supplier';
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <div>
    <span class="badge text-bg-success mb-2">CREATE</span>
    <h1 class="h3 mb-1">Tambah Supplier Baru</h1>
    <p class="text-secondary mb-0">
      Masukkan data mitra pemasok barang untuk Toko Maju Jaya.
    </p>
  </div>
  <a class="btn btn-outline-secondary" href="supplier.php">Kembali ke Daftar Supplier</a>
</div>

<?php if (count($error) > 0): ?>
  <div class="alert alert-danger">
    <strong>Supplier belum bisa disimpan:</strong>
    <ul class="mb-0 mt-2">
      <?php foreach ($error as $pesan): ?>
        <li><?= htmlspecialchars($pesan) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<div class="card mb-4">
  <div class="card-body">
    <form method="post" action="supplier_tambah.php">
      <div class="row g-3">
        <div class="col-md-7">
          <label class="form-label" for="nama_supplier">Nama Supplier <span class="text-danger">*</span></label>
          <input class="form-control" type="text" id="nama_supplier" name="nama_supplier"
                 maxlength="50" placeholder="Contoh: PT Sumber Pangan"
                 value="<?= htmlspecialchars($namaSupplier) ?>" required autofocus>
          <div class="form-text">Wajib diisi, maksimal 50 karakter.</div>
        </div>

        <div class="col-md-5">
          <label class="form-label" for="kota">Kota</label>
          <input class="form-control" type="text" id="kota" name="kota"
                 maxlength="30" placeholder="Contoh: Surabaya"
                 value="<?= htmlspecialchars($kota) ?>">
          <div class="form-text">Opsional, maksimal 30 karakter.</div>
        </div>
      </div>

      <div class="d-flex gap-2 mt-4">
        <button class="btn btn-primary" type="submit">Simpan Supplier</button>
        <a class="btn btn-outline-secondary" href="supplier.php">Batal</a>
      </div>
    </form>
  </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
