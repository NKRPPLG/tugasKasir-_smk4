<?php
$judul = 'Profil Tim';
$halaman = 'profil';
require __DIR__ . '/partials/header.php';

// Daftar 6 anggota tim NKRPPLG
$anggota = [
    [
        'nama' => 'Rafael siregar',
        'panggilan' => 'Rafael',
        'kelas' => 'XI PPLG 2',
        'peran' => 'Supplier Lead & UI/UX Designer',
        'deskripsi' => 'Bertanggung jawab atas arsitektur modul Supplier, validasi data, serta perancangan tema, visual sistem, dan alur antarmuka kasir.',
        'tugas' => ['Modul Supplier', 'UI/UX Redesign', 'Code Integration'],
        'warna_bg' => '#1e3a5f',
        'gender' => 'male_suit_blue',
        'github' => 'elRafaels'
    ],
    [
        'nama' => 'alftihahkahfi',
        'panggilan' => 'Alfat',
        'kelas' => 'XI PPLG 2',
        'peran' => 'Database Administrator & Kasir Lead',
        'deskripsi' => 'Mengelola skema database db_penjualan, konfigurasi MySQL, implementasi form dan alur kerja pada modul Kasir.',
        'tugas' => ['Database Schema', 'Modul Kasir', 'MySQL Query'],
        'warna_bg' => '#0f766e',
        'gender' => 'male_suit_dark',
        'github' => 'alftihahkahfi'
    ],
    [
        'nama' => 'ivanadityah',
        'panggilan' => 'Ivan',
        'kelas' => 'XI PPLG 1',
        'peran' => 'Project Manager & Clone Tester',
        'deskripsi' => 'Ngeclone dan menjelaskan',
        'tugas' => ['Project Management', 'Cloning'],
        'warna_bg' => '#334155',
        'gender' => 'male_formal_tie',
        'github' => 'ivanadityah'
    ],
    [
        'nama' => 'Shouki',
        'panggilan' => 'Panji ',
        'kelas' => 'XI PPLG 2',
        'peran' => 'Clone tester',
        'deskripsi' => 'Ngeclone dari Git',
        'tugas' => ['Cloning'],
        'warna_bg' => '#475569',
        'gender' => 'male_formal',
        'github' => 'Zhang-Ai-mi'
    ],
    [
        'nama' => 'Alif febrian',
        'panggilan' => 'Alif ',
        'kelas' => 'XI PPLG 2',
        'peran' => 'Clone tester',
        'deskripsi' => 'Ngeclone dari Git',
        'tugas' => ['Cloning'],
        'warna_bg' => '#78350f',
        'gender' => 'male_glasses',
        'github' => 'orenss567-byte'
    ],
    [
        'nama' => 'UNKNOWN',
        'panggilan' => 'Unknown',
        'kelas' => 'XI PPLG 1',
        'peran' => 'Unknown',
        'deskripsi' => 'Unknown',
        'tugas' => ['Unknown'],
        'warna_bg' => '#1e293b',
        'gender' => 'female_formal',
        'github' => 'NKRPPLG'
    ],
];

