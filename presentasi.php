<?php
$judul = 'Presentasi KasirSMK';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Presentasi mengajar proyek akhir KasirSMK P15-P16.">
  <title><?= htmlspecialchars($judul) ?></title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/presentasi.css">
</head>
<body class="presentation-body">
  <div class="presentation-app" id="presentasi">
    <header class="presentation-toolbar sticky-top" id="toolbar">
      <a class="presentation-brand" href="index.php" aria-label="Kembali ke dashboard">
        <span class="brand-mark">K</span>
        <span>KasirSMK</span>
      </a>

      <div class="presentation-progress" aria-hidden="true">
        <span class="presentation-progress-bar" id="progressBar"></span>
      </div>

      <div class="presentation-actions">
        <span class="slide-counter" id="slideCounter" aria-live="polite">1 / 14</span>
        <button class="presentation-button" type="button" data-action="prev" aria-label="Slide sebelumnya">←</button>
        <button class="presentation-button" type="button" data-action="next" aria-label="Slide berikutnya">→</button>
        <button class="presentation-button presentation-button-text" type="button" id="outlineButton" aria-expanded="false" aria-controls="outlinePanel">Daftar Slide</button>
        <button class="presentation-button presentation-button-text" type="button" id="fullscreenButton">Fullscreen</button>
        <a class="presentation-button presentation-button-text" href="panduan.php">Panduan</a>
        <a class="presentation-button presentation-button-text" href="index.php">Dashboard</a>
      </div>
    </header>

    <main class="presentation-stage" id="stage" aria-label="Slide presentasi">
      <section class="slide slide-cover is-active" data-title="Cover">
        <div class="cover-layout">
          <div class="cover-copy">
            <span class="slide-kicker">Proyek Akhir P15-P16</span>
            <h1 class="cover-title">KasirSMK</h1>
            <p class="cover-subtitle">
              Dari CRUD produk ke aplikasi kasir Toko Maju Jaya.
              Hari ini kita bedah polanya, lalu kamu bangun modulnya.
            </p>
            <div class="cover-tags">
              <span>PHP Natif</span>
              <span>MySQLi</span>
              <span>Bootstrap 5</span>
              <span>jQuery</span>
            </div>
            <button class="presentation-cta" type="button" data-action="next">
              Mulai presentasi <span aria-hidden="true">→</span>
            </button>
          </div>

          <div class="cover-panel" aria-hidden="true">
            <div class="cover-panel-head">
              <span class="window-dot"></span>
              <span class="window-dot"></span>
              <span class="window-dot"></span>
              <span class="cover-url">db_penjualan</span>
            </div>
            <div class="cover-stat-grid">
              <div class="cover-stat">
                <strong>4</strong>
                <span>modul utama</span>
              </div>
              <div class="cover-stat">
                <strong>3</strong>
                <span>tabel inti</span>
              </div>
              <div class="cover-stat">
                <strong>2</strong>
                <span>pertemuan</span>
              </div>
              <div class="cover-stat">
                <strong>1</strong>
                <span>showcase</span>
              </div>
            </div>
            <div class="cover-console">
              <span class="console-prompt">kasirsmk $</span>
              <span>php -S localhost:8000</span>
              <span class="console-cursor"></span>
            </div>
          </div>
        </div>
      </section>

      <section class="slide" data-title="Tujuan">
        <div class="slide-head">
          <span class="slide-kicker">Arah belajar</span>
          <h2>Yang kita capai hari ini</h2>
          <p>Bukan sekadar menyalin kode. Kita ingin kamu bisa membaca pola, menguji, lalu memperbaikinya.</p>
        </div>

        <div class="card-grid four">
          <article class="info-card">
            <span class="info-number">01</span>
            <h3>CRUD utuh</h3>
            <p>Daftar, cari, tambah, edit, dan hapus produk berjalan di database nyata.</p>
          </article>
          <article class="info-card">
            <span class="info-number">02</span>
            <h3>Aman sejak awal</h3>
            <p>Prepared statement, escape output, aksi POST, dan WHERE yang tepat.</p>
          </article>
          <article class="info-card">
            <span class="info-number">03</span>
            <h3>Mandiri</h3>
            <p>Produk menjadi contoh. Kasir dan supplier kamu bangun sendiri.</p>
          </article>
          <article class="info-card">
            <span class="info-number">04</span>
            <h3>Siap showcase</h3>
            <p>Aplikasi layak didemokan, diuji, dan diceritakan di depan kelas.</p>
          </article>
        </div>

        <div class="callout callout-orange">
          <strong>Pertanyaan pembuka:</strong> apa bedanya halaman yang “jalan” dengan halaman yang “aman dan bisa dipercaya”?
        </div>
      </section>

      <section class="slide" data-title="Peta proyek">
        <div class="slide-head">
          <span class="slide-kicker">Peta proyek</span>
          <h2>Satu aplikasi, empat pintu masuk</h2>
          <p>Semua halaman memakai koneksi dan partial yang sama. Tidak ada folder salinan per pertemuan.</p>
        </div>

        <div class="split-layout">
          <div class="flow-list">
            <div class="flow-item">
              <span class="flow-number">1</span>
              <div>
                <h3>Dashboard</h3>
                <p><code>index.php</code> menjadi peta tugas dan pintu ke presentasi.</p>
              </div>
            </div>
            <div class="flow-item">
              <span class="flow-number">2</span>
              <div>
                <h3>Produk</h3>
                <p><code>produk*.php</code> berisi contoh CRUD lengkap plus jQuery.</p>
              </div>
            </div>
            <div class="flow-item">
              <span class="flow-number">3</span>
              <div>
                <h3>Kasir</h3>
                <p>Contoh daftar dan form. Proses simpan, edit, dan nonaktifkan adalah tugasmu.</p>
              </div>
            </div>
            <div class="flow-item">
              <span class="flow-number">4</span>
              <div>
                <h3>Supplier</h3>
                <p>Modul dari nol, lengkap dengan pengecekan pemakaian di tabel pembelian.</p>
              </div>
            </div>
          </div>

          <aside class="panel-card">
            <span class="panel-label">Database live</span>
            <h3>db_penjualan</h3>
            <table class="presentation-table compact">
              <thead>
                <tr>
                  <th>Tabel</th>
                  <th>Peran</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><code>produk</code></td>
                  <td>Contoh CRUD</td>
                </tr>
                <tr>
                  <td><code>kasir</code></td>
                  <td>Tugas siswa</td>
                </tr>
                <tr>
                  <td><code>supplier</code></td>
                  <td>Tugas siswa</td>
                </tr>
                <tr>
                  <td><code>pembelian</code></td>
                  <td>Cek relasi supplier</td>
                </tr>
              </tbody>
            </table>
            <p class="panel-note">Koneksi: <code>config/database.php</code></p>
          </aside>
        </div>
      </section>

      <section class="slide" data-title="Demo daftar &amp; cari">
        <div class="slide-head">
          <span class="slide-kicker">Form 1 · READ</span>
          <h2>Daftar dan cari produk</h2>
          <p>Pencarian memakai GET karena hasilnya bisa dibagikan lewat URL. Data tetap diambil dengan prepared statement.</p>
        </div>

        <div class="split-layout wide-left">
          <div class="mock-window">
            <div class="mock-toolbar">
              <span class="window-dot"></span>
              <span class="window-dot"></span>
              <span class="window-dot"></span>
              <span class="mock-url">localhost/smk4/kasirsmk/produk.php</span>
            </div>
            <div class="mock-body">
              <div class="mock-search">
                <span>Cari kode atau nama produk...</span>
                <button type="button">Cari</button>
              </div>
              <table class="presentation-table">
                <thead>
                  <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Harga jual</th>
                    <th>Stok</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><code>BRG001</code></td>
                    <td>Kopi Sachet</td>
                    <td>Rp 2.500</td>
                    <td>40</td>
                  </tr>
                  <tr>
                    <td><code>BRG002</code></td>
                    <td>Teh Botol</td>
                    <td>Rp 4.000</td>
                    <td>25</td>
                  </tr>
                  <tr>
                    <td><code>BRG003</code></td>
                    <td>Air Mineral</td>
                    <td>Rp 3.500</td>
                    <td>60</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="stack">
            <div class="code-card">
              <span class="panel-label">Query inti</span>
              <pre><code>$stmt = mysqli_prepare(
    $koneksi,
    'SELECT kode_produk, nama_produk,
            harga_beli, harga_jual, stok_awal
     FROM produk
     WHERE kode_produk LIKE ?
        OR nama_produk LIKE ?
     ORDER BY kode_produk'
);

