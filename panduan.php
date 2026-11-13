<?php
$judul = 'Panduan Proyek';
$halaman = 'panduan';
require __DIR__ . '/partials/header.php';
?>

<div class="page-hero p-4 p-md-5 mb-4">
  <span class="badge text-bg-warning mb-2">Panduan Pembuatan</span>
  <h1 class="display-6 fw-bold">Proyek KasirSMK</h1>
  <p class="lead mb-3">
    Panduan lengkap untuk memahami contoh CRUD produk langkah demi langkah,
    termasuk jQuery, lalu melengkapi modul kasir, supplier, dan penjualan.
    Contoh pembelian sudah selesai dan bisa dipakai sebagai acuan. Semua materi
    bisa dibaca langsung di web tanpa slide.
  </p>
  <a class="btn btn-warning fw-semibold" href="#produk">Mulai Penjelasan Produk</a>
  <a class="btn btn-outline-light" href="presentasi.php">Mode Presentasi</a>
  <a class="btn btn-outline-light" href="#alur-pembelian">Alur Pembelian</a>
  <a class="btn btn-outline-light" href="#tugas-penjualan">Tugas Penjualan</a>
  <a class="btn btn-outline-light" href="#tugas-kasir">Brief Kasir</a>
  <a class="btn btn-outline-light" href="#tugas-supplier">Brief Supplier</a>
</div>

<div class="card mb-4">
  <div class="card-body">
    <h2 class="h5">Daftar Isi</h2>
    <div class="d-flex flex-wrap gap-2">
      <a class="btn btn-sm btn-outline-primary" href="#peta-folder">Peta Folder</a>
      <a class="btn btn-sm btn-outline-primary" href="#bootstrap">Bootstrap</a>
      <a class="btn btn-sm btn-outline-primary" href="#database">Database</a>
      <a class="btn btn-sm btn-outline-primary" href="#produk">Penjelasan Produk</a>
      <a class="btn btn-sm btn-outline-primary" href="#produk-daftar">Daftar &amp; Cari</a>
      <a class="btn btn-sm btn-outline-primary" href="#produk-tambah">Tambah</a>
      <a class="btn btn-sm btn-outline-primary" href="#produk-edit">Edit</a>
      <a class="btn btn-sm btn-outline-primary" href="#produk-hapus">Hapus</a>
      <a class="btn btn-sm btn-outline-primary" href="#jquery">jQuery</a>
      <a class="btn btn-sm btn-outline-primary" href="#hasil-produk">Hasil Akhir</a>
      <a class="btn btn-sm btn-outline-primary" href="#tugas-kasir">Tugas Kasir</a>
      <a class="btn btn-sm btn-outline-primary" href="#tugas-supplier">Tugas Supplier</a>
      <a class="btn btn-sm btn-outline-primary" href="#alur-pembelian">Alur Pembelian</a>
      <a class="btn btn-sm btn-outline-primary" href="#tugas-penjualan">Tugas Penjualan</a>
      <a class="btn btn-sm btn-outline-primary" href="#checklist">Checklist</a>
      <a class="btn btn-sm btn-outline-primary" href="#kesalahan">Kesalahan Umum</a>
    </div>
  </div>
</div>

<div class="alert alert-success">
  <strong>Alur produk:</strong> bagian 4 menjelaskan setiap form dari HTML,
  PHP, sampai jQuery. Bagian 5 berisi tautan ke hasil akhir yang bisa langsung
  dicoba. Baca penjelasannya dulu, lalu buka hasil akhirnya.
</div>

<div class="alert alert-info">
  <strong>Penting:</strong> <code>kasir.php</code> dan
  <code>kasir_tambah.php</code> sudah berisi contoh daftar dan contoh form
  tanpa tombol simpan. Modul <code>pembelian*.php</code> sudah selesai dan
  menjadi acuan. File <code>kasir_edit.php</code>,
  <code>kasir_nonaktifkan.php</code>, seluruh <code>supplier*.php</code>, dan
  <code>penjualan*.php</code> masih berupa kerangka tugas. Buka file tersebut
  di editor kode untuk membaca brief tugasnya.
</div>

<section id="peta-folder" class="card mb-4 anchor-target">
  <div class="card-header bg-white fw-semibold">1. Peta Folder Proyek</div>
  <div class="card-body">
    <pre class="bg-dark text-light p-3 rounded code-block"><code>smk4/kasirsmk/
├── partials/
│   ├── header.php          # Bootstrap navbar, CSS, pembuka container
│   └── footer.php          # penutup container, footer, JS Bootstrap/jQuery
├── config/
│   └── database.php        # koneksi ke db_penjualan
├── assets/
│   ├── bootstrap/
│   │   ├── css/bootstrap.min.css
│   │   └── js/bootstrap.bundle.min.js
│   ├── jquery/             # jQuery 3.7.1 lokal
│   ├── produk.js           # jQuery modul produk
│   ├── transaksi.js        # jQuery form transaksi (baris + total)
│   └── style.css
├── index.php               # dashboard proyek
├── panduan.php             # halaman ini
├── produk.php              # READ + pencarian
├── produk_tambah.php       # CREATE
├── produk_edit.php         # UPDATE
├── produk_hapus.php        # DELETE
├── kasir.php               # CONTOH: daftar kasir
├── kasir_tambah.php        # CONTOH: form tanpa simpan
├── kasir_edit.php          # TUGAS: edit kasir
├── kasir_nonaktifkan.php   # TUGAS: soft delete kasir
├── supplier.php            # TUGAS: daftar supplier
├── supplier_tambah.php     # TUGAS: tambah supplier
├── supplier_edit.php       # TUGAS: edit supplier
├── supplier_hapus.php      # TUGAS: hapus supplier + cek pemakaian
├── transaksi_helper.php    # fungsi bantu transaksi
├── pembelian.php           # CONTOH: daftar pembelian
├── pembelian_tambah.php    # CONTOH: form multi-baris + stok masuk
├── pembelian_detail.php    # CONTOH: nota + dampak stok
├── penjualan.php           # TUGAS: brief + daftar penjualan
├── penjualan_tambah.php    # TUGAS: kerangka form + stok keluar
├── penjualan_detail.php    # TUGAS: kerangka nota penjualan
└── README.md</code></pre>
    <p class="mb-0 text-secondary">
      Semua halaman berada di root proyek agar path
      <code>assets/bootstrap/...</code> dan <code>assets/style.css</code>
      langsung bekerja tanpa pengaturan tambahan.
    </p>
  </div>
</section>

