<?php
$judul = 'Profil Tim';
$halaman = 'profil';
require __DIR__ . '/partials/header.php';

// Daftar 6 anggota tim NKRPPLG
$anggota = [
    [
        'nama' => 'elRafaels',
        'panggilan' => 'Rafael Siregar',
        'kelas' => 'XI PPLG 2',
        'peran' => 'Supplier Lead & UI/UX Designer',
        'deskripsi' => 'Bertanggung jawab atas perancangan arsitektur modul Supplier, validasi data, redesain antarmuka dark nature glassmorphism, dan integrasi kode.',
        'tugas' => ['Modul Supplier', 'UI/UX Redesign', 'Code Integration'],
        'warna_bg' => '#10b981',
        'gender' => 'male_suit_blue',
        'github' => 'elRafaels'
    ],
    [
        'nama' => 'alftihahkahfi',
        'panggilan' => 'Alfat Kahfi',
        'kelas' => 'XI PPLG 2',
        'peran' => 'Database Administrator & Kasir Lead',
        'deskripsi' => 'Mengelola skema database db_penjualan, konfigurasi MySQL, implementasi alur formulir kasir, dan optimasi query transaksi.',
        'tugas' => ['Database Schema', 'Modul Kasir', 'MySQL Query'],
        'warna_bg' => '#34d399',
        'gender' => 'male_suit_dark',
        'github' => 'alftihahkahfi'
    ],
    [
        'nama' => 'ivanadityah',
        'panggilan' => 'Ivan Aditya',
        'kelas' => 'XI PPLG 1',
        'peran' => 'Project Manager & System Coordinator',
        'deskripsi' => 'Mengkoordinasikan linimasa kerja kelompok, penyelarasan tugas modul, pengujian alur fungsional sistem, dan integrasi akhir.',
        'tugas' => ['Project Management', 'Team Timeline', 'System Testing'],
        'warna_bg' => '#38bdf8',
        'gender' => 'male_formal_tie',
        'github' => 'ivanadityah'
    ],
    [
        'nama' => 'Zhang Ai mi',
        'panggilan' => 'Panji / Shouki',
        'kelas' => 'XI PPLG 2',
        'peran' => 'Frontend & Interaction Specialist',
        'deskripsi' => 'Mengembangkan tata letak antarmuka responsif Bootstrap, estetika visual, kenyamanan pengguna, dan konsistensi halaman antarmuka.',
        'tugas' => ['UI Responsiveness', 'Layouting', 'Form Interaction'],
        'warna_bg' => '#a78bfa',
        'gender' => 'male_formal',
        'github' => 'Zhang-Ai-mi'
    ],
    [
        'nama' => 'orenss567-byte',
        'panggilan' => 'Alif Febrian',
        'kelas' => 'XI PPLG 2',
        'peran' => 'Quality Assurance & Security Testing',
        'deskripsi' => 'Melakukan pengujian fitur sistem (test cases), verifikasi keamanan prepared statement, pengecekan sanitasi input, dan penjaminan mutu.',
        'tugas' => ['Security Verification', 'Quality Assurance', 'Input Sanitization'],
        'warna_bg' => '#fbbf24',
        'gender' => 'male_glasses',
        'github' => 'orenss567-byte'
    ],
    [
        'nama' => 'UNKNOWN',
        'panggilan' => 'Special Contributor',
        'kelas' => 'XI PPLG 1',
        'peran' => 'Research & Project Support',
        'deskripsi' => 'Mendukung riset kebutuhan alur transaksi ritel Toko Maju Jaya, pencocokan studi kasus SMK, pengumpulan data referensi, dan asistensi tim.',
        'tugas' => ['Research & Support', 'Retail Study', 'Project Helper'],
        'warna_bg' => '#94a3b8',
        'gender' => 'female_formal',
        'github' => 'NKRPPLG'
    ],
];