// Helper function untuk render SVG Avatar Formal secara offline
function renderAvatarFormal(string $tipe): string {
    switch ($tipe) {
        case 'male_suit_blue':
            // Pria jas navy, kemeja putih, dasi merah maroon
            return '<svg viewBox="0 0 100 100" class="rounded-circle shadow-sm" width="96" height="96" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="50" fill="#e2e8f0"/>
                <!-- Jas / Blazer -->
                <path d="M18 100 L32 62 L42 62 L44 80 L35 100 Z" fill="#1e3a5f"/>
                <path d="M82 100 L68 62 L58 62 L56 80 L65 100 Z" fill="#1e3a5f"/>
                <!-- Bahu Jas -->
                <path d="M20 100 Q20 70 35 60 L65 60 Q80 70 80 100 Z" fill="#1e293b"/>
                <!-- Kemeja Putih -->
                <polygon points="42,60 58,60 55,82 45,82" fill="#ffffff"/>
                <!-- Kerah Kemeja -->
                <polygon points="42,60 48,70 50,60" fill="#cbd5e1"/>
                <polygon points="58,60 52,70 50,60" fill="#cbd5e1"/>
                <!-- Dasi Maroon -->
                <polygon points="48,63 52,63 53,82 50,88 47,82" fill="#991b1b"/>
                <!-- Leher -->
                <rect x="44" y="50" width="12" height="14" fill="#fed7aa" rx="2"/>
                <!-- Kepala / Wajah -->
                <ellipse cx="50" cy="40" rx="16" ry="19" fill="#fcd34d"/>
                <ellipse cx="50" cy="41" rx="15" ry="18" fill="#fed7aa"/>
                <!-- Rambut Rapi Formal -->
                <path d="M33 37 Q33 21 50 20 Q67 21 67 37 Q63 28 50 27 Q37 28 33 37 Z" fill="#1e293b"/>
            </svg>';

        case 'male_suit_dark':
            // Pria jas charcoal, dasi teal
            return '<svg viewBox="0 0 100 100" class="rounded-circle shadow-sm" width="96" height="96" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="50" fill="#e2e8f0"/>
                <!-- Jas -->
                <path d="M18 100 Q20 68 36 60 L64 60 Q80 68 82 100 Z" fill="#0f172a"/>
                <!-- Kemeja Putih -->
                <polygon points="41,60 59,60 55,84 45,84" fill="#ffffff"/>
                <!-- Kerah Kemeja -->
                <polygon points="41,60 47,71 50,60" fill="#cbd5e1"/>
                <polygon points="59,60 53,71 50,60" fill="#cbd5e1"/>
                <!-- Dasi Teal -->
                <polygon points="48,64 52,64 53,84 50,90 47,84" fill="#0f766e"/>
                <!-- Leher -->
                <rect x="44" y="50" width="12" height="14" fill="#fed7aa"/>
                <!-- Kepala -->
                <ellipse cx="50" cy="40" rx="15" ry="18" fill="#fed7aa"/>
                <!-- Rambut Side-parted -->
                <path d="M34 38 Q34 22 51 21 Q66 22 66 38 Q58 29 51 28 Q39 29 34 38 Z" fill="#334155"/>
            </svg>';

        case 'male_formal_tie':
            // Pria kemeja biru muda dasi navy
            return '<svg viewBox="0 0 100 100" class="rounded-circle shadow-sm" width="96" height="96" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="50" fill="#e2e8f0"/>
                <!-- Jas Abu-abu -->
                <path d="M18 100 Q20 68 36 60 L64 60 Q80 68 82 100 Z" fill="#334155"/>
                <!-- Kemeja Biru Muda -->
                <polygon points="42,60 58,60 55,84 45,84" fill="#e0f2fe"/>
                <!-- Kerah -->
                <polygon points="42,60 47,70 50,60" fill="#bae6fd"/>
                <polygon points="58,60 53,70 50,60" fill="#bae6fd"/>
                <!-- Dasi -->
                <polygon points="48,63 52,63 53,84 50,89 47,84" fill="#0369a1"/>
                <!-- Leher & Wajah -->
                <rect x="44" y="50" width="12" height="14" fill="#fcd34d" rx="2"/>
                <ellipse cx="50" cy="40" rx="15" ry="18" fill="#fcd34d"/>
                <!-- Rambut Cokelat Gelap -->
                <path d="M34 36 Q34 20 50 19 Q66 20 66 36 Q60 28 50 27 Q38 28 34 36 Z" fill="#451a03"/>
            </svg>';

        case 'male_formal':
            // Pria formal blazer & dasi violet
            return '<svg viewBox="0 0 100 100" class="rounded-circle shadow-sm" width="96" height="96" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="50" fill="#e2e8f0"/>
                <path d="M18 100 Q20 68 36 60 L64 60 Q80 68 82 100 Z" fill="#1e1b4b"/>
                <polygon points="42,60 58,60 55,84 45,84" fill="#ffffff"/>
                <polygon points="42,60 47,70 50,60" fill="#cbd5e1"/>
                <polygon points="58,60 53,70 50,60" fill="#cbd5e1"/>
                <polygon points="48,63 52,63 53,84 50,89 47,84" fill="#7c3aed"/>
                <rect x="44" y="50" width="12" height="14" fill="#fed7aa" rx="2"/>
                <ellipse cx="50" cy="40" rx="15" ry="18" fill="#fed7aa"/>
                <path d="M34 36 Q34 20 50 19 Q66 20 66 36 Q58 27 50 27 Q40 27 34 36 Z" fill="#1e293b"/>
            </svg>';

        case 'male_glasses':
            // Pria formal kacamata & dasi amber
            return '<svg viewBox="0 0 100 100" class="rounded-circle shadow-sm" width="96" height="96" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="50" fill="#e2e8f0"/>
                <!-- Jas Formal -->
                <path d="M18 100 Q20 68 36 60 L64 60 Q80 68 82 100 Z" fill="#1e293b"/>
                <!-- Kemeja Putih & Dasi Amber -->
                <polygon points="42,60 58,60 55,84 45,84" fill="#ffffff"/>
                <polygon points="48,63 52,63 53,83 50,88 47,83" fill="#d97706"/>
                <!-- Leher & Wajah -->
                <rect x="44" y="50" width="12" height="14" fill="#fed7aa"/>
                <ellipse cx="50" cy="40" rx="15" ry="18" fill="#fed7aa"/>
                <!-- Kacamata Formal -->
                <rect x="38" y="36" width="10" height="7" rx="1.5" fill="none" stroke="#0f172a" stroke-width="1.8"/>
                <rect x="52" y="36" width="10" height="7" rx="1.5" fill="none" stroke="#0f172a" stroke-width="1.8"/>
                <line x1="48" y1="39" x2="52" y2="39" stroke="#0f172a" stroke-width="1.8"/>
                <!-- Rambut -->
                <path d="M34 36 Q34 21 50 20 Q66 21 66 36 Q58 27 50 27 Q40 27 34 36 Z" fill="#1e293b"/>
            </svg>';

        case 'female_formal':
        default:
            // Avatar Formal Profesional
            return '<svg viewBox="0 0 100 100" class="rounded-circle shadow-sm" width="96" height="96" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="50" fill="#e2e8f0"/>
                <!-- Jas Gelap -->
                <path d="M18 100 Q20 68 36 60 L64 60 Q80 68 82 100 Z" fill="#1e293b"/>
                <!-- Kemeja & Dasi Slate -->
                <polygon points="42,60 58,60 55,84 45,84" fill="#ffffff"/>
                <polygon points="48,63 52,63 53,83 50,88 47,83" fill="#64748b"/>
                <!-- Kepala Siluet Halus -->
                <rect x="44" y="50" width="12" height="14" fill="#94a3b8"/>
                <ellipse cx="50" cy="40" rx="15" ry="18" fill="#cbd5e1"/>
                <!-- Tanda Bintang Kontributor -->
                <circle cx="50" cy="40" r="6" fill="#3b82f6"/>
            </svg>';
    }
}
?>