<section id="bootstrap" class="card mb-4 anchor-target">
  <div class="card-header bg-white fw-semibold">2. Bootstrap Lokal</div>
  <div class="card-body">
    <p>
      Proyek ini memakai Bootstrap 5 dari file lokal, bukan CDN internet.
      Tujuannya agar tetap tampil rapi walaupun lab tidak terhubung internet.
    </p>
    <p>Di <code>partials/header.php</code>:</p>
    <pre class="bg-dark text-light p-3 rounded code-block"><code>&lt;link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"&gt;
&lt;link rel="stylesheet" href="assets/style.css"&gt;</code></pre>
    <p>Di <code>partials/footer.php</code>:</p>
    <pre class="bg-dark text-light p-3 rounded code-block"><code>&lt;script src="assets/bootstrap/js/bootstrap.bundle.min.js"&gt;&lt;/script&gt;</code></pre>
    <p class="mb-0">
      Urutan penting: Bootstrap dimuat dulu, lalu <code>style.css</code>.
      Dengan begitu CSS buatan sendiri bisa menimpa Bootstrap bila perlu.
    </p>
  </div>
</section>

<section id="database" class="card mb-4 anchor-target">
  <div class="card-header bg-white fw-semibold">3. Database dan Tabel</div>
  <div class="card-body">
    <p>
      Proyek memakai database <code>db_penjualan</code>. Di dalamnya sudah ada
      tabel yang dibutuhkan:
    </p>
    <div class="table-responsive">
      <table class="table table-bordered table-sm align-middle">
        <thead class="table-light">
          <tr>
            <th>Tabel</th>
            <th>Primary Key</th>
            <th>Field Penting</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><code>produk</code></td>
            <td><code>kode_produk</code></td>
            <td><code>nama_produk</code>, <code>harga_beli</code>, <code>harga_jual</code>, <code>stok_awal</code></td>
          </tr>
          <tr>
            <td><code>kasir</code></td>
            <td><code>id_kasir</code> (auto increment)</td>
            <td><code>nama_kasir</code>, <code>status</code>, <code>tanggal_keluar</code></td>
          </tr>
          <tr>
            <td><code>supplier</code></td>
            <td><code>id_supplier</code> (auto increment)</td>
            <td><code>nama_supplier</code>, <code>kota</code></td>
          </tr>
          <tr>
            <td><code>penjualan</code></td>
            <td><code>no_penjualan</code></td>
            <td><code>id_kasir</code>, <code>tanggal</code>, <code>metode_bayar</code></td>
          </tr>
          <tr>
            <td><code>pembelian</code></td>
            <td><code>no_pembelian</code></td>
            <td><code>id_kasir</code>, <code>id_supplier</code>, <code>tanggal</code></td>
          </tr>
          <tr>
            <td><code>detail_pembelian</code></td>
            <td><code>id_detail</code> (auto increment)</td>
            <td><code>no_pembelian</code>, <code>kode_produk</code>, <code>nama_produk</code>, <code>jumlah</code>, <code>harga_beli</code></td>
          </tr>
          <tr>
            <td><code>detail_penjualan</code></td>
            <td><code>id_detail</code> (auto increment)</td>
            <td><code>no_penjualan</code>, <code>kode_produk</code>, <code>nama_produk</code>, <code>jumlah</code>, <code>harga_satuan</code></td>
          </tr>
          <tr>
            <td><code>stok</code></td>
            <td><code>id_stok</code> (auto increment)</td>
            <td><code>kode_produk</code>, <code>jumlah_masuk</code>, <code>jumlah_keluar</code>, <code>saldo_awal</code>, <code>saldo_akhir</code>, <code>no_pembelian</code>, <code>no_penjualan</code></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="alert alert-warning mb-0">
      <strong>Perhatikan:</strong> tabel <code>kasir</code> memakai
      <code>status</code> dan <code>tanggal_keluar</code>. Kasir yang keluar
      tidak dihapus, tetapi dinonaktifkan agar riwayat transaksi tetap utuh.
      Tabel <code>detail_*</code> menyimpan snapshot nama dan harga, sedangkan
      <code>stok</code> menyimpan riwayat saldo.
    </div>
  </div>
</section>

<section id="produk" class="card mb-4 anchor-target">
  <div class="card-header bg-white fw-semibold">4. Penjelasan Produk per Form</div>
  <div class="card-body">
    <p>
      Modul produk terdiri dari empat form. Setiap form dibahas dengan urutan
      yang sama supaya mudah diikuti: <strong>tujuan, file, alur, kode inti,
      jQuery, lalu kesalahan umum</strong>.
    </p>

    <div class="table-responsive mb-4">
      <table class="table table-bordered table-sm">
        <thead class="table-light">
          <tr>
            <th>Form</th>
            <th>File</th>
            <th>Tugas utama</th>
            <th>jQuery</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Daftar &amp; Cari</td>
            <td><code>produk.php</code></td>
            <td>GET, SELECT, pencarian, tabel</td>
            <td>Tidak perlu</td>
          </tr>
          <tr>
            <td>Tambah</td>
            <td><code>produk_tambah.php</code></td>
            <td>POST, validasi, cek duplikat, INSERT</td>
            <td>Huruf besar, counter nama, laba, anti klik ganda</td>
          </tr>
          <tr>
            <td>Edit</td>
            <td><code>produk_edit.php</code></td>
            <td>Ambil data, UPDATE, kode readonly</td>
            <td>Counter nama, laba, anti klik ganda</td>
          </tr>
          <tr>
            <td>Hapus</td>
            <td><code>produk_hapus.php</code></td>
            <td>Konfirmasi, DELETE via POST</td>
            <td>Konfirmasi hapus</td>
          </tr>
        </tbody>
      </table>
    </div>

    <h3 id="produk-daftar" class="h5">4.1 Form Daftar &amp; Cari — <code>produk.php</code></h3>
    <p>
      Form ini dipakai untuk melihat semua produk dan mencari berdasarkan kode
      atau nama. Karena hanya membaca data, form memakai metode <strong>GET</strong>.
    </p>

    <h4 class="h6 mt-3">Alur</h4>
    <ol>
      <li>Pengguna membuka <code>produk.php</code>.</li>
      <li>PHP membaca kata kunci dari <code>$_GET['cari']</code>.</li>
      <li>Jika ada kata kunci, query memakai <code>LIKE ?</code>.</li>
      <li>Hasil query diubah menjadi tabel HTML.</li>
      <li>Semua teks dari database di-escape dengan <code>htmlspecialchars</code>.</li>
    </ol>

    <h4 class="h6 mt-3">HTML form pencarian</h4>
    <pre class="bg-dark text-light p-3 rounded code-block"><code>&lt;form method="get" action="produk.php"&gt;
  &lt;input type="text" name="cari" value="..."&gt;
  &lt;button type="submit"&gt;Cari&lt;/button&gt;
