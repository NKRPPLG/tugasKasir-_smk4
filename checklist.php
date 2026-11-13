<?php
// ============================================================
// kasirsmk/checklist.php
// Checklist penyelesaian aplikasi KasirSMK: Master -> Transaksi -> Report.
//
// Centang disimpan di browser (localStorage), jadi tidak butuh database.
// Halaman ini hanya membaca daftar item di bawah; tidak ada query.
// ============================================================
$judul = 'Checklist Penyelesaian Aplikasi';
$halaman = 'checklist';

$fase = [
    [
        'kode' => 'A',
        'judul' => 'Fondasi',
        'target' => '±15 menit · pastikan semua sudah siap sebelum menulis modul',
        'warna' => 'secondary',
        'item' => [
            [
                'kode' => 'A1',
                'judul' => 'Koneksi database jalan',
                'file' => 'config/database.php',
                'bukti' => 'Buka index.php, tidak ada pesan "koneksi gagal". Database db_penjualan berisi 8 tabel.',
                'status' => 'contoh',
            ],
            [
                'kode' => 'A2',
                'judul' => 'Header & footer dipakai semua halaman',
                'file' => 'partials/header.php, partials/footer.php',
                'bukti' => 'Navbar dan footer tampil sama di produk, kasir, pembelian, penjualan.',
                'status' => 'contoh',
            ],
            [
                'kode' => 'A3',
                'judul' => 'Helper transaksi lengkap',
                'file' => 'transaksi_helper.php',
                'bukti' => 'Ada 6 fungsi: rupiah, saldo_stok_terakhir, buat_nomor, ambil_kasir_aktif, ambil_supplier, ambil_produk.',
                'status' => 'contoh',
            ],
            [
                'kode' => 'A4',
                'judul' => 'Aset lokal siap tanpa internet',
                'file' => 'assets/bootstrap, assets/jquery, assets/transaksi.js',
                'bukti' => 'Matikan Wi-Fi, halaman tetap tampil rapi dan form transaksi tetap menghitung.',
                'status' => 'contoh',
            ],
        ],
    ],
    [
        'kode' => 'B',
        'judul' => 'Master',
        'target' => '±3 jam · produk selesai, kasir & supplier menyusul',
        'warna' => 'primary',
        'item' => [
            [
                'kode' => 'B1',
                'judul' => 'Produk: daftar + pencarian',
                'file' => 'produk.php',
                'bukti' => 'Tabel produk tampil, pencarian kode/nama berfungsi, tombol Edit & Hapus ada.',
                'status' => 'contoh',
            ],
            [
                'kode' => 'B2',
                'judul' => 'Produk: tambah',
                'file' => 'produk_tambah.php',
                'bukti' => 'Simpan produk baru, lalu muncul di daftar. Kode dobel ditolak.',
                'status' => 'contoh',
            ],
            [
                'kode' => 'B3',
                'judul' => 'Produk: edit',
                'file' => 'produk_edit.php',
                'bukti' => 'Form terisi data lama, perubahan tersimpan, redirect status=edit.',
                'status' => 'contoh',
            ],
            [
                'kode' => 'B4',
                'judul' => 'Produk: hapus + pengaman',
                'file' => 'produk_hapus.php',
                'bukti' => 'Produk yang dipakai nota ditolak; produk baru bisa dihapus.',
                'status' => 'contoh',
            ],
            [
                'kode' => 'B5',
                'judul' => 'Kasir: daftar',
                'file' => 'kasir.php',
                'bukti' => 'Tabel kasir + status aktif/nonaktif + tanggal keluar tampil.',
                'status' => 'contoh',
            ],
            [
                'kode' => 'B6',
                'judul' => 'Kasir: tambah (lengkapi proses simpan)',
                'file' => 'kasir_tambah.php',
                'bukti' => 'Form tersedia, tinggal menambahkan validasi + INSERT + redirect.',
                'status' => 'tugas',
            ],
            [
                'kode' => 'B7',
                'judul' => 'Kasir: edit',
                'file' => 'kasir_edit.php',
                'bukti' => 'Ubah nama kasir, tersimpan, kembali ke kasir.php?status=edit.',
                'status' => 'tugas',
            ],
            [
                'kode' => 'B8',
                'judul' => 'Kasir: nonaktifkan (bukan hapus)',
                'file' => 'kasir_nonaktifkan.php',
                'bukti' => 'Status jadi nonaktif, tanggal_keluar = hari ini, data kasir tetap ada.',
                'status' => 'tugas',
            ],
            [
                'kode' => 'B9',
                'judul' => 'Supplier: daftar + pencarian',
                'file' => 'supplier.php',
                'bukti' => 'Tabel supplier tampil, tombol Tambah/Edit/Hapus ada.',
                'status' => 'tugas',
            ],
            [
                'kode' => 'B10',
                'judul' => 'Supplier: tambah',
                'file' => 'supplier_tambah.php',
                'bukti' => 'Supplier baru tersimpan dan muncul di daftar.',
                'status' => 'tugas',
            ],
            [
                'kode' => 'B11',
                'judul' => 'Supplier: edit',
                'file' => 'supplier_edit.php',
                'bukti' => 'Nama/kota bisa diubah, data lama tampil di form.',
                'status' => 'tugas',
            ],
            [
                'kode' => 'B12',
                'judul' => 'Supplier: hapus + pengaman',
                'file' => 'supplier_hapus.php',
                'bukti' => 'Supplier yang dipakai pembelian ditolak; yang belum dipakai terhapus.',
                'status' => 'tugas',
            ],
            [
                'kode' => 'B13',
                'judul' => 'Menu master lengkap',
                'file' => 'partials/header.php',
                'bukti' => 'Navbar memuat Produk, Kasir, Supplier (tautan supplier dibuka dari komentar).',
                'status' => 'tugas',
            ],
        ],
    ],
    [
        'kode' => 'C',
        'judul' => 'Transaksi',
        'target' => '±4 jam · pembelian jadi contoh, penjualan dikerjakan sendiri',
        'warna' => 'success',
        'item' => [
            [
                'kode' => 'C1',
                'judul' => 'Pembelian: daftar + pencarian',
                'file' => 'pembelian.php',
                'bukti' => 'Daftar nota, total nilai, dan tombol Detail tampil.',
                'status' => 'contoh',
            ],
            [
                'kode' => 'C2',
                'judul' => 'Pembelian: form multi-baris',
                'file' => 'pembelian_tambah.php',
                'bukti' => 'Tambah baris, harga terisi otomatis, subtotal & total berubah.',
                'status' => 'contoh',
            ],
            [
                'kode' => 'C3',
                'judul' => 'Pembelian: detail nota + dampak stok',
                'file' => 'pembelian_detail.php',
                'bukti' => 'Nota menampilkan barang dan baris stok masuk yang sesuai.',
                'status' => 'contoh',
            ],
            [
                'kode' => 'C4',
                'judul' => 'Penjualan: daftar nota',
                'file' => 'penjualan.php',
                'bukti' => 'Tabel nota penjualan + total nilai + tombol Detail.',
                'status' => 'tugas',
            ],
            [
                'kode' => 'C5',
                'judul' => 'Penjualan: form multi-baris + cek stok',
                'file' => 'penjualan_tambah.php',
                'bukti' => 'Barang melebihi stok ditolak sebelum disimpan.',
                'status' => 'tugas',
            ],
            [
                'kode' => 'C6',
                'judul' => 'Penjualan: detail nota',
                'file' => 'penjualan_detail.php',
                'bukti' => 'Nota menampilkan barang, harga saat transaksi, dan stok keluar.',
                'status' => 'tugas',
            ],
            [
                'kode' => 'C7',
                'judul' => 'Stok keluar tercatat benar',
                'file' => 'tabel stok',
                'bukti' => 'jumlah_keluar > 0, no_penjualan terisi, saldo_akhir = saldo_awal - jumlah.',
                'status' => 'tugas',
            ],
            [
                'kode' => 'C8',
                'judul' => 'Transaksi database dipakai',
                'file' => 'penjualan_tambah.php',
                'bukti' => 'begin_transaction + commit/rollback; kalau satu barang gagal, tidak ada data tersimpan.',
                'status' => 'tugas',
            ],
            [
                'kode' => 'C9',
                'judul' => 'Nomor nota berurutan',
                'file' => 'transaksi_helper.php',
                'bukti' => 'PB-0001, PB-0002, ... dan PJ-0001, PJ-0002, ... tanpa nomor dobel.',
                'status' => 'tugas',
            ],
            [
                'kode' => 'C10',
                'judul' => 'Hub transaksi menautkan semua modul',
                'file' => 'index.php / dashboard',
                'bukti' => 'Dari dashboard bisa masuk ke produk, kasir, supplier, pembelian, penjualan, laporan.',
                'status' => 'tugas',
            ],
        ],
    ],
    [
        'kode' => 'D',
        'judul' => 'Report',
        'target' => '±3 jam · empat laporan wajib, satu halaman cetak',
        'warna' => 'warning',
        'item' => [
            [
                'kode' => 'D1',
                'judul' => 'Laporan penjualan per periode',
                'file' => 'laporan_penjualan.php',
                'bukti' => 'Pilih tanggal awal & akhir, muncul daftar nota + total item + total nilai.',
                'status' => 'tugas',
                'sql' => "SELECT pj.no_penjualan, pj.tanggal, k.nama_kasir,\n"
                    . "       SUM(d.jumlah) AS total_item,\n"
                    . "       SUM(d.jumlah * d.harga_satuan) AS total_nilai\n"
                    . "FROM penjualan pj\n"
                    . "JOIN detail_penjualan d ON d.no_penjualan = pj.no_penjualan\n"
                    . "JOIN kasir k ON k.id_kasir = pj.id_kasir\n"
                    . "WHERE pj.tanggal BETWEEN ? AND ?\n"
                    . "GROUP BY pj.no_penjualan, pj.tanggal, k.nama_kasir\n"
                    . "ORDER BY pj.tanggal DESC;",
            ],
            [
                'kode' => 'D2',
                'judul' => 'Laporan pembelian per periode',
                'file' => 'laporan_pembelian.php',
                'bukti' => 'Daftar nota pembelian + supplier + total nilai pada rentang tanggal.',
                'status' => 'tugas',
                'sql' => "SELECT p.no_pembelian, p.tanggal, s.nama_supplier,\n"
                    . "       SUM(d.jumlah * d.harga_beli) AS total_nilai\n"
                    . "FROM pembelian p\n"
                    . "JOIN detail_pembelian d ON d.no_pembelian = p.no_pembelian\n"
                    . "JOIN supplier s ON s.id_supplier = p.id_supplier\n"
                    . "WHERE p.tanggal BETWEEN ? AND ?\n"
                    . "GROUP BY p.no_pembelian, p.tanggal, s.nama_supplier\n"
                    . "ORDER BY p.tanggal DESC;",
            ],
            [
                'kode' => 'D3',
                'judul' => 'Laporan stok terkini',
                'file' => 'laporan_stok.php',
                'bukti' => 'Satu baris per produk, memakai saldo_akhir terakhir; produk stok <= 5 ditandai.',
                'status' => 'tugas',
                'sql' => "SELECT p.kode_produk, p.nama_produk,\n"
                    . "       COALESCE(s.saldo_akhir, p.stok_awal) AS stok\n"
                    . "FROM produk p\n"
                    . "LEFT JOIN stok s ON s.id_stok = (\n"
                    . "    SELECT MAX(id_stok) FROM stok\n"
                    . "    WHERE kode_produk = p.kode_produk\n"
                    . ")\n"
                    . "ORDER BY stok ASC, p.nama_produk;",
            ],
            [
                'kode' => 'D4',
                'judul' => 'Laporan laba kotor',
                'file' => 'laporan_laba.php',
                'bukti' => 'Omzet - modal = laba per nota. Catatan: modal memakai harga_beli produk saat ini.',
                'status' => 'tugas',
                'sql' => "SELECT pj.no_penjualan, pj.tanggal,\n"
                    . "       SUM(d.jumlah * d.harga_satuan) AS omzet,\n"
                    . "       SUM(d.jumlah * p.harga_beli) AS modal,\n"
                    . "       SUM(d.jumlah * (d.harga_satuan - p.harga_beli)) AS laba\n"
                    . "FROM penjualan pj\n"
                    . "JOIN detail_penjualan d ON d.no_penjualan = pj.no_penjualan\n"
                    . "JOIN produk p ON p.kode_produk = d.kode_produk\n"
                    . "WHERE pj.tanggal BETWEEN ? AND ?\n"
                    . "GROUP BY pj.no_penjualan, pj.tanggal;",
            ],
            [
                'kode' => 'D5',
                'judul' => 'Ringkasan angka di atas tabel',
                'file' => 'semua halaman laporan',
                'bukti' => 'Kartu ringkas: jumlah nota, total item, total rupiah. Angka cocok dengan tabel.',
                'status' => 'tugas',
            ],
            [
                'kode' => 'D6',
                'judul' => 'Filter wajib, bukan opsional',
                'file' => 'semua halaman laporan',
                'bukti' => 'Tanggal kosong memakai default (bulan ini). Parameter memakai prepared statement.',
                'status' => 'tugas',
            ],
            [
                'kode' => 'D7',
                'judul' => 'Halaman bisa dicetak',
                'file' => 'assets/style.css',
                'bukti' => 'Ctrl+P: navbar dan tombol hilang, tabel tetap rapi dan terbaca.',
                'status' => 'tugas',
            ],
        ],
    ],
    [
        'kode' => 'E',
        'judul' => 'Finalisasi',
        'target' => '±1 jam · uji, rapikan, siap dipresentasikan',
        'warna' => 'danger',
        'item' => [
            [
                'kode' => 'E1',
                'judul' => 'Dashboard ringkas',
                'file' => 'index.php',
                'bukti' => 'Menampilkan jumlah produk, nota hari ini, stok menipis, dan tautan ke semua modul.',
                'status' => 'tugas',
            ],
            [
                'kode' => 'E2',
                'judul' => 'Semua query memakai prepared statement',
                'file' => 'semua halaman',
                'bukti' => 'Cari input yang disambung langsung ke SQL. Tidak boleh ada.',
                'status' => 'tugas',
            ],
            [
                'kode' => 'E3',
                'judul' => 'Semua output di-escape',
                'file' => 'semua halaman',
                'bukti' => 'Setiap echo data database memakai htmlspecialchars.',
                'status' => 'tugas',
            ],
            [
                'kode' => 'E4',
                'judul' => 'Aksi ubah data memakai POST',
                'file' => 'hapus / nonaktifkan / simpan',
                'bukti' => 'Tidak ada hapus lewat link GET. Tombol konfirmasi ada di dalam form method="post".',
                'status' => 'tugas',
            ],
            [
                'kode' => 'E5',
                'judul' => 'Uji data lengkap',
                'file' => 'phpMyAdmin',
                'bukti' => '3 pembelian + 3 penjualan. Saldo stok tiap produk bisa dihitung ulang dan cocok.',
                'status' => 'tugas',
            ],
            [
                'kode' => 'E6',
                'judul' => 'Tidak ada warning PHP',
                'file' => 'semua halaman',
                'bukti' => 'Buka semua halaman: tidak ada Warning, Notice, atau Fatal error.',
                'status' => 'tugas',
            ],
            [
                'kode' => 'E7',
                'judul' => 'Dokumentasi & presentasi siap',
                'file' => 'README.md, panduan.php, presentasi.php',
                'bukti' => 'Cara menjalankan proyek tertulis, dan slide showcase bisa dibuka.',
                'status' => 'tugas',
            ],
        ],
    ],
];

