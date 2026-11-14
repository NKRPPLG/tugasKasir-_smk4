    </main>
    <!-- END konten halaman -->

    <!-- Footer -->
    <footer class="ks-footer">
      Kasir KMH &middot; Koperasi Merah Hitam &middot; <?= date('Y') ?>
    </footer>

  </div>
  <!-- END area konten -->

</div>
<!-- END layout wrapper -->

<!-- Bootstrap JS -->
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- jQuery (opsional, hanya kalau halaman butuh) -->
<?php if (!empty($pakai_jquery) || !empty($pakai_transaksi)): ?>
  <script src="assets/jquery/jquery-3.7.1.min.js"></script>
<?php endif; ?>
<?php if (!empty($pakai_jquery)): ?>
  <script src="assets/produk.js"></script>
<?php endif; ?>
<?php if (!empty($pakai_transaksi)): ?>
  <script src="assets/transaksi.js"></script>
<?php endif; ?>

<!-- Script sidebar mobile -->
<script>
(function () {
  var sidebar  = document.getElementById('ksSidebar');
  var overlay  = document.getElementById('ksOverlay');
  var hamburger = document.getElementById('ksHamburger');

  function openSidebar() {
    sidebar.classList.add('open');
    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeSidebar() {
    sidebar.classList.remove('open');
    overlay.classList.remove('open');
    document.body.style.overflow = '';
  }

  if (hamburger) hamburger.addEventListener('click', openSidebar);
  if (overlay)   overlay.addEventListener('click', closeSidebar);
})();
</script>

</body>
</html>