&lt;/form&gt;</code></pre>

    <h4 class="h6 mt-3">Kode inti PHP</h4>
    <pre class="bg-dark text-light p-3 rounded code-block"><code>$cari = trim($_GET['cari'] ?? '');

if ($cari !== '') {
    $stmt = mysqli_prepare(
        $koneksi,
        'SELECT kode_produk, nama_produk, harga_beli, harga_jual, stok_awal
         FROM produk
         WHERE kode_produk LIKE ? OR nama_produk LIKE ?
         ORDER BY kode_produk'
    );

    $kataKunci = '%' . $cari . '%';
    mysqli_stmt_bind_param($stmt, 'ss', $kataKunci, $kataKunci);
    mysqli_stmt_execute($stmt);
    $hasil = mysqli_stmt_get_result($stmt);
} else {
    $hasil = mysqli_query(
        $koneksi,
        'SELECT kode_produk, nama_produk, harga_beli, harga_jual, stok_awal
         FROM produk ORDER BY kode_produk'
    );
}</code></pre>

    <p><strong>Penjelasan baris penting:</strong></p>
    <ul>
      <li><code>$_GET['cari']</code> berasal dari input <code>name="cari"</code>.</li>
      <li><code>%</code> berarti teks apa saja, sehingga pencarian tidak harus sama persis.</li>
      <li>Tanda <code>?</code> di query diisi lewat <code>bind_param</code>, bukan disambung manual.</li>
      <li><code>htmlspecialchars</code> mencegah teks dari database merusak HTML.</li>
    </ul>

    <div class="alert alert-info">
      Form daftar dan cari <strong>tidak membutuhkan jQuery</strong>. Form HTML
      biasa sudah cukup karena pekerjaannya hanya mengirim kata kunci dan
      menampilkan hasil dari PHP.
    </div>

    <h4 class="h6 mt-3">Kesalahan umum</h4>
    <ul>
      <li>Memakai <code>method="post"</code> untuk pencarian yang seharusnya bisa dibagikan lewat URL.</li>
      <li>Lupa memberi atribut <code>name</code> pada input, sehingga <code>$_GET</code> kosong.</li>
      <li>Menampilkan data tanpa <code>htmlspecialchars</code>.</li>
    </ul>

    <hr class="my-4">

    <h3 id="produk-tambah" class="h5">4.2 Form Tambah — <code>produk_tambah.php</code></h3>
    <p>
      Form ini menambah produk baru. Data dikirim dengan <strong>POST</strong>,
      lalu divalidasi di server sebelum masuk ke database.
    </p>

    <h4 class="h6 mt-3">Alur</h4>
    <ol>
      <li>Pengguna membuka form tambah.</li>
      <li>Pengguna mengisi kode, nama, harga beli, harga jual, dan stok.</li>
      <li>Browser mengirim data dengan POST.</li>
      <li>PHP merapikan input dengan <code>trim</code> dan <code>strtoupper</code>.</li>
      <li>PHP memvalidasi setiap field dan mengecek kode duplikat.</li>
      <li>Jika valid, PHP menjalankan <code>INSERT</code> prepared statement.</li>
      <li>PHP redirect ke <code>produk.php?status=tambah</code>.</li>
    </ol>

    <h4 class="h6 mt-3">Aturan validasi</h4>
    <div class="table-responsive">
      <table class="table table-bordered table-sm">
        <thead class="table-light">
          <tr>
            <th>Field</th>
            <th>Aturan</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><code>kode_produk</code></td>
            <td>Wajib, 2-10 karakter, huruf/angka/tanda minus.</td>
          </tr>
          <tr>
            <td><code>nama_produk</code></td>
            <td>Wajib, maksimal 50 karakter.</td>
          </tr>
          <tr>
            <td><code>harga_beli</code></td>
            <td>Wajib, angka 0 atau lebih.</td>
          </tr>
          <tr>
            <td><code>harga_jual</code></td>
            <td>Wajib, angka 0 atau lebih.</td>
          </tr>
          <tr>
            <td><code>stok_awal</code></td>
            <td>Wajib, bilangan bulat 0 atau lebih.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <h4 class="h6 mt-3">Kode inti PHP</h4>
    <pre class="bg-dark text-light p-3 rounded code-block"><code>$kode = strtoupper(trim($_POST['kode_produk'] ?? ''));
$nama = trim($_POST['nama_produk'] ?? '');
$hargaBeliInput = trim((string) ($_POST['harga_beli'] ?? ''));
$hargaJualInput = trim((string) ($_POST['harga_jual'] ?? ''));
$stokInput = trim((string) ($_POST['stok_awal'] ?? ''));

// ... validasi setiap field ...

if (count($error) === 0) {
    $stmt = mysqli_prepare(
        $koneksi,
        'INSERT INTO produk (kode_produk, nama_produk, harga_beli, harga_jual, stok_awal)
         VALUES (?, ?, ?, ?, ?)'
    );

    mysqli_stmt_bind_param($stmt, 'ssddi', $kode, $nama, $hargaBeli, $hargaJual, $stok);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: produk.php?status=tambah');
        exit;
    }
}</code></pre>

    <p><strong>Penjelasan baris penting:</strong></p>
    <ul>
      <li><code>$_POST</code> hanya dibaca saat metode request POST.</li>
      <li>Tipe <code>ssddi</code> berarti string, string, double, double, integer.</li>
      <li><code>header('Location: ...')</code> harus dijalankan sebelum HTML dikirim.</li>
      <li><code>exit</code> menghentikan proses agar kode setelah redirect tidak berjalan.</li>
    </ul>

    <h4 class="h6 mt-3">jQuery yang terlibat</h4>
    <p>
      Di form tambah, jQuery membantu pengguna sebelum tombol Simpan ditekan:
    </p>
    <ul>
      <li><code>aktifkanHurufBesar()</code> mengubah kode produk menjadi huruf besar.</li>
      <li><code>perbaruiNama()</code> menampilkan counter dan pratinjau nama.</li>
      <li><code>perbaruiLaba()</code> menghitung laba dan margin.</li>
      <li><code>pasangValidasiBlur()</code> memberi tanda merah/hijau pada field.</li>
      <li><code>pasangAntiKlikGanda()</code> mencegah tombol diklik dua kali.</li>
    </ul>

    <pre class="bg-dark text-light p-3 rounded code-block"><code>$("#kode_produk").on("input", function () {
    this.value = this.value.toUpperCase();
});</code></pre>

    <p>
      Kode lengkap function ada di <code>assets/produk.js</code>. File itu
      dipanggil dari footer hanya ketika halaman menyetel
      <code>$pakai_jquery = true</code>.
    </p>

    <h4 class="h6 mt-3">Kesalahan umum</h4>
    <ul>
      <li>Hanya mengandalkan <code>required</code> HTML, padahal validasi server tetap wajib.</li>
      <li>Lupa mengecek kode duplikat sebelum INSERT.</li>
      <li>Menjalankan <code>header()</code> setelah HTML tampil.</li>
      <li>Salah urutan tipe <code>bind_param</code>.</li>
    </ul>

    <hr class="my-4">

    <h3 id="produk-edit" class="h5">4.3 Form Edit — <code>produk_edit.php</code></h3>
    <p>
      Form edit dipakai untuk mengubah nama, harga, dan stok. Kode produk
      <strong>tidak boleh diubah</strong> karena menjadi primary key.
    </p>

    <h4 class="h6 mt-3">Alur</h4>
    <ol>
      <li>Pengguna menekan Edit dari daftar produk.</li>
      <li>URL membawa kode produk, misalnya <code>produk_edit.php?kode=BRG101</code>.</li>
      <li>PHP mengambil kode dengan <code>$_GET['kode']</code>.</li>
      <li>PHP membaca data lama dengan <code>SELECT ... WHERE kode_produk = ?</code>.</li>
      <li>Form menampilkan data lama. Kode produk ditampilkan readonly.</li>
      <li>Setelah POST, PHP memvalidasi lalu menjalankan <code>UPDATE</code>.</li>
      <li>PHP redirect ke <code>produk.php?status=edit</code>.</li>
    </ol>

    <h4 class="h6 mt-3">Primary key tetap, data berubah</h4>
    <pre class="bg-dark text-light p-3 rounded code-block"><code>&lt;input type="text" value="BRG101" readonly&gt;
