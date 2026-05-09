<?php
$pageTitle = 'Paramètres';
include __DIR__ . '/partials/app-header.php';
?>

<div class="page-header">
  <div>
    <span class="eyebrow mb-2"><i data-lucide="settings-2" class="icon-sm text-accent"></i>Système</span>
    <h1>Paramètres</h1>
    <p class="subtitle">Préférences d'affichage et configuration de votre compte ASINCO.</p>
  </div>
</div>

<div class="row g-4">
  <!-- Apparence -->
  <div class="col-lg-8">
    <div class="card-soft">
      <h2 class="h6 mb-1">Apparence</h2>
      <p class="text-muted small mb-3">Choisissez le thème de l'interface. Le mode système suit les préférences de votre OS.</p>

      <div class="d-flex align-items-center gap-3 flex-wrap">
        <?php include __DIR__ . '/partials/theme-toggle.php'; ?>
        <span class="text-muted small">
          Thème actif : <span id="themeStatus" class="text-accent fw-medium">—</span>
        </span>
      </div>

      <div class="divider-soft"></div>

      <h2 class="h6 mb-1">Densité d'affichage</h2>
      <p class="text-muted small mb-3">Confortable pour la lecture, compacte pour les longs tableaux.</p>
      <div class="btn-group btn-group-sm" role="group" aria-label="Densité">
        <button type="button" class="btn btn-outline-light is-active" data-density-set="cozy">Confortable</button>
        <button type="button" class="btn btn-outline-light" data-density-set="compact">Compacte</button>
      </div>
    </div>

    <div class="card-soft mt-4">
      <h2 class="h6 mb-1">Notifications</h2>
      <p class="text-muted small mb-3">Activez les rappels de maintenance et les alertes d'état.</p>
      <div class="form-check form-switch mb-2">
        <input class="form-check-input" type="checkbox" role="switch" id="notifMaintenance" data-pref="notif.maintenance" checked>
        <label class="form-check-label" for="notifMaintenance">Rappels de maintenance préventive</label>
      </div>
      <div class="form-check form-switch mb-2">
        <input class="form-check-input" type="checkbox" role="switch" id="notifEtat" data-pref="notif.etat" checked>
        <label class="form-check-label" for="notifEtat">Alertes de changement d'état</label>
      </div>
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="notifEmail" data-pref="notif.email">
        <label class="form-check-label" for="notifEmail">Recevoir un récap hebdomadaire par email</label>
      </div>
    </div>
  </div>

  <!-- Profil & session -->
  <div class="col-lg-4">
    <div class="card-soft" id="profileCard">
      <h2 class="h6 mb-3">Profil</h2>

      <!-- Vue par défaut -->
      <div data-profile-view>
        <div class="d-flex align-items-center gap-3 mb-3">
          <div style="width:48px;height:48px;background:var(--asinco-surface-2);display:inline-flex;align-items:center;justify-content:center;border-radius:10px;">
            <i data-lucide="user-round"></i>
          </div>
          <div>
            <div class="fw-medium" data-profile-name-display>Administrateur ASINCO</div>
            <div class="text-muted small" data-profile-email-display>admin@asinco.bj</div>
          </div>
        </div>
        <button type="button" class="btn btn-outline-light btn-sm w-100" data-profile-edit>
          <i data-lucide="pencil" class="icon-sm me-1"></i>Modifier le profil
        </button>
      </div>

      <!-- Vue édition -->
      <form data-profile-form class="d-none">
        <div class="mb-3">
          <label class="form-label" for="profileName">Nom complet</label>
          <input type="text" class="form-control" id="profileName" name="name" required>
        </div>
        <div class="mb-3">
          <label class="form-label" for="profileEmail">Email</label>
          <input type="email" class="form-control" id="profileEmail" name="email" required>
        </div>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-outline-light btn-sm flex-grow-1" data-profile-cancel>Annuler</button>
          <button type="submit" class="btn btn-primary btn-sm flex-grow-1">Enregistrer</button>
        </div>
      </form>
    </div>

    <div class="card-soft mt-4">
      <h2 class="h6 mb-1">Session</h2>
      <p class="text-muted small mb-3">Connecté depuis ce navigateur.</p>
      <a href="<?= e(asinco_url('login.php')) ?>" class="btn btn-outline-danger btn-sm w-100 d-inline-flex align-items-center justify-content-center gap-2">
        <i data-lucide="log-out" class="icon-sm"></i> Se déconnecter
      </a>
    </div>
  </div>
</div>

<script>
  // Affichage en direct du thème actif
  (function () {
    const status = document.getElementById('themeStatus');
    if (!status) return;
    const labels = { light: 'Clair', dark: 'Sombre', auto: 'Système' };
    const update = () => { status.textContent = labels[document.documentElement.dataset.themePref] || '—'; };
    update();
    document.querySelectorAll('[data-theme-set]').forEach(b => b.addEventListener('click', () => setTimeout(update, 0)));
  })();

  // Toggle densité (purement local — démo)
  document.querySelectorAll('[data-density-set]').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('[data-density-set]').forEach(b => b.classList.remove('is-active'));
      btn.classList.add('is-active');
      document.body.dataset.density = btn.dataset.densitySet;
    });
  });
</script>

<?php include __DIR__ . '/partials/app-footer.php'; ?>
