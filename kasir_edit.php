<?php
require __DIR__ . '/config/database.php';

$id = (int) ($_GET['id_kasir'] ?? $_POST['id_kasir'] ?? 0);
$error = [];
$kasir = null;

if ($id <= 0) {
    $error[] = 'ID kasir tidak valid atau tidak dikirim.';
} else {
    $stmt = mysqli_prepare(
        $koneksi,
        'SELECT id_kasir, nama_kasir, status, tanggal_keluar
         FROM kasir
         WHERE id_kasir = ?'
    );

    if (!$stmt) {
        $error[] = 'Tabel kasir belum siap: ' . mysqli_error($koneksi);
    } else {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $hasil = mysqli_stmt_get_result($stmt);
        $kasir = mysqli_fetch_assoc($hasil);
        mysqli_stmt_close($stmt);

        if (!$kasir) {
            $error[] = 'Kasir dengan ID ' . $id . ' tidak ditemukan.';
        }
    }
}

$namaKasir = $kasir['nama_kasir'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $kasir) {
    $namaKasir = trim($_POST['nama_kasir'] ?? '');

    if ($namaKasir === '') {
        $error[] = 'Nama kasir wajib diisi.';
    } elseif (mb_strlen($namaKasir) > 50) {
        $error[] = 'Nama kasir maksimal 50 karakter.';
    }

    if (count($error) === 0) {
        $stmtUpdate = mysqli_prepare(
            $koneksi,
            'UPDATE kasir SET nama_kasir = ? WHERE id_kasir = ?'
        );

        if (!$stmtUpdate) {
            $error[] = 'Gagal menyiapkan query update: ' . mysqli_error($koneksi);
        } else {
            mysqli_stmt_bind_param($stmtUpdate, 'si', $namaKasir, $id);

            if (mysqli_stmt_execute($stmtUpdate)) {
                mysqli_stmt_close($stmtUpdate);
                header('Location: kasir.php?status=edit');
                exit;
            }

            $error[] = 'Gagal menyimpan perubahan: ' . mysqli_stmt_error($stmtUpdate);
            mysqli_stmt_close($stmtUpdate);
        }
    }
}

$judul = 'Edit Kasir';
$halaman = 'kasir';
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <div>
    <span class="badge text-bg-primary mb-2">UPDATE</span>
    <h1 class="h3 mb-1">Edit Data Kasir</h1>
    <p class="text-secondary mb-0">Ubah informasi nama kasir.</p>
  </div>
  <a class="btn btn-outline-secondary" href="kasir.php">Kembali ke Daftar Kasir</a>
</div>

<?php if (count($error) > 0): ?>
  <div class="alert alert-danger">
    <strong>Data kasir tidak bisa disimpan:</strong>
    <ul class="mb-0 mt-2">
      <?php foreach ($error as $pesan): ?>
        <li><?= htmlspecialchars($pesan) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<?php if ($kasir): ?>
  <div class="card mb-4">
    <div class="card-body">
      <form method="post" action="kasir_edit.php">
        <input type="hidden" name="id_kasir" value="<?= (int) $kasir['id_kasir'] ?>">

        <div class="row g-3">
          <div class="col-md-2">
            <label class="form-label" for="id_kasir_view">ID Kasir</label>
            <input class="form-control" type="text" id="id_kasir_view"
                   value="<?= (int) $kasir['id_kasir'] ?>" readonly disabled>
          </div>

          <div class="col-md-5">
            <label class="form-label" for="nama_kasir">Nama Kasir <span class="text-danger">*</span></label>
            <input class="form-control" type="text" id="nama_kasir" name="nama_kasir"
                   maxlength="50" value="<?= htmlspecialchars($namaKasir) ?>" required autofocus>
            <div class="form-text">Maksimal 50 karakter.</div>
          </div>

          <div class="col-md-2">
            <label class="form-label">Status</label>
            <input class="form-control" type="text"
                   value="<?= htmlspecialchars(ucfirst($kasir['status'])) ?>" readonly disabled>
          </div>

          <div class="col-md-3">
            <label class="form-label">Tanggal Keluar</label>
            <input class="form-control" type="text"
                   value="<?= $kasir['tanggal_keluar'] ? htmlspecialchars($kasir['tanggal_keluar']) : '-' ?>" readonly disabled>
          </div>
        </div>

        <div class="d-flex gap-2 mt-4">
          <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
          <a class="btn btn-outline-secondary" href="kasir.php">Batal</a>
        </div>
      </form>
    </div>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/partials/footer.php'; ?>