$kataKunci = '%' . $cari . '%';
mysqli_stmt_bind_param($stmt, 'ss',
    $kataKunci, $kataKunci);</code></pre>
            </div>
            <a class="demo-link" href="produk.php" target="_blank" rel="noopener">Buka halaman daftar produk →</a>
          </div>
        </div>
      </section>

      <section class="slide" data-title="Form tambah">
        <div class="slide-head">
          <span class="slide-kicker">Form 2 · CREATE</span>
          <h2>Tambah produk: dari form ke database</h2>
          <p>Alurnya selalu sama: terima POST, rapikan input, validasi, cek duplikat, INSERT, lalu redirect.</p>
        </div>

        <div class="split-layout">
          <div class="flow-list">
            <div class="flow-item">
              <span class="flow-number">1</span>
              <div><h3>Terima POST</h3><p>Baca <code>$_POST</code> hanya saat metode request POST.</p></div>
            </div>
            <div class="flow-item">
              <span class="flow-number">2</span>
              <div><h3>Validasi</h3><p>Kode 2–10 karakter, nama maksimal 50, harga dan stok tidak negatif.</p></div>
            </div>
            <div class="flow-item">
              <span class="flow-number">3</span>
              <div><h3>Cek duplikat</h3><p>Pastikan <code>kode_produk</code> belum dipakai sebelum INSERT.</p></div>
            </div>
            <div class="flow-item">
              <span class="flow-number">4</span>
              <div><h3>Simpan</h3><p>Prepared statement, lalu redirect sebelum HTML dikirim.</p></div>
            </div>
          </div>

          <div class="stack">
            <div class="code-card">
              <span class="panel-label">INSERT aman</span>
              <pre><code>$stmt = mysqli_prepare(
    $koneksi,
    'INSERT INTO produk
        (kode_produk, nama_produk,
         harga_beli, harga_jual, stok_awal)
     VALUES (?, ?, ?, ?, ?)'
);

