    </main>
    <footer class="border-top py-3 mt-5 glass-footer">
      <div class="container text-center text-muted small">
        KasirSMK &middot; Proyek Akhir &middot; <?= date('Y') ?> &middot; <span class="text-success">🌿 3D Nature Ambient Active</span>
      </div>
    </footer>
  </div>

  <!-- Interactive Floating HUD Controls -->
  <div class="floating-hud">
    <div class="hud-panel" id="hudPanel">
      <div class="hud-header">
        <span class="hud-title">🌿 Pilihan Suasana</span>
        <span style="font-size: 0.75rem; color: #34d399;">Aktif</span>
      </div>

      <!-- Atmosphere Preset -->
      <div class="hud-group">
        <label class="hud-label">Waktu & Atmosfer</label>
        <div class="hud-pill-grid">
          <button class="hud-pill-btn active" data-preset="morning">🌅 Pagi</button>
          <button class="hud-pill-btn" data-preset="noon">☀️ Siang</button>
          <button class="hud-pill-btn" data-preset="sunset">🌇 Sore</button>
          <button class="hud-pill-btn" data-preset="night">🌌 Malam</button>
        </div>
      </div>

      <!-- Wind Speed Slider -->
      <div class="hud-group">
        <label class="hud-label">Kecepatan Angin: <span id="windVal" style="color: #6ee7b7;">1.0x</span></label>
        <div class="hud-slider-row">
          <input type="range" id="windSlider" class="hud-slider" min="0" max="3" step="0.1" value="1.0">
        </div>
      </div>

      <!-- Camera Mode Toggle -->
      <div class="hud-group">
        <label class="hud-label">Gerakan Kamera</label>
        <div class="hud-pill-grid">
          <button class="hud-pill-btn active" id="btnCamFlight">🎥 Terbang</button>
          <button class="hud-pill-btn" id="btnCamParallax">🖱️ Kursor</button>
        </div>
      </div>

      <!-- Ambient Sound Synthesizer -->
      <div class="hud-group" style="margin-bottom: 0;">
        <label class="hud-label">Suara Alam (Audio)</label>
        <button class="hud-pill-btn" id="btnAudioToggle" style="width: 100%;">
          🔊 Bunyikan Suara Alam
        </button>
      </div>
    </div>

    <!-- Toggle HUD Panel Button -->
    <button class="hud-btn-toggle" id="btnToggleHud" title="Pengaturan 3D Nature">
      ⚙️
    </button>
  </div>

  <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <?php if (!empty($pakai_jquery) || !empty($pakai_transaksi)): ?>
    <script src="assets/jquery/jquery-3.7.1.min.js"></script>
  <?php endif; ?>
  <?php if (!empty($pakai_jquery)): ?>
    <script src="assets/produk.js"></script>
  <?php endif; ?>
  <?php if (!empty($pakai_transaksi)): ?>
    <script src="assets/transaksi.js"></script>
  <?php endif; ?>

  <!-- Three.js & Nature Background Engine -->
  <script src="assets/three/three.min.js"></script>
  <script>
    if (typeof THREE === 'undefined') {
      document.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"><\/script>');
    }
  </script>
  <script src="assets/nature-background.js"></script>

  <!-- 3D Nature Background Controller Initialization -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      if (typeof NatureBackground3D === 'undefined') return;

      const bg = new NatureBackground3D({
        container: '#nature-3d-bg',
        preset: 'morning',
        windSpeed: 1.0,
        cinematicFlight: true,
        cameraParallax: true
      });

      // HUD Toggle
      const btnToggleHud = document.getElementById('btnToggleHud');
      const hudPanel = document.getElementById('hudPanel');
      if (btnToggleHud && hudPanel) {
        btnToggleHud.addEventListener('click', function () {
          hudPanel.classList.toggle('open');
        });
      }

      // Presets
      const presetButtons = document.querySelectorAll('[data-preset]');
      presetButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
          presetButtons.forEach(function (b) { b.classList.remove('active'); });
          btn.classList.add('active');
          bg.setPreset(btn.dataset.preset);
        });
      });

      // Wind
      const windSlider = document.getElementById('windSlider');
      const windVal = document.getElementById('windVal');
      if (windSlider && windVal) {
        windSlider.addEventListener('input', function (e) {
          const val = parseFloat(e.target.value);
          windVal.textContent = val.toFixed(1) + 'x';
          bg.setWindSpeed(val);
        });
      }

      // Camera
      const btnFlight = document.getElementById('btnCamFlight');
      const btnParallax = document.getElementById('btnCamParallax');
      if (btnFlight && btnParallax) {
        btnFlight.addEventListener('click', function () {
          btnFlight.classList.add('active');
          btnParallax.classList.remove('active');
          bg.setCinematicFlight(true);
        });
        btnParallax.addEventListener('click', function () {
          btnParallax.classList.add('active');
          btnFlight.classList.remove('active');
          bg.setCinematicFlight(false);
        });
      }

      // Audio
      const btnAudio = document.getElementById('btnAudioToggle');
      if (btnAudio) {
        btnAudio.addEventListener('click', function () {
          const playing = bg.toggleAudio();
          if (playing) {
            btnAudio.textContent = '🔇 Matikan Suara';
            btnAudio.classList.add('active');
          } else {
            btnAudio.textContent = '🔊 Bunyikan Suara Alam';
            btnAudio.classList.remove('active');
          }
        });
      }

      // Toggle UI
      const btnToggleUI = document.getElementById('btnToggleUI');
      const websiteContent = document.getElementById('websiteContent');
      const uiToggleText = document.getElementById('uiToggleText');
      if (btnToggleUI && websiteContent && uiToggleText) {
        btnToggleUI.addEventListener('click', function () {
          const isHidden = websiteContent.classList.toggle('ui-hidden');
          uiToggleText.textContent = isHidden ? 'Tampilkan UI' : 'Sembunyikan UI';
        });
      }
    });
  </script>
</body>
</html>