<!-- Header Hero Profil -->
<div class="page-hero p-4 p-md-5 mb-4">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
      <span class="badge text-bg-warning mb-2">TIM PENGEMBANG</span>
      <h1 class="display-6 fw-bold mb-2">Profil Kelompok NKRPPLG</h1>
      <p class="lead mb-0">
        Pengembang aplikasi KasirSMK &middot; Proyek Akhir P15-P16 Toko Maju Jaya.
      </p>
    </div>
    <div class="d-none d-md-block text-end">
      <span class="badge text-bg-light fs-6 px-3 py-2 text-dark border">
        Total: <strong>6 Anggota</strong>
      </span>
    </div>
  </div>
</div>

<!-- Info Banner Tim -->
<div class="card mb-4 bg-white">
  <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-2 py-3">
    <div class="d-flex align-items-center gap-3">
      <div class="p-2 bg-light rounded text-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
          <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
        </svg>
      </div>
      <div>
        <h2 class="h6 mb-0 fw-bold">Organisasi: NKRPPLG</h2>
        <small class="text-secondary">Kolaborasi siswa jurusan Pengembangan Perangkat Lunak dan GIM (PPLG)</small>
      </div>
    </div>
    <div>
      <span class="badge text-bg-primary me-1">XI PPLG 2 (4 Orang)</span>
      <span class="badge text-bg-warning">XI PPLG 1 (2 Orang)</span>
    </div>
  </div>
