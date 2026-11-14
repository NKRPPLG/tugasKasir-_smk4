  </main>
  <footer class="border-top bg-white py-3 mt-5">
    <div class="container text-center text-secondary small">
      KasirSMK &middot; Proyek Akhir &middot; <?= date('Y') ?>
    </div>
  </footer>
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
</body>
</html>
