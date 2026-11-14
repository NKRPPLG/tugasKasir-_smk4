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

<div class="ks-page-header mb-4">
  <div class="ks-page-header-left">
    <span class="ks-badge ks-badge-neutral mb-2">Master Data</span>
    <h1 class="ks-page-title">Daftar Kasir</h1>
    <p class="ks-page-subtitle">Koperasi Merah Hitam</p>
  </div>
  <div class="d-flex gap-2">
    <a class="ks-btn ks-btn-primary" href="kasir_tambah.php">+ Tambah Kasir</a>
  </div>
</div>

<?php if ($errorTabel !== ''): ?>
  <div class="ks-alert ks-alert-danger mb-3">
    <span class="ks-alert-icon">⚠️</span>
    <div>
      <strong>Tabel kasir belum bisa dibaca.</strong>
      <div class="ks-text-sm mt-1">Pesan MySQL: <?= htmlspecialchars($errorTabel) ?></div>
    </div>
  </div>
<?php endif; ?>

<?php if (isset($pesanStatus[$status])): ?>
  <?php $tipe = $pesanStatus[$status][0] === 'success' ? 'ks-alert-success' : ($pesanStatus[$status][0] === 'warning' ? 'ks-alert-warning' : 'ks-alert-danger'); ?>
  <div class="ks-alert <?= $tipe ?> mb-3">
    <span class="ks-alert-icon"><?= $pesanStatus[$status][0] === 'success' ? '✅' : '⚠️' ?></span>
    <span><?= htmlspecialchars($pesanStatus[$status][1]) ?></span>
  </div>
<?php endif; ?>

<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="ks-stat d-flex align-items-center gap-3">
      <div class="ks-stat-icon teal">👤</div>
      <div>
        <div class="ks-stat-label">Total Kasir</div>
        <div class="ks-stat-value"><?= $jumlahKasir ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="ks-stat d-flex align-items-center gap-3">
      <div class="ks-stat-icon green">✅</div>
      <div>
        <div class="ks-stat-label">Kasir Aktif</div>
        <div class="ks-stat-value"><?= $jumlahAktif ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="ks-stat d-flex align-items-center gap-3">
      <div class="ks-stat-icon red">🚫</div>
      <div>
        <div class="ks-stat-label">Nonaktif</div>
        <div class="ks-stat-value"><?= $jumlahNonaktif ?></div>
      </div>
    </div>
  </div>
</div>

<div class="ks-card mb-4">
  <div class="ks-table-wrap">
    <table class="ks-table">
      <thead>
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
            <td colspan="5" class="text-center ks-text-muted py-4">Belum ada data kasir.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($daftarKasir as $kasir): ?>
            <tr>
              <td><?= (int) $kasir['id_kasir'] ?></td>
              <td><?= htmlspecialchars($kasir['nama_kasir']) ?></td>
              <td>
                <?php if ($kasir['status'] === 'aktif'): ?>
                  <span class="ks-badge ks-badge-success">Aktif</span>
                <?php else: ?>
                  <span class="ks-badge ks-badge-neutral">Nonaktif</span>
                <?php endif; ?>
              </td>
              <td>
                <?= $kasir['tanggal_keluar'] ? htmlspecialchars($kasir['tanggal_keluar']) : '-' ?>
              </td>
              <td class="text-end">
                <a class="ks-btn ks-btn-ghost ks-btn-sm" href="kasir_edit.php?id_kasir=<?= (int) $kasir['id_kasir'] ?>">Edit</a>
                <?php if ($kasir['status'] === 'aktif'): ?>
                  <a class="ks-btn ks-btn-outline-danger ks-btn-sm" href="kasir_nonaktifkan.php?id_kasir=<?= (int) $kasir['id_kasir'] ?>">Nonaktifkan</a>
                <?php else: ?>
                  <button class="ks-btn ks-btn-ghost ks-btn-sm" disabled>Nonaktif</button>
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