</div>

<!-- Grid 6 Kartu Profil Anggota -->
<div class="row g-4 mb-5">
  <?php foreach ($anggota as $item): ?>
    <div class="col-md-6 col-lg-4">
      <div class="card h-100 shadow-sm border-0 border-top border-3" style="border-top-color: <?= $item['warna_bg'] ?> !important;">
        <div class="card-body d-flex flex-column text-center p-4">
          <!-- Avatar Formal -->
          <div class="mx-auto mb-3">
            <?= renderAvatarFormal($item['gender']) ?>
          </div>

          <!-- Nama & Identitas -->
          <h3 class="h5 fw-bold mb-1 text-dark"><?= htmlspecialchars($item['nama']) ?></h3>
          <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
            <span class="text-secondary small fw-semibold"><?= htmlspecialchars($item['panggilan']) ?></span>
            <span class="text-muted">&bull;</span>
            <span class="badge <?= $item['kelas'] === 'XI PPLG 1' ? 'text-bg-warning' : 'text-bg-primary' ?>">
              <?= htmlspecialchars($item['kelas']) ?>
            </span>
          </div>

          <!-- Peran / Role -->
          <div class="p-2 rounded bg-light mb-3">
            <span class="small fw-bold text-primary"><?= htmlspecialchars($item['peran']) ?></span>
          </div>

          <!-- Deskripsi Kontribusi -->
          <p class="text-secondary small flex-grow-1 mb-3" style="line-height: 1.5;">
            <?= htmlspecialchars($item['deskripsi']) ?>
          </p>

          <!-- Tag Tugas / Keahlian -->
          <div class="d-flex flex-wrap justify-content-center gap-1 pt-2 border-top">
            <?php foreach ($item['tugas'] as $t): ?>
              <span class="badge text-bg-secondary" style="font-size: 0.7rem; font-weight: 500;">
                <?= htmlspecialchars($t) ?>
              </span>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Footer Card: Akun GitHub -->
        <div class="card-footer bg-white border-top-0 pb-3 text-center">
          <small class="text-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-github me-1" viewBox="0 0 16 16">
              <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8"/>
            </svg>
            @<?= htmlspecialchars($item['github']) ?>
          </small>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<!-- Navigasi Cepat -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 p-3 bg-white rounded border">
  <span class="text-secondary small">Navigasi Proyek:</span>
  <div class="d-flex flex-wrap gap-2">
    <a class="btn btn-sm btn-outline-primary" href="supplier.php">Modul Supplier</a>
    <a class="btn btn-sm btn-outline-primary" href="kasir.php">Modul Kasir</a>
    <a class="btn btn-sm btn-outline-primary" href="penjualan.php">Modul Penjualan</a>
    <a class="btn btn-sm btn-outline-primary" href="produk.php">Modul Produk</a>
    <a class="btn btn-sm btn-primary" href="index.php">Ke Dashboard</a>
  </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
