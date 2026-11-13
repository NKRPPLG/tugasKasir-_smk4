# 📋 Dokumen Pembagian Tugas Kelompok (2 Orang)
## Proyek: KasirSMK — Toko Maju Jaya (P15-P16)
**Stack:** PHP Native + MySQLi + Bootstrap 5 + jQuery

---

## 📌 Ringkasan Distribusi Beban Kerja (50 : 50)

| Aspek | 👤 Anggota 1 (Temanmu) | 👤 Anggota 2 (Kamu) |
|---|---|---|
| **Fokus Peran** | **Database & Master Data Engineer** | **Transaction & Reporting Engineer** |
| **Area Kerja** | Database Schema & CRUD Master (Kasir & Supplier) | Core Transaksi POS (Penjualan), Laporan & Dashboard |
| **Jumlah File** | 1 file SQL + 6 file PHP | 7 file PHP + 1 file CSS |
| **File Acuan** | `produk*.php` (CRUD Master) | `pembelian*.php` (Alur Transaksi) |
| **Tingkat Kesulitan** | Sedang (Pola CRUD standar) | Sedang - Menantang (Multi-baris, validasi stok, laporan) |

---

## 👤 Rincian Tugas Anggota 1 (Temanmu): Database & Master Data

### 1. Inisialisasi Database (`db_penjualan.sql`)
* **Target File:** `db_penjualan.sql` (Dibuat baru di root proyek).
* **Tugas & Tanggung Jawab:**
  1. Membuat struktur 8 tabel:
     - `produk` (kode_produk [PK], nama_produk, harga_beli, harga_jual, stok_awal)
     - `kasir` (id_kasir [PK, AI], nama_kasir, status ['aktif'/'nonaktif'], tanggal_keluar)
     - `supplier` (id_supplier [PK, AI], nama_supplier, kota)
     - `pembelian` (no_pembelian [PK], tanggal, id_kasir, id_supplier)
     - `detail_pembelian` (id_detail [PK, AI], no_pembelian, kode_produk, nama_produk, jumlah, harga_beli)
     - `penjualan` (no_penjualan [PK], tanggal, id_kasir, metode_bayar)
     - `detail_penjualan` (id_detail [PK, AI], no_penjualan, kode_produk, nama_produk, jumlah, harga_satuan)
     - `stok` (id_stok [PK, AI], kode_produk, tanggal, jumlah_masuk, jumlah_keluar, saldo_awal, saldo_akhir, no_penjualan, no_pembelian, keterangan)
  2. Mengisi data dummy awal: minimal 5 produk, 3 kasir aktif, 3 supplier, dan riwayat mutasi stok awal.
  3. **Milestone:** Commit dan Push file `db_penjualan.sql` ke GitHub paling pertama agar Anggota 2 bisa langsung mengimpornya.

---

### 2. Modul Master Kasir
* **Target File:**
  - `kasir_tambah.php` (Melengkapi)
  - `kasir_edit.php` (Menulis dari nol)
  - `kasir_nonaktifkan.php` (Menulis dari nol)
  - `kasir.php` (Melengkapi tombol aksi & alert)
* **Tugas & Tanggung Jawab:**
  1. **`kasir_tambah.php`**:
     - Tambahkan tombol submit **Simpan Kasir**.
     - Buat penangan `POST` di bagian atas: validasi `nama_kasir` wajib diisi dan maksimal 50 karakter.
     - Eksekusi `INSERT INTO kasir (nama_kasir, status, tanggal_keluar) VALUES (?, 'aktif', NULL)` dengan *prepared statement*.
     - Redirect ke `kasir.php?status=tambah`.
  2. **`kasir_edit.php`**:
     - Ambil `id_kasir` via GET/POST. Query data kasir lama.
     - Tampilkan form terisi nilai lama.
     - Saat disubmit via POST: jalankan `UPDATE kasir SET nama_kasir = ? WHERE id_kasir = ?` (*prepared statement*).
     - Redirect ke `kasir.php?status=edit`.
  3. **`kasir_nonaktifkan.php`** (Soft Delete):
     - **PENTING:** Jangan gunakan `DELETE FROM kasir` agar integritas nota lama tidak rusak!
     - Tampilkan halaman konfirmasi nama kasir yang akan dinonaktifkan.
     - Saat disubmit via POST: jalankan `UPDATE kasir SET status = 'nonaktif', tanggal_keluar = CURDATE() WHERE id_kasir = ?`.
     - Redirect ke `kasir.php?status=nonaktif`.
  4. **`kasir.php`**:
     - Ubah kolom Aksi yang tadinya bertuliskan `"Tugas siswa"` menjadi tombol aksi **Edit** dan **Nonaktifkan**.
     - Tambahkan penangan alert notifikasi status (`?status=tambah|edit|nonaktif`).