&lt;input type="hidden" name="kode_produk" value="BRG101"&gt;</code></pre>
    <p>
      <code>readonly</code> mencegah pengguna mengetik ulang kode.
      <code>hidden</code> memastikan kode tetap dikirim saat form disubmit.
      Di server, kode dipakai di bagian <code>WHERE</code>.
    </p>

    <h4 class="h6 mt-3">Kode inti PHP</h4>
    <pre class="bg-dark text-light p-3 rounded code-block"><code>$kode = strtoupper(trim($_GET['kode'] ?? $_POST['kode_produk'] ?? ''));

$stmt = mysqli_prepare(
    $koneksi,
    'SELECT kode_produk, nama_produk, harga_beli, harga_jual, stok_awal
     FROM produk WHERE kode_produk = ?'
);

// ... tampilkan data lama di form ...

$stmt = mysqli_prepare(
    $koneksi,
    'UPDATE produk
     SET nama_produk = ?, harga_beli = ?, harga_jual = ?, stok_awal = ?
     WHERE kode_produk = ?'
);

mysqli_stmt_bind_param($stmt, 'sddis', $nama, $hargaBeli, $hargaJual, $stok, $kode);</code></pre>

    <p><strong>Penjelasan baris penting:</strong></p>
    <ul>
      <li><code>WHERE kode_produk = ?</code> wajib ada agar hanya satu baris berubah.</li>
      <li>Tipe <code>sddis</code> mengikuti urutan: string, double, double, integer, string.</li>
      <li>Form edit memakai <code>id="form-produk"</code>, jadi jQuery laba dan anti klik ganda ikut bekerja.</li>
    </ul>

    <h4 class="h6 mt-3">Kesalahan umum</h4>
    <ul>
      <li>Lupa <code>WHERE</code>, sehingga semua produk ikut berubah.</li>
      <li>Membuat kode produk bisa diedit, padahal primary key.</li>
      <li>Memakai GET untuk menyimpan perubahan.</li>
      <li>Tidak mengambil data lama, sehingga form tampil kosong.</li>
    </ul>

    <hr class="my-4">

    <h3 id="produk-hapus" class="h5">4.4 Form Hapus — <code>produk_hapus.php</code></h3>
    <p>
      Hapus adalah aksi paling berbahaya. Karena itu, link Hapus hanya membuka
      halaman konfirmasi. Penghapusan baru terjadi setelah tombol konfirmasi
      ditekan dan form dikirim dengan POST.
    </p>

    <h4 class="h6 mt-3">Alur</h4>
    <ol>
      <li>Pengguna menekan Hapus dari daftar produk.</li>
      <li>Halaman konfirmasi menampilkan data produk yang akan dihapus.</li>
      <li>Pengguna menekan tombol <strong>Ya, Hapus Produk</strong>.</li>
      <li>jQuery menampilkan <code>confirm()</code> sebelum form dikirim.</li>
      <li>PHP menjalankan <code>DELETE ... WHERE kode_produk = ?</code>.</li>
      <li>PHP redirect ke <code>produk.php?status=hapus</code>.</li>
    </ol>

    <h4 class="h6 mt-3">HTML form konfirmasi</h4>
    <pre class="bg-dark text-light p-3 rounded code-block"><code>&lt;form id="form-hapus" method="post" action="produk_hapus.php"
      data-confirm="Yakin ingin menghapus produk ini?"&gt;
  &lt;input type="hidden" name="kode_produk" value="BRG101"&gt;
  &lt;button type="submit"&gt;Ya, Hapus Produk&lt;/button&gt;
&lt;/form&gt;</code></pre>

    <h4 class="h6 mt-3">Kode inti PHP</h4>
    <pre class="bg-dark text-light p-3 rounded code-block"><code>if ($_SERVER['REQUEST_METHOD'] === 'POST' && $produk) {
    $stmt = mysqli_prepare($koneksi, 'DELETE FROM produk WHERE kode_produk = ?');
    mysqli_stmt_bind_param($stmt, 's', $kode);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: produk.php?status=hapus');
        exit;
    }
}</code></pre>

    <p><strong>Penjelasan baris penting:</strong></p>
    <ul>
      <li>Link GET hanya untuk membuka konfirmasi, bukan untuk menghapus.</li>
      <li><code>$_SERVER['REQUEST_METHOD'] === 'POST'</code> memastikan hapus hanya lewat tombol konfirmasi.</li>
      <li><code>WHERE kode_produk = ?</code> membatasi hapus ke satu produk.</li>
      <li>Untuk aplikasi nyata, gunakan <em>soft delete</em> jika produk sudah dipakai transaksi.</li>
    </ul>

    <h4 class="h6 mt-3">jQuery yang terlibat</h4>
    <p>
      <code>pasangKonfirmasiHapus()</code> membaca atribut
      <code>data-confirm</code> dan menampilkan <code>window.confirm()</code>.
      Jika pengguna memilih Batal, form tidak dikirim.
    </p>

    <h4 class="h6 mt-3">Kesalahan umum</h4>
    <ul>
      <li>Menghapus langsung lewat link GET.</li>
      <li>Lupa <code>WHERE</code>, sehingga semua produk terhapus.</li>
      <li>Tidak memeriksa apakah produk benar-benar ada.</li>
      <li>Tidak memberi peringatan bahwa data transaksi bisa kehilangan relasi.</li>
    </ul>

    <hr class="my-4">

    <h3 id="jquery" class="h5">4.5 jQuery — <code>assets/produk.js</code></h3>
    <p>
      jQuery dipakai untuk memberi bantuan langsung saat pengguna mengisi form.
      File jQuery disimpan lokal agar lab tetap bisa dipakai tanpa internet.
      Bootstrap tetap mengatur tampilan tombol, grid, dan alert.
    </p>

    <h4 class="h6 mt-3">Cara memanggil</h4>
    <pre class="bg-dark text-light p-3 rounded code-block"><code>&lt;?php if (!empty($pakai_jquery)): ?&gt;
  &lt;script src="assets/jquery/jquery-3.7.1.min.js"&gt;&lt;/script&gt;
  &lt;script src="assets/produk.js"&gt;&lt;/script&gt;
