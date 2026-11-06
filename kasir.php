<?php
require __DIR__ . '/config/database.php';

$hasil = mysqli_query(
    $koneksi,
    'SELECT id_kasir, nama_kasir, status, tanggal_keluar
     FROM kasir
     ORDER BY id_kasir'
);

$errorTabel = '';
$daftarKasir = [];

if (!$hasil) {
    $errorTabel = mysqli_error($koneksi);
} else {
    while ($baris = mysqli_fetch_assoc($hasil)) {
        $daftarKasir[] = $baris;
    }
}

$jumlahKasir = count($daftarKasir);
$jumlahAktif = 0;
$jumlahNonaktif = 0;

foreach ($daftarKasir as $kasir) {
    if ($kasir['status'] === 'aktif') {
        $jumlahAktif++;
    } else {
        $jumlahNonaktif++;
    }
}

$judul = 'Daftar Kasir';
$halaman = 'kasir';
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <div>
    <span class="badge text-bg-warning mb-2">Contoh READ</span>
    <h1 class="h3 mb-1">Daftar Kasir</h1>
    <p class="text-secondary mb-0">Contoh menampilkan data dari tabel <code>kasir</code>.</p>
  </div>
  <div class="d-flex gap-2">
    <a class="btn btn-primary" href="kasir_tambah.php">Lihat Contoh Form</a>
    <a class="btn btn-outline-secondary" href="panduan.php#tugas-kasir">Brief Tugas</a>
  </div>
</div>

<?php if ($errorTabel !== ''): ?>
  <div class="alert alert-danger">
    <strong>Tabel kasir belum bisa dibaca.</strong>
    <div class="small mt-1">Pesan MySQL: <?= htmlspecialchars($errorTabel) ?></div>
  </div>
<?php endif; ?>

<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="text-secondary small">Jumlah Kasir</div>
        <div class="fs-3 fw-bold"><?= $jumlahKasir ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="text-secondary small">Aktif</div>
        <div class="fs-3 fw-bold text-success"><?= $jumlahAktif ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="text-secondary small">Nonaktif</div>
        <div class="fs-3 fw-bold text-secondary"><?= $jumlahNonaktif ?></div>
      </div>
    </div>
  </div>
</div>

<div class="card mb-4">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Nama Kasir</th>
          <th>Status</th>
          <th>Tanggal Keluar</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($jumlahKasir === 0): ?>
          <tr>
            <td colspan="5" class="text-center text-secondary py-4">Belum ada data kasir.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($daftarKasir as $kasir): ?>
            <tr>
              <td><?= (int) $kasir['id_kasir'] ?></td>
              <td><?= htmlspecialchars($kasir['nama_kasir']) ?></td>
              <td>
                <?php if ($kasir['status'] === 'aktif'): ?>
                  <span class="badge text-bg-success">Aktif</span>
                <?php else: ?>
                  <span class="badge text-bg-secondary">Nonaktif</span>
                <?php endif; ?>
              </td>
              <td>
                <?= $kasir['tanggal_keluar'] ? htmlspecialchars($kasir['tanggal_keluar']) : '-' ?>
              </td>
              <td class="text-end text-secondary small">Tugas siswa</td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="alert alert-info">
  <strong>Ini contoh READ.</strong> Tugasmu:
  <ul class="mb-0 mt-2">
    <li>Lengkapi proses simpan pada <code>kasir_tambah.php</code>.</li>
    <li>Buat <code>kasir_edit.php</code>.</li>
    <li>Buat <code>kasir_nonaktifkan.php</code> dengan soft delete.</li>
  </ul>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