// Helper function untuk render SVG Avatar Formal secara offline
function renderAvatarFormal(string $tipe, int $size = 54): string {
    $dim = 'width="' . $size . '" height="' . $size . '" style="width: 100%; height: 100%; display: block;"';
    switch ($tipe) {
        case 'male_suit_blue':
            // Pria jas navy, kemeja putih, dasi merah maroon
            return '<svg viewBox="0 0 100 100" ' . $dim . ' xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="50" fill="#0b1726"/>
                <path d="M18 100 L32 62 L42 62 L44 80 L35 100 Z" fill="#1e3a5f"/>
                <path d="M82 100 L68 62 L58 62 L56 80 L65 100 Z" fill="#1e3a5f"/>
                <path d="M20 100 Q20 70 35 60 L65 60 Q80 70 80 100 Z" fill="#0a192f"/>
                <polygon points="42,60 58,60 55,82 45,82" fill="#ffffff"/>
                <polygon points="42,60 48,70 50,60" fill="#cbd5e1"/>
                <polygon points="58,60 52,70 50,60" fill="#cbd5e1"/>
                <polygon points="48,63 52,63 53,82 50,88 47,82" fill="#b91c1c"/>
                <rect x="44" y="50" width="12" height="14" fill="#fed7aa" rx="2"/>
                <ellipse cx="50" cy="40" rx="16" ry="19" fill="#fcd34d"/>
                <ellipse cx="50" cy="41" rx="15" ry="18" fill="#fed7aa"/>
                <path d="M33 37 Q33 21 50 20 Q67 21 67 37 Q63 28 50 27 Q37 28 33 37 Z" fill="#1e293b"/>
            </svg>';

        case 'male_suit_dark':
            // Pria jas charcoal, dasi teal
            return '<svg viewBox="0 0 100 100" ' . $dim . ' xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="50" fill="#091815"/>
                <path d="M18 100 Q20 68 36 60 L64 60 Q80 68 82 100 Z" fill="#1e293b"/>
                <polygon points="41,60 59,60 55,84 45,84" fill="#ffffff"/>
                <polygon points="41,60 47,71 50,60" fill="#e2e8f0"/>
                <polygon points="59,60 53,71 50,60" fill="#e2e8f0"/>
                <polygon points="48,64 52,64 53,84 50,90 47,84" fill="#10b981"/>
                <rect x="44" y="50" width="12" height="14" fill="#fed7aa"/>
                <ellipse cx="50" cy="40" rx="15" ry="18" fill="#fed7aa"/>
                <path d="M34 38 Q34 22 51 21 Q66 22 66 38 Q58 29 51 28 Q39 29 34 38 Z" fill="#334155"/>
            </svg>';

        case 'male_formal_tie':
            // Pria kemeja biru muda dasi navy
            return '<svg viewBox="0 0 100 100" ' . $dim . ' xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="50" fill="#0c1929"/>
                <path d="M18 100 Q20 68 36 60 L64 60 Q80 68 82 100 Z" fill="#334155"/>
                <polygon points="42,60 58,60 55,84 45,84" fill="#e0f2fe"/>
                <polygon points="42,60 47,70 50,60" fill="#bae6fd"/>
                <polygon points="58,60 53,70 50,60" fill="#bae6fd"/>
                <polygon points="48,63 52,63 53,84 50,89 47,84" fill="#0284c7"/>
                <rect x="44" y="50" width="12" height="14" fill="#fcd34d" rx="2"/>
                <ellipse cx="50" cy="40" rx="15" ry="18" fill="#fcd34d"/>
                <path d="M34 36 Q34 20 50 19 Q66 20 66 36 Q60 28 50 27 Q38 28 34 36 Z" fill="#451a03"/>
            </svg>';

        case 'male_formal':
            // Pria formal blazer & dasi violet
            return '<svg viewBox="0 0 100 100" ' . $dim . ' xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="50" fill="#150f24"/>
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
            return '<svg viewBox="0 0 100 100" ' . $dim . ' xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="50" fill="#1c1406"/>
                <path d="M18 100 Q20 68 36 60 L64 60 Q80 68 82 100 Z" fill="#1e293b"/>
                <polygon points="42,60 58,60 55,84 45,84" fill="#ffffff"/>
                <polygon points="48,63 52,63 53,83 50,88 47,83" fill="#d97706"/>
                <rect x="44" y="50" width="12" height="14" fill="#fed7aa"/>
                <ellipse cx="50" cy="40" rx="15" ry="18" fill="#fed7aa"/>
                <rect x="38" y="36" width="10" height="7" rx="1.5" fill="none" stroke="#f8fafc" stroke-width="1.8"/>
                <rect x="52" y="36" width="10" height="7" rx="1.5" fill="none" stroke="#f8fafc" stroke-width="1.8"/>
                <line x1="48" y1="39" x2="52" y2="39" stroke="#f8fafc" stroke-width="1.8"/>
                <path d="M34 36 Q34 21 50 20 Q66 21 66 36 Q58 27 50 27 Q40 27 34 36 Z" fill="#1e293b"/>
            </svg>';

        case 'female_formal':
        default:
            // Avatar Formal Profesional
            return '<svg viewBox="0 0 100 100" ' . $dim . ' xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="50" fill="#0f172a"/>
                <path d="M18 100 Q20 68 36 60 L64 60 Q80 68 82 100 Z" fill="#1e293b"/>
                <polygon points="42,60 58,60 55,84 45,84" fill="#ffffff"/>
                <polygon points="48,63 52,63 53,83 50,88 47,83" fill="#64748b"/>
                <rect x="44" y="50" width="12" height="14" fill="#94a3b8"/>
                <ellipse cx="50" cy="40" rx="15" ry="18" fill="#cbd5e1"/>
                <circle cx="50" cy="40" r="6" fill="#34d399"/>
            </svg>';
    }
}
?>

