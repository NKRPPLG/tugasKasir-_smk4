<?php
require __DIR__ . '/config/database.php';

$error = [];
$namaKasir = '';
$status = 'aktif';
$tanggalKeluar = '';
// keykla pingin tes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaKasir = trim($_POST['nama_kasir'] ?? '');
    $status = trim($_POST['status'] ?? 'aktif');
    $tanggalKeluar = trim($_POST['tanggal_keluar'] ?? '');

    if ($namaKasir === '') {
        $error[] = 'Nama kasir wajib diisi.';
    } elseif (mb_strlen($namaKasir) > 50) {
        $error[] = 'Nama kasir maksimal 50 karakter.';
    }

    if ($status !== 'aktif' && $status !== 'nonaktif') {
        $error[] = 'Status kasir tidak valid.';
    }

    $tglSimpan = null;
    if ($tanggalKeluar !== '') {
        $tglObj = DateTime::createFromFormat('!Y-m-d', $tanggalKeluar);
        $kesalahanTanggal = DateTime::getLastErrors();
        if (
            !$tglObj
            || $tglObj->format('Y-m-d') !== $tanggalKeluar
            || (
                $kesalahanTanggal !== false
                && ($kesalahanTanggal['warning_count'] > 0 || $kesalahanTanggal['error_count'] > 0)
            )
        ) {
            $error[] = 'Tanggal keluar tidak valid.';
        } elseif ($status === 'nonaktif') {
            $tglSimpan = $tanggalKeluar;
        }
    } elseif ($status === 'nonaktif') {
        $tglSimpan = date('Y-m-d');
    }

    if (count($error) === 0) {
        $stmt = mysqli_prepare(
            $koneksi,
            'INSERT INTO kasir (nama_kasir, status, tanggal_keluar) VALUES (?, ?, ?)'
        );

        if (!$stmt) {
            $error[] = 'Gagal menyiapkan query: ' . mysqli_error($koneksi);
        } else {
            mysqli_stmt_bind_param($stmt, 'sss', $namaKasir, $status, $tglSimpan);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                header('Location: kasir.php?status=tambah');
                exit;
            }

            $error[] = 'Gagal menyimpan kasir: ' . mysqli_stmt_error($stmt);
            mysqli_stmt_close($stmt);
        }
    }
}

$judul = 'Tambah Kasir';
$halaman = 'kasir';
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <div>
    <span class="badge text-bg-success mb-2">CREATE</span>
    <h1 class="h3 mb-1">Tambah Kasir Baru</h1>
    <p class="text-secondary mb-0">
      Masukkan data kasir yang bertugas di Toko Maju Jaya.
    </p>
  </div>
  <a class="btn btn-outline-secondary" href="kasir.php">Kembali ke Daftar Kasir</a>
</div>

<?php if (count($error) > 0): ?>
  <div class="alert alert-danger">
    <strong>Kasir belum bisa disimpan:</strong>
    <ul class="mb-0 mt-2">
      <?php foreach ($error as $pesan): ?>
        <li><?= htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8') ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<div class="card mb-4">
  <div class="card-body">
    <form method="post" action="kasir_tambah.php">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label" for="nama_kasir">Nama Kasir <span class="text-danger">*</span></label>
          <input class="form-control" type="text" id="nama_kasir" name="nama_kasir"
                 maxlength="50" placeholder="Contoh: Rina"
                 value="<?= htmlspecialchars($namaKasir, ENT_QUOTES, 'UTF-8') ?>" required autofocus>
          <div class="form-text">Wajib diisi, maksimal 50 karakter.</div>
        </div>

        <div class="col-md-3">
          <label class="form-label" for="status">Status</label>
          <select class="form-select" id="status" name="status">
            <?php if ($status !== 'aktif' && $status !== 'nonaktif'): ?>
              <option value="" selected disabled>-- pilih status yang valid --</option>
            <?php endif; ?>
            <option value="aktif" <?= $status === 'aktif' ? 'selected' : '' ?>>Aktif</option>
            <option value="nonaktif" <?= $status === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label" for="tanggal_keluar">Tanggal Keluar</label>
          <input class="form-control" type="date" id="tanggal_keluar" name="tanggal_keluar"
                 value="<?= htmlspecialchars($tanggalKeluar, ENT_QUOTES, 'UTF-8') ?>">
          <div class="form-text">Digunakan untuk kasir nonaktif. Kosongkan jika masih aktif.</div>
        </div>
      </div>

      <div class="d-flex gap-2 mt-4">
        <button class="btn btn-primary" type="submit">Simpan Kasir</button>
        <a class="btn btn-outline-secondary" href="kasir.php">Batal</a>
      </div>
    </form>
  </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
