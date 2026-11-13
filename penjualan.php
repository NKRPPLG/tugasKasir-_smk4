<?php
// ============================================================
// kasirsmk/penjualan.php
// HALAMAN BRIEF TUGAS: modul penjualan (barang keluar).
//
// File ini sengaja belum menampilkan daftar penjualan. Tugas siswa:
//   1. Ganti bagian brief dengan query daftar penjualan.
//   2. Lengkapi form di penjualan_tambah.php.
//   3. Buat nota di penjualan_detail.php.
//
// Contoh yang bisa diikuti: pembelian.php + pembelian_tambah.php.
// ============================================================
require __DIR__ . '/config/database.php';
require __DIR__ . '/transaksi_helper.php';

$jumlahNota = 0;
$jumlahBaris = 0;
$totalNilai = 0;
$errorTabel = '';

$hasil = mysqli_query($koneksi, 'SELECT COUNT(*) AS jumlah FROM penjualan');
if ($hasil && $baris = mysqli_fetch_assoc($hasil)) {
    $jumlahNota = (int) $baris['jumlah'];
} else {
    $errorTabel = mysqli_error($koneksi);
}

$hasil = mysqli_query($koneksi, 'SELECT COUNT(*) AS jumlah FROM detail_penjualan');
if ($hasil && $baris = mysqli_fetch_assoc($hasil)) {
    $jumlahBaris = (int) $baris['jumlah'];
}

$hasil = mysqli_query(
    $koneksi,
    'SELECT COALESCE(SUM(jumlah * harga_satuan), 0) AS total FROM detail_penjualan'
);
if ($hasil && $baris = mysqli_fetch_assoc($hasil)) {
    $totalNilai = (float) $baris['total'];
}

$judul = 'Tugas Penjualan';
$halaman = 'penjualan';
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <div>
    <span class="badge text-bg-warning mb-2">TUGAS MANDIRI</span>
    <h1 class="h3 mb-1">Modul Penjualan</h1>
    <p class="text-secondary mb-0">
      Barang keluar: pilih kasir, isi barang, cek stok, lalu simpan nota.
    </p>
  </div>
  <div class="d-flex gap-2">
    <a class="btn btn-outline-primary" href="pembelian.php">Lihat Contoh Pembelian</a>
    <a class="btn btn-outline-secondary" href="panduan.php#tugas-penjualan">Brief Lengkap</a>
  </div>
</div>

<?php if ($errorTabel !== ''): ?>
  <div class="alert alert-danger">
    <strong>Tabel penjualan belum bisa dibaca.</strong>
    <div class="small mt-1">Pesan MySQL: <?= htmlspecialchars($errorTabel) ?></div>
  </div>
<?php endif; ?>

<div class="alert alert-warning">
  <strong>Halaman ini masih berupa brief.</strong> Tugasmu mengganti isi halaman
  ini dengan daftar penjualan yang membaca tabel <code>penjualan</code> dan
  <code>detail_penjualan</code>. Gunakan <code>pembelian.php</code> sebagai
  contoh pola query, pencarian, dan tabel.
</div>

<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="text-secondary small">Nota Penjualan di Database</div>
        <div class="fs-3 fw-bold"><?= $jumlahNota ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="text-secondary small">Baris Detail</div>
        <div class="fs-3 fw-bold"><?= $jumlahBaris ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="text-secondary small">Total Nilai Contoh</div>
        <div class="fs-4 fw-bold text-primary"><?= rupiah($totalNilai) ?></div>
      </div>
    </div>
  </div>
</div>