&lt;?php endif; ?&gt;</code></pre>
    <p>
      Halaman <code>produk_tambah.php</code>, <code>produk_edit.php</code>, dan
      <code>produk_hapus.php</code> menyetel <code>$pakai_jquery = true</code>.
      Halaman daftar tidak membutuhkannya.
    </p>

    <h4 class="h6 mt-3">Peta function</h4>
    <div class="table-responsive">
      <table class="table table-bordered table-sm">
        <thead class="table-light">
          <tr>
            <th>Function</th>
            <th>Dipakai di</th>
            <th>Efek</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><code>aktifkanHurufBesar()</code></td>
            <td>Tambah</td>
            <td>Kode produk otomatis huruf besar.</td>
          </tr>
          <tr>
            <td><code>perbaruiNama()</code></td>
            <td>Tambah, Edit</td>
            <td>Counter dan pratinjau nama.</td>
          </tr>
          <tr>
            <td><code>perbaruiLaba()</code></td>
            <td>Tambah, Edit</td>
            <td>Laba dan margin otomatis.</td>
          </tr>
          <tr>
            <td><code>pasangValidasiBlur()</code></td>
            <td>Tambah, Edit</td>
            <td>Class <code>is-invalid</code>/<code>is-valid</code> Bootstrap.</td>
          </tr>
          <tr>
            <td><code>pasangKonfirmasiHapus()</code></td>
            <td>Hapus</td>
            <td>Konfirmasi sebelum DELETE.</td>
          </tr>
          <tr>
            <td><code>pasangAntiKlikGanda()</code></td>
            <td>Tambah, Edit, Hapus</td>
            <td>Tombol tidak bisa diklik dua kali.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <h4 class="h6 mt-3">Contoh isi function</h4>
    <pre class="bg-dark text-light p-3 rounded code-block"><code>function perbaruiLaba() {
  var beli = parseFloat($("#harga_beli").val());
  var jual = parseFloat($("#harga_jual").val());

  if (isNaN(beli) || isNaN(jual)) {
    $("#ringkasan-laba").text("Isi harga beli dan harga jual.");
    return;
  }

  var laba = jual - beli;
  $("#ringkasan-laba").text("Laba: " + laba);
}</code></pre>

    <pre class="bg-dark text-light p-3 rounded code-block"><code>function pasangAntiKlikGanda() {
  $("#form-produk, #form-hapus").on("submit", function (event) {
    if (event.isDefaultPrevented()) {
      return;
    }

    $(this).find("button[type='submit']")
      .prop("disabled", true)
      .text("Memproses...");
  });
}</code></pre>

    <p>
      <strong>Prinsip penting:</strong> JavaScript hanya membantu. Validasi
      tetap dilakukan PHP, dan data tetap disimpan oleh PHP. Jika JavaScript
      dimatikan, form produk masih bisa dipakai.
    </p>

    <div class="alert alert-info mb-0">
      <strong>Latihan:</strong> isi harga beli 2500 dan harga jual 3500.
      Perhatikan laba dan margin. Lalu isi harga jual lebih kecil dari harga
      beli, dan lihat kotak berubah menjadi peringatan merah.
    </div>
  </div>
</section>

<section id="hasil-produk" class="card mb-4 anchor-target">
  <div class="card-header bg-white fw-semibold">5. Hasil Akhir Produk</div>
  <div class="card-body">
    <p>
      Setelah membaca penjelasan per form, buka hasil akhir berikut. Semua
      halaman memakai database <code>db_penjualan</code> dan benar-benar
      menjalankan CRUD, bukan gambar atau mockup.
    </p>

    <div class="table-responsive mb-3">
      <table class="table table-bordered table-sm">
        <thead class="table-light">
          <tr>
            <th>Halaman</th>
            <th>Yang bisa dicoba</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><a href="produk.php"><code>produk.php</code></a></td>
            <td>Melihat daftar, mencari, dan membuka tombol Edit/Hapus.</td>
          </tr>
          <tr>
            <td><a href="produk_tambah.php"><code>produk_tambah.php</code></a></td>
            <td>Menambah produk baru dan melihat validasi server + jQuery.</td>
          </tr>
          <tr>
            <td><a href="produk_edit.php"><code>produk_edit.php</code></a></td>
            <td>Mengubah produk. Pilih produk dari daftar terlebih dahulu.</td>
          </tr>
          <tr>
            <td><a href="produk_hapus.php"><code>produk_hapus.php</code></a></td>
            <td>Melihat konfirmasi hapus. Pilih produk dari daftar terlebih dahulu.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <h3 class="h5">Urutan uji yang disarankan</h3>
    <ol>
      <li>Buka <a href="produk.php">Daftar Produk</a>.</li>
      <li>Klik <strong>Tambah Produk</strong>, lalu isi produk dengan kode unik.</li>
      <li>Amati counter nama, huruf besar otomatis, dan laba/margin.</li>
      <li>Simpan, lalu cari produk itu di daftar.</li>
      <li>Klik Edit, ubah harga jual, lalu simpan.</li>
      <li>Klik Hapus, baca konfirmasi, lalu hapus produk uji.</li>
      <li>Buka phpMyAdmin dan pastikan baris produk benar-benar berubah.</li>
    </ol>

    <h3 class="h5 mt-4">Yang harus terlihat</h3>
    <ul>
      <li>Data baru muncul di tabel setelah redirect.</li>
      <li>Pencarian menemukan produk berdasarkan kode atau nama.</li>
      <li>Kode produk tidak bisa diubah di form edit.</li>
      <li>Tombol submit berubah menjadi <strong>Memproses...</strong> saat diklik.</li>
      <li>Konfirmasi muncul sebelum produk dihapus.</li>
    </ul>

    <div class="alert alert-warning mb-0">
      <strong>Hati-hati:</strong> halaman hasil akhir memakai data asli
      <code>db_penjualan</code>. Saat latihan, gunakan kode produk uji, lalu
      hapus kembali agar data contoh tidak rusak.
    </div>
  </div>