---

### 3. Modul Master Supplier
* **Target File:**
  - `supplier.php` (Menulis dari nol)
  - `supplier_tambah.php` (Menulis dari nol)
  - `supplier_edit.php` (Menulis dari nol)
  - `supplier_hapus.php` (Menulis dari nol)
  - `partials/header.php` (Buka komentar)
* **Tugas & Tanggung Jawab:**
  1. **`supplier.php`**:
     - Query `SELECT id_supplier, nama_supplier, kota FROM supplier ORDER BY id_supplier`.
     - Tampilkan data dalam tabel Bootstrap yang rapi, tombol Tambah Supplier, tombol Edit dan Hapus, serta alert pesan status.
  2. **`supplier_tambah.php`**:
     - Form input nama supplier dan kota.
     - Validasi server-side dan `INSERT INTO supplier (nama_supplier, kota) VALUES (?, ?)`.
  3. **`supplier_edit.php`**:
     - Ambil data supplier berdasarkan `id_supplier`, tampilkan form edit, dan jalankan query `UPDATE`.
  4. **`supplier_hapus.php`** (Pengaman Relasi):
     - Tampilkan form konfirmasi hapus.
     - **Pengaman Wajib:** Cek apakah supplier sudah pernah dipakai di transaksi pembelian:
       ```sql
       SELECT COUNT(*) AS jumlah FROM pembelian WHERE id_supplier = ?
       ```
     - Jika `jumlah > 0`: Tolak penghapusan dan beri peringatan bahwa supplier memiliki riwayat pembelian.
     - Jika `jumlah === 0`: Lakukan `DELETE FROM supplier WHERE id_supplier = ?`.
  5. **`partials/header.php`**:
     - Buka tanda komentar HTML pada menu navigasi Supplier agar muncul di navbar.

---

## 👤 Rincian Tugas Anggota 2 (Kamu): Transaksi Penjualan & Laporan

### 1. Modul Transaksi Penjualan (Barang Keluar)
* **Target File:**
  - `penjualan_tambah.php` (Melengkapi)
  - `penjualan_detail.php` (Menulis dari nol / melengkapi)
  - `penjualan.php` (Mengubah dari halaman brief menjadi daftar riil)
* **Tugas & Tanggung Jawab:**
  1. **`penjualan_tambah.php`**:
     - Tambahkan elemen `<template id="template-baris">`, tombol **Tambah Baris**, dan tombol **Simpan Penjualan** (terhubung dengan `assets/transaksi.js`).
     - Hubungkan input produk agar otomatis mengisi harga jual dan menampilkan sisa stok.
     - Logika penangan `POST`:
       - Validasi tanggal, kasir aktif, metode bayar (Tunai, QRIS, Debit), dan kelengkapan item.
       - **Validasi Stok:** Pastikan jumlah setiap item $\le$ stok tersedia via `saldo_stok_terakhir()`. Jika stok kurang, tolak simpan.
       - Buka transaksi database: `mysqli_begin_transaction($koneksi)`.
       - Generate nomor nota baru: `$noPenjualan = buat_nomor($koneksi, 'PJ-', 'penjualan', 'no_penjualan');`.
       - `INSERT INTO penjualan (no_penjualan, tanggal, id_kasir, metode_bayar) VALUES (?, ?, ?, ?)`.
       - Per item: `INSERT INTO detail_penjualan` dan `INSERT INTO stok` mutasi keluar (`jumlah_keluar = jumlah`, `saldo_akhir = saldo_awal - jumlah`).
       - `mysqli_commit($koneksi)` dan redirect ke `penjualan_detail.php?no=...&status=tambah`.
       - Tangani error dengan `mysqli_rollback($koneksi)`.
  2. **`penjualan_detail.php`**:
     - Ambil nomor nota dari `$_GET['no']`.
     - Tampilkan kepala nota: No Penjualan, Tanggal, Kasir, Metode Bayar.
     - Tampilkan tabel detail barang: Kode, Nama Produk, Jumlah, Harga Satuan, Subtotal, serta Total Nilai.
     - Tampilkan tabel mutasi stok keluar dari tabel `stok` (`saldo_awal`, `jumlah_keluar`, `saldo_akhir`).
  3. **`penjualan.php`**:
     - Ganti halaman brief statis menjadi tabel daftar nota penjualan.
     - Tambahkan fitur pencarian (nomor nota atau nama kasir).
     - Tampilkan ringkasan: Total Nota, Total Item Terjual, dan Total Omzet.
     - Sediakan tombol Detail untuk membuka nota penjualan.