mysqli_stmt_bind_param($stmt, 'ssddi',
    $kode, $nama, $hargaBeli, $hargaJual, $stok);

if (mysqli_stmt_execute($stmt)) {
    header('Location: produk.php?status=tambah');
    exit;
}</code></pre>
            </div>
            <a class="demo-link" href="produk_tambah.php" target="_blank" rel="noopener">Coba form tambah produk →</a>
          </div>
        </div>
      </section>

      <section class="slide" data-title="Form edit">
        <div class="slide-head">
          <span class="slide-kicker">Form 3 · UPDATE</span>
          <h2>Edit produk tanpa mengubah primary key</h2>
          <p>Kode produk menjadi identitas baris. Tampilkan readonly, kirim lewat hidden input, lalu batasi UPDATE dengan WHERE.</p>
        </div>

        <div class="split-layout">
          <div class="stack">
            <div class="code-card">
              <span class="panel-label">Ambil data lama</span>
              <pre><code>$kode = strtoupper(trim($_GET['kode'] ?? $_POST['kode_produk'] ?? ''));

$stmt = mysqli_prepare(
    $koneksi,
    'SELECT kode_produk, nama_produk,
            harga_beli, harga_jual, stok_awal
     FROM produk
     WHERE kode_produk = ?'
);</code></pre>
            </div>
            <div class="code-card">
              <span class="panel-label">Simpan perubahan</span>
              <pre><code>UPDATE produk