</section>

<section id="tugas-kasir" class="card mb-4 anchor-target task-card">
  <div class="card-header bg-white fw-semibold">6. Tugas Kasir</div>
  <div class="card-body">
    <div class="alert alert-warning">
      <code>kasir.php</code> dan <code>kasir_tambah.php</code> sudah berisi
      contoh daftar dan contoh form. Form contoh <strong>belum memiliki tombol
      simpan</strong> dan belum memproses INSERT. Tugasmu melengkapi bagian
      simpan, lalu membuat halaman edit dan nonaktifkan.
    </div>

    <h3 class="h5">File yang harus diisi</h3>
    <div class="table-responsive">
      <table class="table table-bordered table-sm">
        <thead class="table-light">
          <tr>
            <th>File</th>
            <th>Tugas</th>
            <th>Contoh</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><code>kasir.php</code></td>
            <td>Contoh daftar kasir dan badge status. Tombol aksi belum dibuat.</td>
            <td><code>produk.php</code></td>
          </tr>
          <tr>
            <td><code>kasir_tambah.php</code></td>
            <td>Contoh form tanpa tombol simpan. Tugas: tambahkan validasi, INSERT, redirect.</td>
            <td><code>produk_tambah.php</code></td>
          </tr>
          <tr>
            <td><code>kasir_edit.php</code></td>
            <td>Ambil data berdasarkan <code>id_kasir</code>, edit nama, UPDATE.</td>
            <td><code>produk_edit.php</code></td>
          </tr>
          <tr>
            <td><code>kasir_nonaktifkan.php</code></td>
            <td>Konfirmasi, lalu ubah status menjadi nonaktif.</td>
            <td><code>produk_hapus.php</code></td>
          </tr>
        </tbody>
      </table>
    </div>

    <h3 class="h5 mt-4">Field tabel kasir</h3>
    <table class="table table-sm table-bordered">
      <thead class="table-light">
        <tr>
          <th>Field</th>
          <th>Aturan</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><code>id_kasir</code></td>
          <td>Auto increment, tidak diisi manual.</td>
        </tr>
        <tr>
          <td><code>nama_kasir</code></td>
          <td>Wajib diisi, maksimal 50 karakter.</td>
        </tr>
        <tr>
          <td><code>status</code></td>
          <td><code>aktif</code> atau <code>nonaktif</code>.</td>
        </tr>
        <tr>
          <td><code>tanggal_keluar</code></td>
          <td><code>NULL</code> saat aktif; diisi tanggal saat nonaktif.</td>
        </tr>
      </tbody>
    </table>

    <h3 class="h5 mt-4">Query inti</h3>
    <p>Menampilkan daftar:</p>
    <pre class="bg-dark text-light p-3 rounded code-block"><code>SELECT id_kasir, nama_kasir, status, tanggal_keluar
FROM kasir
ORDER BY id_kasir</code></pre>

    <p>Menambah kasir:</p>
    <pre class="bg-dark text-light p-3 rounded code-block"><code>INSERT INTO kasir (nama_kasir, status, tanggal_keluar)
VALUES (?, 'aktif', NULL)</code></pre>

    <p>Menonaktifkan kasir (bukan DELETE):</p>
    <pre class="bg-dark text-light p-3 rounded code-block"><code>UPDATE kasir
SET status = 'nonaktif', tanggal_keluar = CURDATE()
WHERE id_kasir = ?</code></pre>

    <div class="alert alert-danger mb-0">
      <strong>Jangan hapus kasir.</strong> Tabel <code>penjualan</code> dan
      <code>pembelian</code> menyimpan <code>id_kasir</code>. Jika baris kasir
      dihapus, riwayat transaksi bisa rusak.
    </div>
  </div>
</section>

<section id="tugas-supplier" class="card mb-4 anchor-target task-card">
  <div class="card-header bg-white fw-semibold">7. Tugas Supplier</div>
  <div class="card-body">
    <div class="alert alert-warning">
      File <code>supplier.php</code>, <code>supplier_tambah.php</code>,
      <code>supplier_edit.php</code>, dan <code>supplier_hapus.php</code> juga
      disediakan kosong dengan komentar petunjuk.
    </div>

    <h3 class="h5">File yang harus diisi</h3>
    <div class="table-responsive">
      <table class="table table-bordered table-sm">
        <thead class="table-light">
          <tr>
            <th>File</th>
            <th>Tugas</th>
            <th>Contoh</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><code>supplier.php</code></td>
            <td>Daftar supplier + tombol edit/hapus + pesan status.</td>
            <td><code>produk.php</code></td>
          </tr>
          <tr>
            <td><code>supplier_tambah.php</code></td>
            <td>Form nama supplier dan kota, validasi, INSERT.</td>
            <td><code>produk_tambah.php</code></td>
          </tr>
          <tr>
            <td><code>supplier_edit.php</code></td>
            <td>Ambil data berdasarkan <code>id_supplier</code>, lalu UPDATE.</td>
            <td><code>produk_edit.php</code></td>
          </tr>
          <tr>
            <td><code>supplier_hapus.php</code></td>
            <td>Konfirmasi, cek pemakaian, lalu DELETE jika aman.</td>
            <td><code>produk_hapus.php</code></td>
          </tr>
        </tbody>
      </table>
    </div>

    <h3 class="h5 mt-4">Field tabel supplier</h3>
    <table class="table table-sm table-bordered">
      <thead class="table-light">
        <tr>
          <th>Field</th>
          <th>Aturan</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><code>id_supplier</code></td>
          <td>Auto increment, tidak diisi manual.</td>
        </tr>
        <tr>
          <td><code>nama_supplier</code></td>
          <td>Wajib diisi, maksimal 50 karakter.</td>
        </tr>
        <tr>
          <td><code>kota</code></td>
          <td>Opsional, maksimal 30 karakter.</td>
        </tr>
      </tbody>
    </table>

    <h3 class="h5 mt-4">Cek sebelum menghapus</h3>
    <p>
      Sebelum <code>DELETE</code>, hitung dulu apakah supplier dipakai di tabel
      <code>pembelian</code>:
    </p>
    <pre class="bg-dark text-light p-3 rounded code-block"><code>SELECT COUNT(*) AS jumlah
