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

$pesanStatus = [
    'tambah'   => ['success', 'Kasir baru berhasil ditambahkan.'],
    'edit'     => ['success', 'Data kasir berhasil diperbarui.'],
    'nonaktif' => ['warning', 'Kasir berhasil dinonaktifkan.'],
];
$status = $_GET['status'] ?? '';

$judul = 'Daftar Kasir';
$halaman = 'kasir';
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <div>
    <span class="badge text-bg-success mb-2">Master Data</span>
    <h1 class="h3 mb-1">Daftar Kasir</h1>
    <p class="text-secondary mb-0">Manajemen akun kasir bertugas &middot; database <code>db_penjualan</code></p>
  </div>
  <div class="d-flex gap-2">
    <a class="btn btn-primary" href="kasir_tambah.php">+ Tambah Kasir</a>
  </div>
</div>

<?php if ($errorTabel !== ''): ?>
  <div class="alert alert-danger">
    <strong>Tabel kasir belum bisa dibaca.</strong>
    <div class="small mt-1">Pesan MySQL: <?= htmlspecialchars($errorTabel) ?></div>
  </div>
<?php endif; ?>

<?php if (isset($pesanStatus[$status])): ?>
  <div class="alert alert-<?= $pesanStatus[$status][0] ?> alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($pesanStatus[$status][1]) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="text-secondary small">Total Kasir</div>
        <div class="fs-3 fw-bold"><?= $jumlahKasir ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="text-secondary small">Kasir Aktif</div>
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
              <td class="text-end">
                <a class="btn btn-sm btn-outline-primary" href="kasir_edit.php?id_kasir=<?= (int) $kasir['id_kasir'] ?>">Edit</a>
                <?php if ($kasir['status'] === 'aktif'): ?>
                  <a class="btn btn-sm btn-outline-danger" href="kasir_nonaktifkan.php?id_kasir=<?= (int) $kasir['id_kasir'] ?>">Nonaktifkan</a>
                <?php else: ?>
                  <button class="btn btn-sm btn-outline-secondary" disabled>Nonaktif</button>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
