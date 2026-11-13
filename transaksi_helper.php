<?php
// ============================================================
// kasirsmk/transaksi_helper.php
// Fungsi bantu modul transaksi proyek akhir.
// ============================================================

if (!function_exists('rupiah')) {
    function rupiah($angka): string
    {
        return 'Rp ' . number_format((float) $angka, 0, ',', '.');
    }
}

if (!function_exists('saldo_stok_terakhir')) {
    function saldo_stok_terakhir($koneksi, string $kodeProduk): int
    {
        $stmt = mysqli_prepare(
            $koneksi,
            'SELECT saldo_akhir
             FROM stok
             WHERE kode_produk = ?
             ORDER BY id_stok DESC
             LIMIT 1'
        );

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 's', $kodeProduk);
            mysqli_stmt_execute($stmt);
            $hasil = mysqli_stmt_get_result($stmt);
            $baris = mysqli_fetch_assoc($hasil);
            mysqli_stmt_close($stmt);

            if ($baris) {
                return (int) $baris['saldo_akhir'];
            }
        }

        $stmt = mysqli_prepare($koneksi, 'SELECT stok_awal FROM produk WHERE kode_produk = ?');

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 's', $kodeProduk);
            mysqli_stmt_execute($stmt);
            $hasil = mysqli_stmt_get_result($stmt);
            $baris = mysqli_fetch_assoc($hasil);
            mysqli_stmt_close($stmt);

            if ($baris) {
                return (int) $baris['stok_awal'];
            }
        }

        return 0;
    }
}

if (!function_exists('buat_nomor')) {
    function buat_nomor($koneksi, string $prefix, string $tabel, string $kolom): string
    {
        $sql = "SELECT $kolom FROM $tabel ORDER BY $kolom DESC LIMIT 1";
        $hasil = mysqli_query($koneksi, $sql);

        $nomor = 1;

        if ($hasil) {
            $baris = mysqli_fetch_assoc($hasil);

            if ($baris && $baris[$kolom] !== null) {
                $nomor = ((int) preg_replace('/\D/', '', $baris[$kolom])) + 1;
            }
        }

        return $prefix . str_pad((string) $nomor, 4, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('ambil_kasir_aktif')) {
    function ambil_kasir_aktif($koneksi): array
    {
        $hasil = mysqli_query(
            $koneksi,
            "SELECT id_kasir, nama_kasir
             FROM kasir
             WHERE status = 'aktif'
             ORDER BY nama_kasir"
        );

        $daftar = [];

        if ($hasil) {
            while ($baris = mysqli_fetch_assoc($hasil)) {
                $daftar[] = $baris;
            }
        }

        return $daftar;
    }
}

if (!function_exists('ambil_supplier')) {
    function ambil_supplier($koneksi): array
    {
        $hasil = mysqli_query(
            $koneksi,
            'SELECT id_supplier, nama_supplier, kota
             FROM supplier
             ORDER BY nama_supplier'
        );

        $daftar = [];

        if ($hasil) {
            while ($baris = mysqli_fetch_assoc($hasil)) {
                $daftar[] = $baris;
            }
        }

        return $daftar;
    }
}

if (!function_exists('ambil_produk')) {
    function ambil_produk($koneksi): array
    {
        $hasil = mysqli_query(
            $koneksi,
            'SELECT kode_produk, nama_produk, harga_beli, harga_jual, stok_awal
             FROM produk
             ORDER BY nama_produk'
        );

        $daftar = [];

        if ($hasil) {
            while ($baris = mysqli_fetch_assoc($hasil)) {
                $daftar[] = $baris;
            }
        }

        return $daftar;
    }
}