<div class="card mb-4">
  <div class="card-header bg-white fw-semibold">File yang Harus Diisi</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>File</th>
            <th>Tugas</th>
            <th>Contoh</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><code>penjualan.php</code></td>
            <td>Ganti brief ini dengan daftar nota + pencarian + statistik.</td>
            <td><code>pembelian.php</code></td>
          </tr>
          <tr>
            <td><code>penjualan_tambah.php</code></td>
            <td>Lengkapi form multi-baris, validasi, cek stok, INSERT, redirect.</td>
            <td><code>pembelian_tambah.php</code></td>
          </tr>
          <tr>
            <td><code>penjualan_detail.php</code></td>
            <td>Buat nota: kepala, isi, total, dan dampak stok keluar.</td>
            <td><code>pembelian_detail.php</code></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="row g-4 mb-4">
  <div class="col-lg-7">
    <div class="card h-100">
      <div class="card-header bg-white fw-semibold">Alur Wajib</div>
      <div class="card-body">
        <ol class="mb-0">
          <li class="mb-2">Ambil kasir aktif dan daftar produk beserta stok terakhir.</li>
          <li class="mb-2">Validasi tanggal, kasir, metode bayar, dan setiap baris barang.</li>
          <li class="mb-2">Cek stok: jumlah jual tidak boleh melebihi <code>saldo_akhir</code>.</li>
          <li class="mb-2">Buka transaksi: <code>mysqli_begin_transaction()</code>.</li>
          <li class="mb-2">INSERT kepala nota ke <code>penjualan</code>.</li>
          <li class="mb-2">INSERT <code>detail_penjualan</code> + <code>stok</code> keluar per barang.</li>
          <li class="mb-2">Commit, lalu arahkan ke <code>penjualan_detail.php?no=...</code>.</li>
        </ol>
      </div>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="card h-100">
      <div class="card-header bg-white fw-semibold">Aturan Penting</div>
      <div class="card-body">
        <ul class="mb-0">
          <li class="mb-2">Harga disimpan sebagai snapshot <code>harga_satuan</code>.</li>
          <li class="mb-2">Penjualan mengurangi stok (<code>jumlah_keluar</code>).</li>
          <li class="mb-2">Metode bayar: <code>Tunai</code>, <code>QRIS</code>, atau <code>Debit</code>.</li>
          <li class="mb-2">Semua input lewat prepared statement.</li>
          <li class="mb-2">Jika satu barang gagal, seluruh nota di-<code>rollback</code>.</li>
          <li>Total dihitung dari detail, bukan disimpan di kepala nota.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="card mb-4">
  <div class="card-header bg-white fw-semibold">Kerangka Query Daftar</div>
  <div class="card-body">
    <p class="text-secondary">
      Gunakan pola <code>GROUP BY</code> yang sama seperti pembelian. Ganti nama
      tabel dan kolom harga sesuai penjualan.
    </p>
    <pre class="bg-dark text-light p-3 rounded code-block mb-0"><code>SELECT pj.no_penjualan, pj.tanggal, pj.id_kasir, pj.metode_bayar,
       k.nama_kasir,
       COALESCE(SUM(d.jumlah * d.harga_satuan), 0) AS total,
       COUNT(d.id_detail) AS jumlah_item
FROM penjualan pj
LEFT JOIN kasir k ON k.id_kasir = pj.id_kasir
LEFT JOIN detail_penjualan d ON d.no_penjualan = pj.no_penjualan
GROUP BY pj.no_penjualan, pj.tanggal, pj.id_kasir, pj.metode_bayar, k.nama_kasir
ORDER BY pj.tanggal DESC, pj.no_penjualan DESC;</code></pre>
  </div>
</div>

<div class="card mb-4">
  <div class="card-header bg-white fw-semibold">Checklist Selesai</div>
  <div class="card-body">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="cek1">
      <label class="form-check-label" for="cek1">Daftar penjualan tampil + pencarian berfungsi.</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="cek2">
      <label class="form-check-label" for="cek2">Form penjualan bisa menambah lebih dari satu barang.</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="cek3">
      <label class="form-check-label" for="cek3">Harga satuan terisi otomatis dari harga jual.</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="cek4">
      <label class="form-check-label" for="cek4">Penjualan melebihi stok ditolak dengan pesan jelas.</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="cek5">
      <label class="form-check-label" for="cek5">Setelah simpan, stok berkurang dan nota tampil.</label>
    </div>
  </div>
</div>

<div class="d-flex flex-wrap gap-2">
  <a class="btn btn-primary" href="penjualan_tambah.php">Buka Kerangka Form</a>
  <a class="btn btn-outline-secondary" href="pembelian_tambah.php">Contoh Form Pembelian</a>
  <a class="btn btn-outline-secondary" href="panduan.php#tugas-penjualan">Baca Brief di Panduan</a>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