$totalItem = 0;
$totalContoh = 0;
foreach ($fase as $f) {
    $totalItem += count($f['item']);
    foreach ($f['item'] as $it) {
        if ($it['status'] === 'contoh') {
            $totalContoh++;
        }
    }
}
?>
<?php require __DIR__ . '/partials/header.php'; ?>

<style>
  .checklist-item.done .judul-item {
    text-decoration: line-through;
    color: #6c757d;
  }
  .checklist-item.done {
    background: #f8f9fa;
  }
  .checklist-sql {
    font-size: .78rem;
    white-space: pre-wrap;
    margin-bottom: 0;
  }
  @media print {
    nav, .no-print, footer {
      display: none !important;
    }
    .card {
      break-inside: avoid;
      border: 1px solid #ccc !important;
    }
    .progress {
      border: 1px solid #ccc;
    }
  }
</style>

<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
  <div>
    <span class="badge text-bg-warning mb-2">Checklist Proyek</span>
    <h1 class="h3 mb-1">Menyelesaikan Aplikasi KasirSMK</h1>
    <p class="text-secondary mb-0">
      Urutannya: <strong>Master</strong> &rarr; <strong>Transaksi</strong> &rarr;
      <strong>Report</strong>. Centang disimpan di browser ini, jadi aman
      ditinggal dan dilanjutkan besok.
    </p>
  </div>
  <div class="no-print d-flex flex-wrap gap-2">
    <button class="btn btn-primary" type="button" id="btn-print">Cetak Checklist</button>
    <button class="btn btn-outline-secondary" type="button" id="btn-reset">Reset Centang</button>
  </div>