FROM pembelian
WHERE id_supplier = ?</code></pre>

    <p>Jika hasilnya lebih dari 0, tampilkan pesan dan batalkan hapus.</p>
    <pre class="bg-dark text-light p-3 rounded code-block"><code>DELETE FROM supplier
WHERE id_supplier = ?</code></pre>

    <div class="alert alert-danger mb-0">
      <strong>Jangan hapus supplier yang sudah dipakai.</strong> Data pembelian
      akan kehilangan relasi ke pemasok.
    </div>
  </div>
</section>

<section class="card mb-4">
  <div class="card-header bg-white fw-semibold">8. Perbedaan Primary Key</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-sm mb-0">
        <thead class="table-light">
          <tr>
            <th>Tabel</th>
            <th>Primary key</th>
            <th>Cara input</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><code>produk</code></td>
            <td><code>kode_produk</code> (teks)</td>
            <td>Diisi pengguna saat tambah produk.</td>
          </tr>
          <tr>
            <td><code>kasir</code></td>
            <td><code>id_kasir</code> (angka)</td>
            <td>Otomatis oleh MySQL; edit memakai hidden input.</td>
          </tr>
          <tr>
            <td><code>supplier</code></td>
            <td><code>id_supplier</code> (angka)</td>
            <td>Otomatis oleh MySQL; edit memakai hidden input.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section id="alur-pembelian" class="card mb-4 anchor-target">
  <div class="card-header bg-white fw-semibold">9. Alur Pembelian (Contoh Selesai)</div>
  <div class="card-body">
    <p>
      Modul pembelian adalah contoh lengkap transaksi barang masuk. Polanya
      dipakai lagi untuk penjualan, hanya arah stok yang dibalik.
    </p>

    <div class="table-responsive mb-3">
      <table class="table table-bordered table-sm align-middle">
        <thead class="table-light">
          <tr>
            <th>File</th>
            <th>Isi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><a href="pembelian.php"><code>pembelian.php</code></a></td>
            <td>Daftar nota + pencarian + statistik. Total dari <code>SUM(detail)</code>.</td>
          </tr>
          <tr>
            <td><a href="pembelian_tambah.php"><code>pembelian_tambah.php</code></a></td>
            <td>Form multi-baris, validasi, transaksi database, stok masuk.</td>
          </tr>
          <tr>
            <td><a href="pembelian_detail.php?no=PB-0001"><code>pembelian_detail.php</code></a></td>
            <td>Nota + isi + mutasi stok masuk.</td>
          </tr>
          <tr>
            <td><code>transaksi_helper.php</code></td>
            <td><code>rupiah()</code>, <code>saldo_stok_terakhir()</code>, <code>buat_nomor()</code>.</td>
          </tr>
          <tr>
            <td><code>assets/transaksi.js</code></td>
            <td>Tambah/hapus baris, isi harga, hitung subtotal dan total.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <h3 class="h5">Urutan Simpan</h3>
    <ol>
      <li>Validasi tanggal, kasir, supplier, dan semua baris barang.</li>
      <li><code>mysqli_begin_transaction($koneksi);</code></li>
      <li>Buat nomor: <code>buat_nomor($koneksi, 'PB-', 'pembelian', 'no_pembelian')</code>.</li>
      <li>INSERT kepala nota ke <code>pembelian</code>.</li>
      <li>Per barang: INSERT <code>detail_pembelian</code> + INSERT <code>stok</code>.</li>
      <li><code>mysqli_commit($koneksi);</code> lalu redirect ke halaman detail.</li>
      <li>Jika ada error: <code>mysqli_rollback($koneksi);</code></li>
    </ol>

    <h3 class="h5 mt-4">Kode Inti: Stok Masuk</h3>
    <pre class="bg-dark text-light p-3 rounded code-block"><code>$saldoAwal  = saldo_stok_terakhir($koneksi, $kodeProduk);
$saldoAkhir = $saldoAwal + $jumlah;

INSERT INTO stok
  (kode_produk, tanggal, jumlah_masuk, jumlah_keluar,
   saldo_awal, saldo_akhir, no_penjualan, no_pembelian, keterangan)
VALUES
  (?, ?, ?, 0, ?, ?, NULL, ?, 'Beli dari supplier')</code></pre>

    <h3 class="h5 mt-4">Kode Inti: Detail</h3>
    <pre class="bg-dark text-light p-3 rounded code-block"><code>INSERT INTO detail_pembelian
  (no_pembelian, kode_produk, nama_produk, jumlah, harga_beli)
VALUES (?, ?, ?, ?, ?)</code></pre>

    <div class="alert alert-success mb-0">
      <strong>Snapshot:</strong> <code>nama_produk</code> dan
      <code>harga_beli</code> disalin ke detail. Jadi nota lama tidak berubah
      walaupun data produk diedit kemudian.
    </div>
  </div>
</section>

<section id="tugas-penjualan" class="card mb-4 anchor-target task-card">
  <div class="card-header bg-white fw-semibold">10. Tugas Penjualan</div>
  <div class="card-body">
    <div class="alert alert-warning">
      <strong>Tugas:</strong> lengkapi modul penjualan (barang keluar).
      Kerangka file dan langkah rinci sudah tersedia di komentar file.
      Gunakan <code>pembelian*.php</code> sebagai contoh terdekat.
    </div>

    <div class="table-responsive mb-3">
      <table class="table table-bordered table-sm align-middle">
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
            <td>Ganti brief dengan daftar nota + pencarian + statistik.</td>
            <td><code>pembelian.php</code></td>
          </tr>
          <tr>
            <td><code>penjualan_tambah.php</code></td>
            <td>Lengkapi form multi-baris, validasi, cek stok, INSERT, redirect.</td>
            <td><code>pembelian_tambah.php</code></td>
          </tr>
          <tr>
            <td><code>penjualan_detail.php</code></td>
            <td>Buat nota + isi + mutasi stok keluar.</td>
            <td><code>pembelian_detail.php</code></td>
          </tr>
        </tbody>
      </table>
    </div>

    <h3 class="h5">Urutan Wajib</h3>
    <ol>
      <li>Ambil kasir aktif dan produk beserta stok terakhir.</li>
      <li>Validasi tanggal, kasir, metode bayar, dan setiap baris.</li>
      <li>Cek stok sebelum menyimpan.</li>
      <li><code>begin_transaction</code>, lalu buat nomor <code>PJ-0001</code>.</li>
      <li>INSERT <code>penjualan</code> + <code>detail_penjualan</code> + <code>stok</code> keluar.</li>
      <li><code>commit</code>, lalu buka <code>penjualan_detail.php?no=...</code>.</li>
    </ol>

    <h3 class="h5 mt-4">Kode Inti: Cek Stok</h3>
    <pre class="bg-dark text-light p-3 rounded code-block"><code>$stokTersedia = saldo_stok_terakhir($koneksi, $kodeProduk);

