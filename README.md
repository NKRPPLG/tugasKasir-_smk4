# KasirSMK - Proyek Akhir P15-P16

Proyek CRUD Toko Maju Jaya memakai **PHP natif + MySQLi + Bootstrap 5 lokal**.
Database: **`db_penjualan`**.

## Buka di browser

```
http://localhost/smk4/kasirsmk/
```

Alternatif Laragon: `http://smk4.test/kasirsmk/`

## Struktur

```
kasirsmk/
├── partials/
│   ├── header.php          # Bootstrap navbar, CSS, pembuka container
│   └── footer.php          # penutup container, footer, JS Bootstrap
├── config/
│   └── database.php        # koneksi ke db_penjualan
├── assets/
│   ├── bootstrap/          # Bootstrap 5 lokal
│   ├── jquery/             # jQuery 3.7.1 lokal
│   ├── produk.js           # interaksi form produk
│   ├── transaksi.js        # interaksi form transaksi
│   ├── presentasi.css      # tampilan slide presentasi
│   ├── presentasi.js       # navigasi slide presentasi
│   └── style.css
├── index.php               # dashboard
├── checklist.php           # checklist penyelesaian: master -> transaksi -> report
├── panduan.php             # panduan pembuatan + brief tugas
├── presentasi.php          # presentasi mengajar P15-P16
├── produk.php              # READ + pencarian
├── produk_tambah.php       # CREATE
├── produk_edit.php         # UPDATE
├── produk_hapus.php        # DELETE
├── kasir.php               # CONTOH: daftar kasir
├── kasir_tambah.php        # CONTOH: form tanpa tombol simpan
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
└── README.md
```

## Checklist penyelesaian

```
http://localhost/smk4/kasirsmk/checklist.php
```

41 item dalam lima fase: **Fondasi**, **Master**, **Transaksi**, **Report**,
**Finalisasi**. Setiap item memuat file target dan bukti yang harus terlihat.
Centang disimpan di browser (localStorage), jadi bisa dilanjutkan besok.
Empat item Report sudah dilengkapi contoh query (penjualan, pembelian, stok,
laba). Tombol **Cetak Checklist** menyembunyikan navbar dan tombol agar bisa
disimpan sebagai PDF.

## Cara belajar

1. Buka dashboard, lalu pilih **Mode Presentasi** untuk mengajar P15-P16.
2. Buka **Checklist** untuk melihat urutan penyelesaian: master, transaksi,
   report.
2. Baca **Penjelasan Produk per Form** di `panduan.php` sebagai bahan diskusi.
3. Coba **Hasil Akhir Produk**: daftar, cari, tambah, edit, dan hapus.
4. Perhatikan jQuery di `assets/produk.js`: huruf besar, counter nama, laba,
   validasi, konfirmasi hapus, dan anti klik ganda.
5. Buka **Kasir**: daftar sudah tersedia dan `kasir_tambah.php` berisi contoh
   form tanpa tombol simpan.
6. Buka **Pembelian**: contoh transaksi lengkap (nota, detail, stok masuk).
7. Baca **Tugas Kasir**, **Tugas Supplier**, dan **Tugas Penjualan**, lalu
   lengkapi file tugas.
8. Uji semua fitur dengan data dari database `db_penjualan`.

## Aturan tugas

- Tambah, edit, dan hapus memakai **prepared statement**.
- Semua output memakai **`htmlspecialchars`**.
- Aksi yang mengubah data memakai **POST**.
- jQuery hanya membantu tampilan; validasi tetap dilakukan di PHP.
- Kasir tidak dihapus permanen, tetapi **dinonaktifkan**.
- Supplier tidak boleh dihapus jika sudah dipakai di tabel `pembelian`.
- Penjualan wajib mengecek stok sebelum menyimpan.
- Pembelian/penjualan memakai transaksi database (kepala + detail + stok).
- Navbar menampilkan **Pembelian** dan **Penjualan**; tautan **Supplier**
  sengaja dikomentari sampai tugas supplier selesai.

## Tabel utama

| Tabel | Primary key | Keterangan |
|---|---|---|
| `produk` | `kode_produk` | Contoh CRUD lengkap |
| `kasir` | `id_kasir` | Tugas siswa |
| `supplier` | `id_supplier` | Tugas siswa |
| `pembelian` + `detail_pembelian` | `no_pembelian` | Contoh transaksi barang masuk |
| `penjualan` + `detail_penjualan` | `no_penjualan` | Tugas transaksi barang keluar |
| `stok` | `id_stok` | Riwayat saldo stok masuk/keluar |

Panduan lengkap ada di halaman `panduan.php`. Halaman `presentasi.php`
menyediakan slide full-screen dengan navigasi keyboard untuk mengajar di kelas.
