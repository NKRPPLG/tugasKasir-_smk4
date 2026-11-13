<?php
/*
 * TUGAS: penjualan_detail.php
 *
 * Tujuan:
 * - Menampilkan satu nota penjualan berdasarkan $_GET['no'].
 * - Menampilkan isi nota dan mutasi stok keluar.
 *
 * Contoh yang bisa diikuti:
 * - pembelian_detail.php
 *
 * Langkah yang harus dibuat:
 * 1. require config/database.php dan transaksi_helper.php.
 * 2. Ambil $no = trim($_GET['no'] ?? '').
 * 3. Query kepala nota:
 *    SELECT pj.no_penjualan, pj.tanggal, pj.metode_bayar, k.nama_kasir
 *    FROM penjualan pj
 *    LEFT JOIN kasir k ON k.id_kasir = pj.id_kasir
 *    WHERE pj.no_penjualan = ?
 * 4. Query detail:
 *    SELECT kode_produk, nama_produk, jumlah, harga_satuan
 *    FROM detail_penjualan WHERE no_penjualan = ? ORDER BY id_detail
 * 5. Query stok:
 *    SELECT tanggal, kode_produk, jumlah_keluar, saldo_awal, saldo_akhir
 *    FROM stok WHERE no_penjualan = ? ORDER BY id_stok
 * 6. Hitung total = SUM(jumlah * harga_satuan) di PHP.
 * 7. Tampilkan dengan htmlspecialchars dan rupiah().
 * 8. Jika nomor tidak ditemukan, tampilkan pesan yang jelas.
 *
 * Catatan:
 * - Tidak perlu tombol hapus. Nota penjualan adalah riwayat.
 * - Boleh tambahkan tombol "Cetak Nota" dengan window.print().
 */
$judul = 'Tugas Nota Penjualan';
$halaman = 'penjualan';
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <div>
    <span class="badge text-bg-warning mb-2">KERANGKA TUGAS</span>
    <h1 class="h3 mb-1">Nota Penjualan</h1>
    <p class="text-secondary mb-0">
      Halaman ini belum membaca database. Lengkapi sesuai langkah di komentar file.
    </p>
  </div>
  <a class="btn btn-outline-secondary" href="penjualan.php">Kembali ke Brief</a>
</div>

<div class="alert alert-warning">
  <strong>Yang harus tampil di halaman ini:</strong>
  <ul class="mb-0 mt-2">
    <li>Nomor nota, tanggal, kasir, dan metode bayar.</li>
    <li>Tabel barang: kode, nama, jumlah, harga satuan, subtotal.</li>
    <li>Total barang dan total nilai nota.</li>
    <li>Tabel dampak stok: saldo awal, jumlah keluar, saldo akhir.</li>
  </ul>
</div>

<div class="card mb-4">
  <div class="card-body">
    <div class="d-flex flex-wrap justify-content-between gap-2 border-bottom pb-3 mb-3">
      <div>
        <h2 class="h4 mb-1">PJ-XXXX</h2>
        <div class="text-secondary small">
          Tanggal &middot; Kasir &middot; Metode Bayar
        </div>
      </div>
      <div class="text-end">
        <div class="text-secondary small">Total Nota</div>
        <div class="fs-4 fw-bold text-primary">Rp 0</div>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-sm align-middle">
        <thead class="table-light">
          <tr>
            <th>Kode</th>
            <th>Nama Produk</th>
            <th class="text-end">Jumlah</th>
            <th class="text-end">Harga Satuan</th>
            <th class="text-end">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="5" class="text-center text-secondary py-4">
              Data detail belum diisi. Lengkapi query di komentar file.
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="card mb-4">
  <div class="card-header bg-white fw-semibold">Dampak ke Stok</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-sm align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Tanggal</th>
            <th>Kode Produk</th>
            <th class="text-end">Keluar</th>
            <th class="text-end">Saldo Awal</th>
            <th class="text-end">Saldo Akhir</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="5" class="text-center text-secondary py-4">
              Mutasi stok belum ditampilkan. Query tabel <code>stok</code> dengan
              <code>no_penjualan = ?</code>.
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="alert alert-info mb-0">
  <strong>Referensi:</strong> bandingkan dengan
  <a href="pembelian_detail.php?no=PB-0001" class="alert-link">nota pembelian</a>
  yang sudah selesai. Perhatikan bahwa penjualan memakai
  <code>jumlah_keluar</code>, bukan <code>jumlah_masuk</code>.
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
