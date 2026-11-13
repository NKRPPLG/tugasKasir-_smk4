<?php
require __DIR__ . '/config/database.php';

$id = (int) ($_GET['id_supplier'] ?? $_POST['id_supplier'] ?? 0);
$error = [];
$supplier = null;

if ($id <= 0) {
    $error[] = 'ID supplier tidak valid atau tidak dikirim.';
} else {
    $stmt = mysqli_prepare(
        $koneksi,
        'SELECT id_supplier, nama_supplier, kota
         FROM supplier
         WHERE id_supplier = ?'
    );

    if (!$stmt) {
        $error[] = 'Tabel supplier belum siap: ' . mysqli_error($koneksi);
    } else {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $hasil = mysqli_stmt_get_result($stmt);
        $supplier = mysqli_fetch_assoc($hasil);
        mysqli_stmt_close($stmt);

        if (!$supplier) {
            $error[] = 'Supplier dengan ID ' . $id . ' tidak ditemukan.';
        }
    }
}

$namaSupplier = $supplier['nama_supplier'] ?? '';
$kota = $supplier['kota'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $supplier) {
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
        $stmtUpdate = mysqli_prepare(
            $koneksi,
            'UPDATE supplier SET nama_supplier = ?, kota = ? WHERE id_supplier = ?'
        );

        if (!$stmtUpdate) {
            $error[] = 'Gagal menyiapkan query update: ' . mysqli_error($koneksi);
        } else {
            $kotaSimpan = $kota !== '' ? $kota : null;
            mysqli_stmt_bind_param($stmtUpdate, 'ssi', $namaSupplier, $kotaSimpan, $id);

            if (mysqli_stmt_execute($stmtUpdate)) {
                mysqli_stmt_close($stmtUpdate);
                header('Location: supplier.php?status=edit');
                exit;
            }

            $error[] = 'Gagal menyimpan perubahan: ' . mysqli_stmt_error($stmtUpdate);
            mysqli_stmt_close($stmtUpdate);
        }
    }
}

$judul = 'Edit Supplier';
$halaman = 'supplier';
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <div>
    <span class="badge text-bg-primary mb-2">UPDATE</span>
    <h1 class="h3 mb-1">Edit Data Supplier</h1>
    <p class="text-secondary mb-0">Perbarui informasi mitra pemasok.</p>
  </div>
  <a class="btn btn-outline-secondary" href="supplier.php">Kembali ke Daftar Supplier</a>
</div>

<?php if (count($error) > 0): ?>
  <div class="alert alert-danger">
    <strong>Data supplier tidak bisa disimpan:</strong>
    <ul class="mb-0 mt-2">
      <?php foreach ($error as $pesan): ?>
        <li><?= htmlspecialchars($pesan) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<?php if ($supplier): ?>
  <div class="card mb-4">
    <div class="card-body">
      <form method="post" action="supplier_edit.php">
        <input type="hidden" name="id_supplier" value="<?= (int) $supplier['id_supplier'] ?>">

        <div class="row g-3">
          <div class="col-md-2">
            <label class="form-label" for="id_supplier_view">ID Supplier</label>
            <input class="form-control" type="text" id="id_supplier_view"
                   value="<?= (int) $supplier['id_supplier'] ?>" readonly disabled>
          </div>

          <div class="col-md-6">
            <label class="form-label" for="nama_supplier">Nama Supplier <span class="text-danger">*</span></label>
            <input class="form-control" type="text" id="nama_supplier" name="nama_supplier"
                   maxlength="50" value="<?= htmlspecialchars($namaSupplier) ?>" required autofocus>
            <div class="form-text">Wajib diisi, maksimal 50 karakter.</div>
          </div>

          <div class="col-md-4">
            <label class="form-label" for="kota">Kota</label>
            <input class="form-control" type="text" id="kota" name="kota"
                 maxlength="30" value="<?= htmlspecialchars($kota) ?>">
            <div class="form-text">Opsional, maksimal 30 karakter.</div>
          </div>
        </div>

        <div class="d-flex gap-2 mt-4">
          <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
          <a class="btn btn-outline-secondary" href="supplier.php">Batal</a>
        </div>
      </form>
    </div>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/partials/footer.php'; ?>