if ($jumlahDijual &gt; $stokTersedia) {
    $error[] = 'Stok tidak cukup. Tersedia ' . $stokTersedia;
}</code></pre>

    <h3 class="h5 mt-4">Kode Inti: Stok Keluar</h3>
    <pre class="bg-dark text-light p-3 rounded code-block"><code>$saldoAwal  = saldo_stok_terakhir($koneksi, $kodeProduk);
$saldoAkhir = $saldoAwal - $jumlah;

INSERT INTO stok
  (kode_produk, tanggal, jumlah_masuk, jumlah_keluar,
   saldo_awal, saldo_akhir, no_penjualan, no_pembelian, keterangan)
VALUES
  (?, ?, 0, ?, ?, ?, ?, NULL, 'Jual ke pembeli')</code></pre>

    <h3 class="h5 mt-4">Checklist Penjualan</h3>
    <ul class="mb-0">
      <li>Daftar penjualan tampil dan pencarian berfungsi.</li>
      <li>Form bisa menambah lebih dari satu barang.</li>
      <li>Harga satuan otomatis dari <code>produk.harga_jual</code>.</li>
      <li>Stok tidak cukup ditolak dengan pesan jelas.</li>
      <li>Setelah simpan: stok berkurang dan nota tampil.</li>
      <li>Semua query berinput memakai prepared statement.</li>
      <li>Semua output memakai <code>htmlspecialchars</code>.</li>
    </ul>

    <div class="d-flex flex-wrap gap-2 mt-3">
      <a class="btn btn-primary" href="penjualan.php">Buka Brief Penjualan</a>
      <a class="btn btn-outline-primary" href="pembelian_tambah.php">Lihat Contoh Form</a>
    </div>
  </div>
</section>

<section id="checklist" class="card mb-4 anchor-target">
  <div class="card-header bg-white fw-semibold">11. Checklist dan Rubrik</div>
  <div class="card-body">
    <div class="row g-4">
      <div class="col-lg-7">
        <h3 class="h5">Checklist wajib</h3>
        <ul class="mb-0">
          <li>Daftar kasir dan supplier tampil dari database.</li>
          <li>Tambah data berhasil dan muncul di daftar.</li>
          <li>Edit data menyimpan perubahan dengan benar.</li>
          <li>Kasir memakai nonaktif, bukan hapus permanen.</li>
          <li>Supplier tidak bisa dihapus jika sudah dipakai di pembelian.</li>
          <li>Penjualan menolak jumlah yang melebihi stok.</li>
          <li>Pembelian dan penjualan memakai transaksi database.</li>
          <li>Semua input divalidasi di server.</li>
          <li>Semua query berinput memakai prepared statement.</li>
          <li>Semua output memakai <code>htmlspecialchars</code>.</li>
          <li>Tidak ada warning atau error PHP.</li>
          <li>Tampilan memakai komponen Bootstrap yang rapi.</li>
        </ul>
      </div>
      <div class="col-lg-5">
        <h3 class="h5">Rubrik penilaian</h3>
        <table class="table table-sm table-bordered mb-0">
          <tbody>
            <tr>
              <th>Fitur CRUD</th>
              <td>40%</td>
            </tr>
            <tr>
              <th>Validasi &amp; keamanan</th>
              <td>25%</td>
            </tr>
            <tr>
              <th>Tampilan Bootstrap</th>
              <td>15%</td>
            </tr>
            <tr>
              <th>Kerapian kode</th>
              <td>10%</td>
            </tr>
            <tr>
              <th>Presentasi</th>
              <td>10%</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<section id="kesalahan" class="card mb-4 anchor-target">
  <div class="card-header bg-white fw-semibold">12. Kesalahan Umum</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-sm mb-0">
        <thead class="table-light">
          <tr>
            <th>Masalah</th>
            <th>Akibat</th>
            <th>Perbaikan</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Tidak memanggil <code>config/database.php</code></td>
            <td><code>$koneksi</code> tidak ditemukan.</td>
            <td>Tambahkan <code>require __DIR__ . '/config/database.php';</code>.</td>
          </tr>
          <tr>
            <td>Tidak memanggil partial</td>
            <td>Halaman tidak memakai navbar dan Bootstrap.</td>
            <td>Panggil header di atas dan footer di bawah.</td>
          </tr>
          <tr>
            <td>Lupa <code>WHERE</code></td>
            <td>Semua baris berubah atau terhapus.</td>
            <td>Batasi dengan <code>id_kasir = ?</code> atau <code>id_supplier = ?</code>.</td>
          </tr>
          <tr>
            <td>Salah tipe <code>bind_param</code></td>
            <td>Nilai bisa berubah atau query error.</td>
            <td>Cocokkan tipe dengan field: <code>s</code> teks, <code>i</code> angka.</td>
          </tr>
          <tr>
            <td><code>header()</code> setelah HTML</td>
            <td><em>Headers already sent</em>.</td>
            <td>Proses POST sebelum memanggil header partial.</td>
          </tr>
          <tr>
            <td>Menghapus kasir</td>
            <td>Riwayat transaksi rusak.</td>
            <td>Gunakan status <code>nonaktif</code>.</td>
          </tr>
          <tr>
            <td>Menghapus supplier yang dipakai</td>
            <td>Relasi pembelian hilang.</td>
            <td>Cek tabel <code>pembelian</code> sebelum DELETE.</td>
          </tr>
          <tr>
            <td>Tidak mengecek stok saat menjual</td>
            <td>Stok bisa minus dan saldo kacau.</td>
            <td>Bandingkan jumlah jual dengan <code>saldo_stok_terakhir()</code>.</td>
          </tr>
          <tr>
            <td>Lupa <code>commit</code>/<code>rollback</code></td>
            <td>Data tidak tersimpan atau tertahan.</td>
            <td>Bungkus INSERT kepala + detail + stok dalam transaksi.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<div class="d-flex flex-wrap gap-2 mb-4">
  <a class="btn btn-primary" href="produk.php">Buka Contoh Produk</a>
  <a class="btn btn-outline-primary" href="pembelian.php">Contoh Pembelian</a>
  <a class="btn btn-outline-primary" href="#tugas-kasir">Brief Kasir</a>
  <a class="btn btn-outline-primary" href="#tugas-supplier">Brief Supplier</a>
  <a class="btn btn-outline-primary" href="#tugas-penjualan">Brief Penjualan</a>
  <a class="btn btn-outline-secondary" href="index.php">Kembali ke Dashboard</a>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