</div>

<div class="card mb-4">
  <div class="card-body">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
      <strong>Progres keseluruhan</strong>
      <span class="text-secondary small" id="total-teks">0 dari <?= $totalItem ?> item selesai</span>
    </div>
    <div class="progress" style="height: 20px;" role="progressbar"
         aria-label="Progres keseluruhan" aria-valuemin="0" aria-valuemax="<?= $totalItem ?>" id="total-progress">
      <div class="progress-bar bg-success" id="total-bar" style="width: 0%">0%</div>
    </div>
    <p class="text-secondary small mb-0 mt-2">
      <?= $totalContoh ?> item sudah ada contohnya di aplikasi (badge hijau).
      Sisanya tugas yang harus kamu tulis sendiri.
    </p>
    <div class="form-check form-switch mt-3 no-print">
      <input class="form-check-input" type="checkbox" id="sembunyikan-selesai">
      <label class="form-check-label" for="sembunyikan-selesai">Sembunyikan item yang sudah selesai</label>
    </div>
  </div>
</div>

<?php foreach ($fase as $f): ?>
  <?php
  $jumlahFase = count($f['item']);
  $selesaiContoh = 0;
  foreach ($f['item'] as $it) {
      if ($it['status'] === 'contoh') {
          $selesaiContoh++;
      }
  }
  ?>
  <section class="card mb-4" id="fase-<?= strtolower($f['kode']) ?>">
    <div class="card-header bg-white">
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div class="d-flex align-items-center gap-2">
          <span class="badge text-bg-<?= $f['warna'] ?> fs-6"><?= $f['kode'] ?></span>
          <strong class="fs-5"><?= htmlspecialchars($f['judul']) ?></strong>
          <span class="text-secondary small"><?= $jumlahFase ?> item &middot; <?= $selesaiContoh ?> contoh selesai</span>
        </div>
        <span class="text-secondary small" data-fase-teks="<?= $f['kode'] ?>">0 / <?= $jumlahFase ?></span>
      </div>
      <p class="text-secondary small mb-2 mt-1"><?= htmlspecialchars($f['target']) ?></p>
      <div class="progress" style="height: 8px;" role="progressbar" aria-label="Progres fase <?= $f['kode'] ?>"
           aria-valuemin="0" aria-valuemax="<?= $jumlahFase ?>">
        <div class="progress-bar bg-<?= $f['warna'] ?>" data-fase-bar="<?= $f['kode'] ?>" style="width: 0%"></div>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-sm align-middle mb-0">
        <tbody>
        <?php foreach ($f['item'] as $it): ?>
          <?php $idCek = 'cek-' . strtolower($it['kode']); ?>
          <tr class="checklist-item" data-kode="<?= $it['kode'] ?>">
            <td style="width: 44px;" class="ps-3">
              <input class="form-check-input item-check" type="checkbox"
                     id="<?= $idCek ?>" data-kode="<?= $it['kode'] ?>">
            </td>
            <td>
              <label class="fw-semibold d-block mb-1 judul-item" for="<?= $idCek ?>">
                <?= $it['kode'] ?> &middot; <?= htmlspecialchars($it['judul']) ?>
              </label>
              <div class="small text-secondary">
                <code><?= htmlspecialchars($it['file']) ?></code>
                &mdash; <?= htmlspecialchars($it['bukti']) ?>
              </div>
              <?php if (!empty($it['sql'])): ?>
                <details class="mt-2">
                  <summary class="small text-primary">Lihat contoh query</summary>
                  <pre class="bg-light border rounded p-2 mt-2 checklist-sql"><code><?= htmlspecialchars($it['sql']) ?></code></pre>
                </details>
              <?php endif; ?>
            </td>
            <td class="text-end pe-3" style="width: 130px;">
              <?php if ($it['status'] === 'contoh'): ?>
                <span class="badge text-bg-success">Contoh selesai</span>
              <?php else: ?>
                <span class="badge text-bg-warning">Tugas</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>
