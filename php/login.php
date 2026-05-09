<?php
$pageTitle = 'Connexion';
include __DIR__ . '/partials/head.php';
?>

<div class="auth-shell">
  <div class="position-absolute top-0 start-0 w-100 grid-bg" style="height: 100vh;"></div>

  <div class="auth-card position-relative spotlight-card">
    <a href="index.php" class="auth-brand text-decoration-none">
      <img src="<?= e(asinco_url('assets/img/logo.png')) ?>" alt="ASINCO" class="brand-logo">
      <span>ASINCO</span>
    </a>

    <h1 class="h3 mb-1">Bon retour.</h1>
    <p class="text-muted small mb-4">Connectez-vous pour accéder au pilotage du parc.</p>

    <form method="post" action="dashboard.php" novalidate>
      <div class="mb-3">
        <label for="email" class="form-label">
          Identifiant <span class="required">*</span>
        </label>
        <input type="text" class="form-control" id="email" name="email"
               placeholder="prenom.nom@asinco.bj" autocomplete="username" required>
      </div>

      <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center">
          <label for="password" class="form-label mb-0">
            Mot de passe <span class="required">*</span>
          </label>
          <a href="#" class="small text-muted">Oublié ?</a>
        </div>
        <div class="input-group mt-2">
          <input type="password" class="form-control" id="password" name="password"
                 placeholder="••••••••" autocomplete="current-password" required>
          <button type="button" class="input-group-text btn-ghost" aria-label="Afficher" onclick="
            const i=document.getElementById('password');
            i.type = i.type==='password' ? 'text' : 'password';
            this.querySelector('[data-lucide]').setAttribute('data-lucide', i.type==='password'?'eye':'eye-off');
            lucide.createIcons();">
            <i data-lucide="eye"></i>
          </button>
        </div>
      </div>

      <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" id="remember" name="remember">
        <label class="form-check-label small text-muted" for="remember">Rester connecté pendant 7 jours</label>
      </div>

      <button type="submit" class="btn btn-primary w-100 d-inline-flex align-items-center justify-content-center gap-2">
        <span>Se connecter</span>
        <i data-lucide="arrow-right" class="icon-sm"></i>
      </button>
    </form>

    <p class="text-center text-muted small mt-4 mb-0">
      Pas de compte ? Contactez votre administrateur ASINCO.
    </p>
  </div>

  <div class="d-flex flex-wrap align-items-center gap-3 mt-4">
    <a href="index.php" class="text-muted small d-inline-flex align-items-center gap-1">
      <i data-lucide="arrow-left" class="icon-sm"></i> Retour à l'accueil
    </a>
    <span class="ms-auto"></span>
    <?php include __DIR__ . '/partials/theme-toggle.php'; ?>
  </div>
</div>

<?php include __DIR__ . '/partials/confirm-modal.php'; ?>
<?php include __DIR__ . '/partials/toast-host.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<script src="<?= e(asinco_url('assets/js/main.js')) ?>"></script>
</body>
</html>