SET nama_produk = ?, harga_beli = ?,
    harga_jual = ?, stok_awal = ?
WHERE kode_produk = ?</code></pre>
            </div>
          </div>

          <div class="stack">
            <div class="warning-card">
              <span class="warning-label">Jangan lupa</span>
              <h3>Tanpa WHERE, semua baris berubah.</h3>
              <p>Primary key tetap. Yang diedit hanya nama, harga, dan stok.</p>
            </div>
            <div class="mini-demo">
              <span class="mini-label">Kode produk</span>
              <strong>BRG001</strong>
              <span class="mini-lock">readonly + hidden input</span>
            </div>
            <a class="demo-link" href="produk.php" target="_blank" rel="noopener">Pilih produk lalu klik Edit →</a>
          </div>
        </div>
      </section>

      <section class="slide" data-title="Form hapus">
        <div class="slide-head">
          <span class="slide-kicker">Form 4 · DELETE</span>
          <h2>Hapus harus disengaja</h2>
          <p>Link Hapus hanya membuka halaman konfirmasi. Penghapusan baru terjadi setelah form dikirim dengan POST.</p>
        </div>

        <div class="split-layout">
          <div class="flow-list">
            <div class="flow-item">
              <span class="flow-number">1</span>
              <div><h3>Buka konfirmasi</h3><p>Link GET membawa kode produk, tetapi belum menghapus apa pun.</p></div>
            </div>
            <div class="flow-item">
              <span class="flow-number">2</span>
              <div><h3>Baca data</h3><p>Tampilkan produk yang akan dihapus agar tidak salah sasaran.</p></div>
            </div>
            <div class="flow-item">
              <span class="flow-number">3</span>
              <div><h3>Konfirmasi</h3><p>jQuery menampilkan <code>confirm()</code> sebelum form dikirim.</p></div>
            </div>
            <div class="flow-item">
              <span class="flow-number">4</span>
              <div><h3>POST + DELETE</h3><p>Server memeriksa metode POST, lalu menjalankan DELETE dengan WHERE.</p></div>
            </div>
          </div>

          <div class="stack">
            <div class="code-card">
              <span class="panel-label">DELETE aman</span>
              <pre><code>if ($_SERVER['REQUEST_METHOD'] === 'POST'
    &amp;&amp; $produk) {

    $stmt = mysqli_prepare(
        $koneksi,
        'DELETE FROM produk
         WHERE kode_produk = ?'
    );

    mysqli_stmt_bind_param($stmt, 's', $kode);
    mysqli_stmt_execute($stmt);
}</code></pre>
            </div>
            <div class="callout callout-danger">
              <strong>Untuk data transaksi:</strong> gunakan soft delete, bukan hapus permanen.
            </div>
            <a class="demo-link" href="produk.php" target="_blank" rel="noopener">Lihat tombol Hapus di daftar →</a>
          </div>
        </div>
      </section>

      <section class="slide" data-title="jQuery">
        <div class="slide-head">
          <span class="slide-kicker">Interaksi</span>
          <h2>jQuery membantu, PHP tetap memutuskan</h2>
          <p>JavaScript mempercepat umpan balik. Validasi dan penyimpanan tetap dilakukan di server.</p>
        </div>

        <div class="split-layout jquery-layout">
          <div class="card-grid two">
            <article class="function-card">
              <code>aktifkanHurufBesar()</code>
              <p>Kode produk otomatis menjadi huruf besar.</p>
            </article>
            <article class="function-card">
              <code>perbaruiNama()</code>
              <p>Counter dan pratinjau nama saat mengetik.</p>
            </article>
            <article class="function-card">
              <code>perbaruiLaba()</code>
              <p>Hitung laba dan margin dari dua harga.</p>
            </article>
            <article class="function-card">
              <code>pasangValidasiBlur()</code>
              <p>Beri class valid/invalid Bootstrap.</p>
            </article>
            <article class="function-card">
              <code>pasangKonfirmasiHapus()</code>
              <p>Tampilkan konfirmasi sebelum DELETE.</p>
            </article>
            <article class="function-card">
              <code>pasangAntiKlikGanda()</code>
              <p>Tombol tidak bisa diklik dua kali.</p>
            </article>
          </div>

          <div class="stack">
            <div class="code-card">
              <span class="panel-label">Contoh dari assets/produk.js</span>
              <pre><code>function perbaruiLaba() {
  var beli = parseFloat($("#harga_beli").val());
  var jual = parseFloat($("#harga_jual").val());

  if (isNaN(beli) || isNaN(jual)) {
    $("#ringkasan-laba").text("Isi harga beli dan harga jual.");
    return;
  }

  var laba = jual - beli;
  $("#ringkasan-laba").text("Laba: " + laba);
}</code></pre>
            </div>
            <a class="demo-link" href="produk_tambah.php" target="_blank" rel="noopener">Coba form dengan jQuery →</a>
          </div>
        </div>
      </section>

      <section class="slide" data-title="Keamanan">
        <div class="slide-head">
          <span class="slide-kicker">Bekal wajib</span>
          <h2>Empat pagar keamanan</h2>
          <p>Empat kebiasaan ini membedakan aplikasi latihan dari aplikasi yang siap dipakai.</p>
        </div>

        <div class="security-grid">
          <article class="security-card">
            <span class="security-symbol">01</span>
            <h3>Prepared statement</h3>
            <p>Input tidak disambung ke query. Gunakan <code>?</code> dan <code>bind_param</code>.</p>
          </article>
          <article class="security-card">
            <span class="security-symbol">02</span>
            <h3>Escape output</h3>
            <p>Semua teks dari database atau form lewat <code>htmlspecialchars</code>.</p>
          </article>
          <article class="security-card">
            <span class="security-symbol">03</span>
            <h3>POST untuk perubahan</h3>
            <p>Tambah, edit, dan hapus tidak boleh dijalankan lewat link GET.</p>
          </article>
          <article class="security-card">
            <span class="security-symbol">04</span>
            <h3>WHERE yang tepat</h3>
            <p>Update dan delete wajib dibatasi primary key.</p>
          </article>
        </div>

        <div class="callout callout-orange">
          <strong>Uji cepat:</strong> buka satu file CRUD, cari kata <code>mysqli_query</code>, lalu pastikan tidak ada input pengguna yang disambung langsung.
        </div>
      </section>

      <section class="slide" data-title="Tugas kasir">
        <div class="slide-head">
          <span class="slide-kicker">Tugas 1</span>
          <h2>Modul kasir: lengkapi, bukan ulang</h2>
          <p>Daftar dan contoh form sudah tersedia. Fokusmu ada pada proses simpan, edit, dan nonaktifkan.</p>
        </div>

        <div class="split-layout">
          <div class="file-list">
            <div class="file-row">
              <code>kasir.php</code>
              <span>Contoh daftar + badge status.</span>
            </div>
            <div class="file-row">
              <code>kasir_tambah.php</code>
              <span>Form contoh tanpa tombol simpan.</span>
            </div>
            <div class="file-row">
              <code>kasir_edit.php</code>
              <span>Ambil data, ubah nama, UPDATE.</span>
            </div>
            <div class="file-row">
              <code>kasir_nonaktifkan.php</code>
              <span>Konfirmasi, lalu ubah status.</span>
            </div>
          </div>

          <aside class="panel-card">
            <span class="panel-label">Aturan kasir</span>
            <table class="presentation-table compact">
              <tbody>
                <tr>
                  <th>Primary key</th>
                  <td><code>id_kasir</code> otomatis</td>
                </tr>
                <tr>
                  <th>Status</th>
                  <td><code>aktif</code> / <code>nonaktif</code></td>
                </tr>
                <tr>
                  <th>Hapus</th>
                  <td>Soft delete, bukan DELETE</td>
                </tr>
                <tr>
                  <th>Tanggal keluar</th>
                  <td><code>CURDATE()</code> saat nonaktif</td>
                </tr>
              </tbody>
            </table>
            <div class="callout callout-danger small">
              Jangan hapus kasir. Riwayat penjualan dan pembelian menyimpan <code>id_kasir</code>.
            </div>
          </aside>
        </div>
      </section>

      <section class="slide" data-title="Tugas supplier">
        <div class="slide-head">
          <span class="slide-kicker">Tugas 2</span>
          <h2>Modul supplier: bangun dari nol</h2>
          <p>Semua file masih berisi komentar tugas. Tiru pola produk, lalu tambahkan pengecekan relasi sebelum menghapus.</p>
        </div>

        <div class="split-layout">
          <div class="stack">
            <div class="file-list">
              <div class="file-row">
                <code>supplier.php</code>
                <span>Daftar + tombol edit/hapus.</span>
              </div>
              <div class="file-row">
                <code>supplier_tambah.php</code>
                <span>Form nama dan kota + INSERT.</span>
              </div>
              <div class="file-row">
                <code>supplier_edit.php</code>
                <span>Ambil data + UPDATE.</span>
              </div>
              <div class="file-row">
                <code>supplier_hapus.php</code>
                <span>Cek pemakaian + DELETE.</span>
              </div>
            </div>
            <div class="callout callout-orange small">
              <strong>Urutan aman:</strong> daftar → tambah → edit → hapus.
            </div>
          </div>

          <div class="code-card">
            <span class="panel-label">Cek sebelum hapus</span>
            <pre><code>SELECT COUNT(*) AS jumlah