<?php endforeach; ?>

<div class="alert alert-secondary small no-print">
  <strong>Catatan penyimpanan:</strong> centang hanya tersimpan di browser yang
  kamu pakai (localStorage). Kalau pindah komputer atau menghapus data browser,
  centangnya hilang. Untuk laporan ke pelatih, gunakan tombol
  <em>Cetak Checklist</em> lalu simpan sebagai PDF.
</div>

<script>
(function () {
  "use strict";

  var KUNCI = "kasirsmk-checklist-v1";
  var faseKode = <?= json_encode(array_map(function ($f) {
      return $f['kode'];
  }, $fase)) ?>;
  var semuaKode = <?= json_encode(array_map(function ($f) {
      return array_map(function ($it) {
          return $it['kode'];
      }, $f['item']);
  }, $fase)) ?>;

  var checks = Array.prototype.slice.call(document.querySelectorAll(".item-check"));
  var totalBar = document.getElementById("total-bar");
  var totalTeks = document.getElementById("total-teks");
  var totalProgress = document.getElementById("total-progress");
  var sembunyikan = document.getElementById("sembunyikan-selesai");

  function baca() {
    try {
      var isi = JSON.parse(window.localStorage.getItem(KUNCI) || "[]");
      return Array.isArray(isi) ? isi : [];
    } catch (e) {
      return [];
    }
  }

  function simpan(daftar) {
    try {
      window.localStorage.setItem(KUNCI, JSON.stringify(daftar));
    } catch (e) {
      // Mode privat bisa menolak; centang tetap jalan di halaman ini.
    }
  }

  function terapkan() {
    var selesai = baca();

    checks.forEach(function (c) {
      var aktif = selesai.indexOf(c.getAttribute("data-kode")) !== -1;
      c.checked = aktif;
      c.closest("tr").classList.toggle("done", aktif);
    });

    var totalSelesai = 0;

    faseKode.forEach(function (kode, i) {
      var kodeFase = semuaKode[i];
      var jumlah = 0;

      checks.forEach(function (c) {
        var k = c.getAttribute("data-kode");
        if (kodeFase.indexOf(k) !== -1 && c.checked) {
          jumlah += 1;
        }
      });

      totalSelesai += jumlah;

      var bar = document.querySelector('[data-fase-bar="' + kode + '"]');
      var teks = document.querySelector('[data-fase-teks="' + kode + '"]');

      if (bar) {
        bar.style.width = ((jumlah / kodeFase.length) * 100) + "%";
      }
      if (teks) {
        teks.textContent = jumlah + " / " + kodeFase.length;
      }
    });

    var persen = checks.length ? Math.round((totalSelesai / checks.length) * 100) : 0;

    if (totalBar) {
      totalBar.style.width = persen + "%";
      totalBar.textContent = persen + "%";
    }
    if (totalProgress) {
      totalProgress.setAttribute("aria-valuenow", String(totalSelesai));
    }
    if (totalTeks) {
      totalTeks.textContent = totalSelesai + " dari " + checks.length + " item selesai";
    }

    if (sembunyikan && sembunyikan.checked) {
      checks.forEach(function (c) {
        c.closest("tr").style.display = c.checked ? "none" : "";
      });
    } else {
      checks.forEach(function (c) {
        c.closest("tr").style.display = "";
      });
    }
  }

  checks.forEach(function (c) {
    c.addEventListener("change", function () {
      var selesai = baca();
      var kode = c.getAttribute("data-kode");
      var posisi = selesai.indexOf(kode);

      if (c.checked && posisi === -1) {
        selesai.push(kode);
      }
      if (!c.checked && posisi !== -1) {
        selesai.splice(posisi, 1);
      }

      simpan(selesai);
      terapkan();
    });
  });

  if (sembunyikan) {
    sembunyikan.addEventListener("change", terapkan);
  }

  var btnReset = document.getElementById("btn-reset");
  if (btnReset) {
    btnReset.addEventListener("click", function () {
      if (window.confirm("Hapus semua centang di browser ini?")) {
        simpan([]);
        terapkan();
      }
    });
  }

  var btnPrint = document.getElementById("btn-print");
  if (btnPrint) {
    btnPrint.addEventListener("click", function () {
      window.print();
    });
  }

  terapkan();
})();
</script>

<?php require __DIR__ . '/partials/footer.php'; ?>
