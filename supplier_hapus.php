<?php
require __DIR__ . '/config/database.php';

$id = (int) ($_GET['id_supplier'] ?? $_POST['id_supplier'] ?? 0);
$error = [];
$supplier = null;

if ($id <= 0) {
    $error[] = 'ID supplier tidak valid atau tidak dikirim.';
} else {
    $stmt = mysqli_prepare(
        $koneksi,
        'SELECT id_supplier, nama_supplier, kota
         FROM supplier
         WHERE id_supplier = ?'
    );

    if (!$stmt) {
        $error[] = 'Tabel supplier belum siap: ' . mysqli_error($koneksi);
    } else {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $hasil = mysqli_stmt_get_result($stmt);
        $supplier = mysqli_fetch_assoc($hasil);
        mysqli_stmt_close($stmt);

        if (!$supplier) {
            $error[] = 'Supplier dengan ID ' . $id . ' tidak ditemukan.';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $supplier) {
    // CEK PENGAMAN: Cek pemakaian supplier di tabel pembelian
    $stmtCek = mysqli_prepare(
        $koneksi,
        'SELECT COUNT(*) AS jumlah FROM pembelian WHERE id_supplier = ?'
    );

    if (!$stmtCek) {
        $error[] = 'Gagal memeriksa pemakaian supplier: ' . mysqli_error($koneksi);
    } else {
        mysqli_stmt_bind_param($stmtCek, 'i', $id);
        mysqli_stmt_execute($stmtCek);
        $hasilCek = mysqli_stmt_get_result($stmtCek);
        $barisCek = mysqli_fetch_assoc($hasilCek);
        mysqli_stmt_close($stmtCek);

        $jumlahPemakaian = (int) ($barisCek['jumlah'] ?? 0);

        if ($jumlahPemakaian > 0) {
            $error[] = 'Supplier ini tidak dapat dihapus karena sudah dipakai dalam ' . $jumlahPemakaian . ' transaksi pembelian.';
        } else {
            // Aman dihapus
            $stmtHapus = mysqli_prepare($koneksi, 'DELETE FROM supplier WHERE id_supplier = ?');
            if (!$stmtHapus) {
                $error[] = 'Gagal menyiapkan query hapus: ' . mysqli_error($koneksi);
            } else {
                mysqli_stmt_bind_param($stmtHapus, 'i', $id);

                if (mysqli_stmt_execute($stmtHapus)) {
                    mysqli_stmt_close($stmtHapus);
                    header('Location: supplier.php?status=hapus');
                    exit;
                }

                $error[] = 'Gagal menghapus supplier: ' . mysqli_stmt_error($stmtHapus);
                mysqli_stmt_close($stmtHapus);
            }
        }
    }
}

$judul = 'Hapus Supplier';
$halaman = 'supplier';
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <div>
    <span class="badge text-bg-danger mb-2">DELETE</span>
    <h1 class="h3 mb-1">Hapus Supplier</h1>
    <p class="text-secondary mb-0">Konfirmasi penghapusan data pemasok.</p>
  </div>
  <a class="btn btn-outline-secondary" href="supplier.php">Kembali ke Daftar Supplier</a>
</div>

<?php if (count($error) > 0): ?>
  <div class="alert alert-danger">
    <strong>Penghapusan gagal:</strong>
    <ul class="mb-0 mt-2">
      <?php foreach ($error as $pesan): ?>
        <li><?= htmlspecialchars($pesan) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<?php if ($supplier): ?>
  <div class="card mb-4 border-danger">
    <div class="card-header bg-danger text-white fw-semibold">
      Konfirmasi Penghapusan
    </div>
    <div class="card-body">
      <p class="text-danger fw-semibold">
        Apakah Anda yakin ingin menghapus data supplier berikut?
      </p>

      <table class="table table-bordered table-sm mb-4" style="max-width: 500px;">
        <tbody>
          <tr>
            <th class="table-light" style="width: 150px;">ID Supplier</th>
            <td><?= (int) $supplier['id_supplier'] ?></td>
          </tr>
          <tr>
            <th class="table-light">Nama Supplier</th>
            <td class="fw-bold"><?= htmlspecialchars($supplier['nama_supplier']) ?></td>
          </tr>
          <tr>
            <th class="table-light">Kota</th>
            <td><?= $supplier['kota'] !== null && $supplier['kota'] !== '' ? htmlspecialchars($supplier['kota']) : '-' ?></td>
          </tr>
        </tbody>
      </table>

      <form method="post" action="supplier_hapus.php">
        <input type="hidden" name="id_supplier" value="<?= (int) $supplier['id_supplier'] ?>">
        <div class="d-flex gap-2">
          <button class="btn btn-danger" type="submit">Ya, Hapus Supplier</button>
          <a class="btn btn-outline-secondary" href="supplier.php">Batal</a>
        </div>
      </form>
    </div>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/partials/footer.php'; ?>