FROM pembelian
WHERE id_supplier = ?</code></pre>
            <p class="code-note">
              Jika hasilnya lebih dari 0, tampilkan pesan dan batalkan
              <code>DELETE</code>. Relasi pembelian harus tetap utuh.
            </p>
          </div>
        </div>
      </section>

      <section class="slide" data-title="Agenda 240 menit">
        <div class="slide-head">
          <span class="slide-kicker">P15 · 08.00–12.00</span>
          <h2>Agenda 240 menit</h2>
          <p>Teori tetap pendek. Sebagian besar waktu dipakai untuk membaca kode, mencoba, dan membangun.</p>
        </div>

        <div class="timeline">
          <div class="timeline-row">
            <span class="timeline-time">08.00–08.20</span>
            <span class="timeline-dot"></span>
            <div><strong>Pembuka + demo hasil</strong><p>Lihat produk yang sudah jadi, tentukan target hari ini.</p></div>
          </div>
          <div class="timeline-row">
            <span class="timeline-time">08.20–09.30</span>
            <span class="timeline-dot"></span>
            <div><strong>Bedah produk per form</strong><p>Daftar/cari, tambah, edit, hapus, jQuery, dan keamanan.</p></div>
          </div>
          <div class="timeline-row">
            <span class="timeline-time">09.30–09.45</span>
            <span class="timeline-dot is-break"></span>
            <div><strong>Istirahat</strong><p>15 menit. Simpan pekerjaan sebelum lanjut.</p></div>
          </div>
          <div class="timeline-row">
            <span class="timeline-time">09.45–11.00</span>
            <span class="timeline-dot"></span>
            <div><strong>Praktik kasir</strong><p>Lengkapi simpan, edit, dan nonaktifkan.</p></div>
          </div>
          <div class="timeline-row">
            <span class="timeline-time">11.00–11.40</span>
            <span class="timeline-dot"></span>
            <div><strong>Praktik supplier</strong><p>Bangun CRUD dari nol + cek tabel pembelian.</p></div>
          </div>
          <div class="timeline-row">
            <span class="timeline-time">11.40–12.00</span>
            <span class="timeline-dot"></span>
            <div><strong>Uji + refleksi</strong><p>Tunjukkan perubahan data, catat kendala, siapkan showcase.</p></div>
          </div>
        </div>
      </section>

      <section class="slide" data-title="Rubrik">
        <div class="slide-head">
          <span class="slide-kicker">Penilaian</span>
          <h2>Rubrik proyek akhir</h2>
          <p>Yang dinilai bukan hanya hasil akhir, tetapi juga cara kamu menguji dan menjelaskan keputusan kode.</p>
        </div>

        <div class="split-layout">
          <table class="presentation-table rubric-table">
            <thead>
              <tr>
                <th>Aspek</th>
                <th>Bobot</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Fitur CRUD berjalan</td>
                <td><strong>40%</strong></td>
              </tr>
              <tr>
                <td>Validasi dan keamanan</td>
                <td><strong>25%</strong></td>
              </tr>
              <tr>
                <td>Tampilan Bootstrap</td>
                <td><strong>15%</strong></td>
              </tr>
              <tr>
                <td>Kerapian kode</td>
                <td><strong>10%</strong></td>
              </tr>
              <tr>
                <td>Presentasi</td>
                <td><strong>10%</strong></td>
              </tr>
            </tbody>
          </table>

          <div class="checklist-card">
            <span class="panel-label">Checklist minimum</span>
            <ul class="check-list">
              <li>Daftar tampil dari database.</li>
              <li>Tambah, edit, dan hapus berhasil.</li>
              <li>Kasir memakai nonaktif.</li>
              <li>Supplier dicek ke tabel pembelian.</li>
              <li>Semua input divalidasi di server.</li>
              <li>Semua output di-escape.</li>
            </ul>
          </div>
        </div>
      </section>

      <section class="slide slide-closing" data-title="Showcase">
        <div class="closing-layout">
          <div>
            <span class="slide-kicker">P16 · Showcase</span>
            <h2>Saatnya aplikasimu bercerita</h2>
            <p class="closing-lead">
              Tunjukkan satu alur lengkap: cari produk, tambah data, edit,
              lalu nonaktifkan kasir. Jelaskan keputusan kode, bukan hanya
              tombol yang diklik.
            </p>

            <div class="closing-actions">
              <a class="presentation-cta" href="produk.php">Buka Produk <span aria-hidden="true">→</span></a>
              <a class="presentation-ghost" href="panduan.php">Baca Panduan</a>
              <a class="presentation-ghost" href="index.php">Dashboard</a>
            </div>
          </div>

          <div class="closing-card">
            <span class="panel-label">Sebelum tampil</span>
            <ul class="check-list">
              <li>Data uji sudah siap.</li>
              <li>Tidak ada error atau warning.</li>
              <li>Alur demo sudah dilatih.</li>
              <li>Bisa menjelaskan satu query.</li>
              <li>Bisa menjelaskan satu perbaikan.</li>
            </ul>
            <p class="closing-note">Tekan <kbd>O</kbd> untuk daftar slide, <kbd>F</kbd> untuk fullscreen.</p>
          </div>
        </div>
      </section>
    </main>

    <nav class="presentation-nav" aria-label="Navigasi slide">
      <button class="presentation-button" type="button" data-action="prev">← Sebelumnya</button>
      <span class="keyboard-hint">← → pindah slide · F fullscreen · O daftar slide</span>
      <button class="presentation-button" type="button" data-action="next">Berikutnya →</button>
    </nav>

    <div class="outline-backdrop" id="outlineBackdrop" hidden></div>

    <aside class="outline-panel" id="outlinePanel" aria-hidden="true">
      <div class="outline-head">
        <div>
          <span class="panel-label">Daftar slide</span>
          <h2>Lompat ke materi</h2>
        </div>
        <button class="presentation-button" type="button" id="outlineClose" aria-label="Tutup daftar slide">×</button>
      </div>
      <ol class="outline-list" id="outlineList"></ol>
    </aside>
  </div>

  <noscript>
    <div class="noscript-message">
      Aktifkan JavaScript untuk memakai navigasi slide. Semua materi tetap
      tersedia sebagai bagian halaman ini.
    </div>
  </noscript>

  <script src="assets/presentasi.js"></script>
</body>
</html>
