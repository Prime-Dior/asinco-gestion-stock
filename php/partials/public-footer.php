  <footer class="app-footer mt-0">
  <div class="container d-flex flex-wrap justify-content-between align-items-center gap-3">
    <div>© <?= date('Y') ?> ASINCO. Tous droits réservés.</div>
    <?php include __DIR__ . '/theme-toggle.php'; ?>
  </div>
</footer>

<?php include __DIR__ . '/confirm-modal.php'; ?>
<?php include __DIR__ . '/toast-host.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<script src="<?= e(asinco_url('assets/js/main.js')) ?>"></script>
</body>
</html>