---

### 2. Modul Laporan (Reporting & Analisis)
* **Target File (Baru):**
  - `laporan_penjualan.php`
  - `laporan_pembelian.php`
  - `laporan_stok.php`
  - `laporan_laba.php`
* **Tugas & Tanggung Jawab:**
  1. **`laporan_penjualan.php`**:
     - Filter tanggal awal dan akhir (default: awal bulan s/d hari ini).
     - Query penjualan per periode, tampilkan total item dan total omzet per nota.
     - Kartu ringkasan angka di atas tabel (Total Nota, Total Qty, Total Rupiah).
  2. **`laporan_pembelian.php`**:
     - Filter tanggal awal dan akhir.
     - Query pembelian per periode, tampilkan supplier dan total belanja.
  3. **`laporan_stok.php`**:
     - Tampilkan saldo stok akhir seluruh produk.
     - Produk dengan stok $\le 5$ diberi highlight atau badge merah (Stok Menipis).
  4. **`laporan_laba.php`**:
     - Hitung laba kotor: $\text{Omzet} - \text{Modal} = \text{Laba}$.
     - Rumus query: `SUM(d.jumlah * (d.harga_satuan - p.harga_beli)) AS laba`.

---

### 3. Dashboard & Fitur Cetak
* **Target File:**
  - `assets/style.css`
  - `index.php`
  - `partials/header.php`
* **Tugas & Tanggung Jawab:**
  1. **`assets/style.css`**: Tambahkan aturan `@media print` agar saat pengguna menekan `Ctrl+P`, navbar dan tombol navigasi disembunyikan sehingga halaman laporan tercetak rapi.
  2. **`index.php`**: Tambahkan kartu statistik dinamis yang membaca database (Total Produk, Total Omzet Hari Ini, Nota Hari Ini, Peringatan Stok Menipis).
  3. **`partials/header.php`**: Tambahkan dropdown menu navigasi "Laporan" agar keempat laporan mudah diakses dari navbar.

---

## 🛠️ Alur Kerja Git (Biar Tidak Tabrakan)

### Langkah Praktis:
1. **Langkah 1 (Temanmu):**
   - Buat branch: `git checkout -b fitur-database-master`
   - Buat file `db_penjualan.sql`, lalu commit dan push ke GitHub.
   - Anggota 2 (kamu) melakukan `git pull` dan mengimpor file `db_penjualan.sql` ke phpMyAdmin lokal.
2. **Langkah 2 (Bekerja Paralel):**
   - Temanmu lanjut menggarap Kasir & Supplier di branch `fitur-database-master`.
   - Kamu membuat branch: `git checkout -b fitur-penjualan-laporan`, lalu menggarap Penjualan, Laporan, dan Dashboard.
3. **Langkah 3 (Penggabungan / Merge):**
   - Buat Pull Request (PR) di GitHub organisasi.
   - Karena file yang diedit oleh kalian berdua tidak ada yang bertabrakan, proses merge ke branch `main` akan berjalan mulus tanpa konflik!