<!-- Compact 3D Nature Hero Header -->
<div class="card p-3 p-md-4 mb-3 profile-hero-3d">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div class="d-flex align-items-center gap-3">
      <div class="hero-3d-badge">
        🌿
      </div>
      <div>
        <div class="d-flex align-items-center gap-2 mb-1">
          <span class="badge badge-emerald">Tim Pengembang</span>
          <span class="text-muted small">&bull;</span>
          <span class="small text-light" style="opacity: 0.85;">Organisasi <strong>NKRPPLG</strong></span>
        </div>
        <h1 class="h5 fw-bold mb-0 text-white profile-hero-title">Profil Kelompok Pengembang KasirSMK</h1>
      </div>
    </div>
    <div class="d-flex align-items-center gap-2">
      <span class="badge badge-emerald">4 Siswa XI PPLG 2</span>
      <span class="badge badge-amber">2 Siswa XI PPLG 1</span>
    </div>
  </div>
</div>

<!-- Grid 6 Kartu Profil Anggota (Compact 3D Nature Cards) -->
<div class="row g-3 mb-3">
  <?php foreach ($anggota as $item): ?>
    <div class="col-md-6 col-lg-4">
      <div class="card h-100 profile-card-3d p-3" style="--card-glow: <?= $item['warna_bg'] ?>26;">
        <!-- Top Row: Avatar + Identity -->
        <div class="d-flex align-items-center gap-3 mb-2">
          <div class="avatar-orb flex-shrink-0" style="border-color: <?= $item['warna_bg'] ?>66; box-shadow: 0 0 12px <?= $item['warna_bg'] ?>33;">
            <?= renderAvatarFormal($item['gender'], 54) ?>
          </div>
          <div class="flex-grow-1 min-w-0">
            <div class="d-flex align-items-center justify-content-between gap-1 mb-1">
              <h3 class="h6 fw-bold mb-0 text-white text-truncate" title="<?= htmlspecialchars($item['nama']) ?>">
                <?= htmlspecialchars($item['nama']) ?>
              </h3>
              <span class="badge <?= $item['kelas'] === 'XI PPLG 1' ? 'badge-amber' : 'badge-emerald' ?>">
                <?= htmlspecialchars($item['kelas']) ?>
              </span>
            </div>
            <div class="member-nickname text-truncate"><?= htmlspecialchars($item['panggilan']) ?></div>
          </div>
        </div>

        <!-- Role Pill (Glow 3D Chip) -->
        <div class="mb-2">
          <div class="member-role text-truncate" title="<?= htmlspecialchars($item['peran']) ?>">
            <span style="color: <?= $item['warna_bg'] ?>;">✦</span>
            <?= htmlspecialchars($item['peran']) ?>
          </div>
        </div>

        <!-- Description (Crisp & Compact) -->
        <p class="member-desc" title="<?= htmlspecialchars($item['deskripsi']) ?>">
          <?= htmlspecialchars($item['deskripsi']) ?>
        </p>

        <!-- Footer: Task Pills + GitHub Link -->
        <div class="mt-auto pt-2 border-top-glass d-flex align-items-center justify-content-between gap-2">
          <div class="d-flex flex-wrap gap-1 overflow-hidden" style="max-height: 24px;">
            <?php foreach (array_slice($item['tugas'], 0, 2) as $t): ?>
              <span class="task-pill"><?= htmlspecialchars($t) ?></span>
            <?php endforeach; ?>
          </div>
          <a href="https://github.com/<?= htmlspecialchars($item['github']) ?>" target="_blank" rel="noopener noreferrer" class="github-pill" title="GitHub @<?= htmlspecialchars($item['github']) ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-github me-1" viewBox="0 0 16 16">
              <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8"/>
            </svg>
            <span>@<?= htmlspecialchars($item['github']) ?></span>
          </a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<!-- Navigasi Cepat Proyek -->
<div class="card p-3 mb-3 profile-quick-nav">
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
    <span class="small text-muted d-flex align-items-center gap-1">
      <span style="color: #34d399;">🌿</span> Navigasi Modul:
    </span>
    <div class="d-flex flex-wrap gap-2">
      <a class="btn btn-sm btn-outline-success text-white px-3" href="supplier.php">Supplier</a>
      <a class="btn btn-sm btn-outline-success text-white px-3" href="kasir.php">Kasir</a>
      <a class="btn btn-sm btn-outline-success text-white px-3" href="penjualan.php">Penjualan</a>
      <a class="btn btn-sm btn-outline-success text-white px-3" href="produk.php">Produk</a>
      <a class="btn btn-sm btn-success text-white px-3" href="index.php">Dashboard</a>
    </div>
  </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
