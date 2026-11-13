<?php
/*
 * TUGAS: penjualan_tambah.php
 *
 * Tujuan:
 * - Menampilkan form penjualan multi-baris.
 * - Memvalidasi input dan mengecek stok.
 * - Menyimpan kepala nota, detail, dan stok keluar dalam satu transaksi.
 *
 * Contoh yang bisa diikuti:
 * - pembelian_tambah.php (pola paling dekat)
 * - assets/transaksi.js (tambah/hapus baris + hitung total)
 *
 * Tabel:
 * - penjualan        : no_penjualan, tanggal, id_kasir, metode_bayar
 * - detail_penjualan : no_penjualan, kode_produk, nama_produk, jumlah, harga_satuan
 * - stok             : kode_produk, tanggal, jumlah_masuk, jumlah_keluar,
 *                      saldo_awal, saldo_akhir, no_penjualan, no_pembelian, keterangan
 *
 * Langkah yang harus dibuat:
 * 1. require config/database.php dan transaksi_helper.php.
 * 2. Siapkan $error, nilai awal form, daftar kasir aktif, dan daftar produk.
 * 3. Jika REQUEST_METHOD === 'POST':
 *    - ambil tanggal, id_kasir, metode_bayar, dan array kode_produk/jumlah/harga_satuan.
 *    - validasi tanggal, kasir, metode (Tunai/QRIS/Debit), dan setiap baris.
 *    - jumlah harus bilangan bulat >= 1; harga harus angka >= 0.
 * 4. Hitung kebutuhan stok per produk. Tolak jika melebihi saldo_stok_terakhir().
 * 5. Jika tidak ada error:
 *    - mysqli_begin_transaction($koneksi)
 *    - $noPenjualan = buat_nomor($koneksi, 'PJ-', 'penjualan', 'no_penjualan')
 *    - INSERT penjualan (no_penjualan, tanggal, id_kasir, metode_bayar)
 *    - per barang: INSERT detail_penjualan, lalu INSERT stok keluar
 *      (jumlah_masuk = 0, jumlah_keluar = jumlah, saldo_akhir = saldo_awal - jumlah)
 *    - mysqli_commit(); header('Location: penjualan_detail.php?no=...'); exit;
 *    - jika gagal: mysqli_rollback() dan tampilkan pesan.
 * 6. Semua proses POST selesai SEBELUM require header.
 * 7. Gunakan prepared statement, htmlspecialchars, dan POST.
 * 8. Tampilkan error dengan alert Bootstrap.
 */
require __DIR__ . '/config/database.php';
require __DIR__ . '/transaksi_helper.php';

$daftarKasir = ambil_kasir_aktif($koneksi);
$daftarProduk = ambil_produk($koneksi);

$judul = 'Kerangka Form Penjualan';
$halaman = 'penjualan';
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <div>
    <span class="badge text-bg-warning mb-2">KERANGKA TUGAS</span>
    <h1 class="h3 mb-1">Form Tambah Penjualan</h1>
    <p class="text-secondary mb-0">
      Tampilan dasar sudah disiapkan. Proses simpan dan cek stok belum dibuat.
    </p>
  </div>
  <a class="btn btn-outline-secondary" href="penjualan.php">Kembali ke Brief</a>
</div>

<div class="alert alert-warning">
  <strong>Tugasmu:</strong>
  <ul class="mb-0 mt-2">
    <li>Tambahkan tombol <strong>Tambah Baris</strong> dan <strong>Simpan Penjualan</strong>.</li>
    <li>Isi otomatis harga satuan dari <code>produk.harga_jual</code>.</li>
    <li>Validasi input dan cek stok sebelum menyimpan.</li>
    <li>Simpan ke <code>penjualan</code>, <code>detail_penjualan</code>, dan <code>stok</code>.</li>
  </ul>
</div>

<div class="alert alert-info">
  <strong>Contoh terdekat:</strong> buka <code>pembelian_tambah.php</code>, lalu
  bandingkan. Perbedaannya hanya nama tabel, kolom harga, dan arah stok
  (masuk vs keluar).
</div>

<div class="card mb-4">
  <div class="card-body">
    <form method="post" action="penjualan_tambah.php">
      <div class="row g-3 mb-4">
        <div class="col-md-4">
          <label class="form-label" for="tanggal">Tanggal Penjualan</label>
          <input class="form-control" type="date" id="tanggal" name="tanggal"
                 value="<?= date('Y-m-d') ?>" required>
        </div>

        <div class="col-md-4">
          <label class="form-label" for="id_kasir">Kasir</label>
          <select class="form-select" id="id_kasir" name="id_kasir" required>
            <option value="">-- pilih kasir --</option>
            <?php foreach ($daftarKasir as $kasir): ?>
              <option value="<?= (int) $kasir['id_kasir'] ?>">
                <?= htmlspecialchars($kasir['nama_kasir']) ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div class="form-text">Hanya kasir aktif yang muncul.</div>
        </div>

        <div class="col-md-4">
          <label class="form-label" for="metode_bayar">Metode Bayar</label>
          <select class="form-select" id="metode_bayar" name="metode_bayar" required>
            <option value="Tunai" selected>Tunai</option>
            <option value="QRIS">QRIS</option>
            <option value="Debit">Debit</option>
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
              <th style="width: 18%;">Harga Satuan</th>
              <th style="width: 17%;" class="text-end">Subtotal</th>
              <th style="width: 15%;" class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr class="baris-item">
              <td>
                <select class="form-select pilih-produk" name="kode_produk[]" required>
                  <option value="">-- pilih produk --</option>
                  <?php foreach ($daftarProduk as $produk): ?>
                    <?php $stok = saldo_stok_terakhir($koneksi, $produk['kode_produk']); ?>
                    <option value="<?= htmlspecialchars($produk['kode_produk'], ENT_QUOTES, 'UTF-8') ?>"
                            data-nama="<?= htmlspecialchars($produk['nama_produk'], ENT_QUOTES, 'UTF-8') ?>"
                            data-harga="<?= (float) $produk['harga_jual'] ?>"
                            data-stok="<?= (int) $stok ?>">
                      <?= htmlspecialchars($produk['kode_produk'] . ' - ' . $produk['nama_produk']) ?>
                      (stok <?= (int) $stok ?>)
                    </option>
                  <?php endforeach; ?>
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
                <button class="btn btn-sm btn-outline-danger btn-hapus-baris" type="button" disabled>Hapus</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 bg-primary text-white rounded p-3 my-3">
        <span>Total Penjualan</span>
        <strong class="fs-4" id="total-nota">Rp 0</strong>
      </div>

      <div class="alert alert-secondary mb-0">
        Tombol <strong>Simpan</strong> belum dibuat. Lengkapi form ini sesuai
        langkah di komentar atas file dan brief di
        <a href="panduan.php#tugas-penjualan">panduan penjualan</a>.
      </div>
    </form>
  </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
