<?php
/** Topbar de l'application (post-login) */
$current = basename($_SERVER['SCRIPT_NAME'] ?? '');
?>
<header class="app-topbar d-flex align-items-center px-3 px-lg-4">
  <button class="btn btn-ghost btn-sm d-lg-none me-2" id="sidebarToggle" type="button" aria-label="Menu">
    <i data-lucide="menu"></i>
  </button>

  <a href="<?= e(asinco_url('dashboard.php')) ?>" class="brand d-flex align-items-center gap-2">
    <img src="<?= e(asinco_url('assets/img/logo.png')) ?>" alt="ASINCO" class="brand-logo">
    <span>ASINCO</span>
  </a>

  <div class="ms-auto d-flex align-items-center gap-2">
    <a href="<?= e(asinco_url('materiel/ajout.php')) ?>" class="btn btn-primary btn-sm d-none d-md-inline-flex align-items-center gap-2">
      <i data-lucide="plus" class="icon-sm"></i>
      <span>Nouveau matériel</span>
    </a>

    <?php include __DIR__ . '/theme-toggle.php'; ?>

    <div class="dropdown">
      <button class="btn btn-ghost btn-sm position-relative" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifications">
        <i data-lucide="bell"></i>
        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success rounded-circle" style="width:8px;height:8px;"></span>
      </button>
      <div class="dropdown-menu dropdown-menu-end notif-menu p-0">
        <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom" style="border-color: var(--asinco-border) !important;">
          <strong class="small">Notifications</strong>
          <button type="button" class="btn btn-ghost btn-sm small" data-action="mark-all-read">Tout marquer lu</button>
        </div>
        <ul class="list-unstyled m-0 notif-list" style="max-height:340px;overflow:auto;">
          <li class="notif-item p-3 border-bottom" style="border-color: var(--asinco-border) !important;">
            <div class="d-flex gap-2">
              <i data-lucide="alert-triangle" class="text-warning icon-sm flex-shrink-0 mt-1"></i>
              <div>
                <div class="small fw-medium">SRV-HPE-DL380 en réparation</div>
                <div class="text-muted small">Il y a 2 h · Léonie AHOUANSOU</div>
              </div>
            </div>
          </li>
          <li class="notif-item p-3 border-bottom" style="border-color: var(--asinco-border) !important;">
            <div class="d-flex gap-2">
              <i data-lucide="wrench" class="text-accent icon-sm flex-shrink-0 mt-1"></i>
              <div>
                <div class="small fw-medium">Nouvelle intervention enregistrée</div>
                <div class="text-muted small">Hier · Switch Cisco Catalyst 2960</div>
              </div>
            </div>
          </li>
          <li class="notif-item p-3">
            <div class="d-flex gap-2">
              <i data-lucide="package-plus" class="text-accent icon-sm flex-shrink-0 mt-1"></i>
              <div>
                <div class="small fw-medium">12e matériel ajouté au parc</div>
                <div class="text-muted small">Cette semaine</div>
              </div>
            </div>
          </li>
        </ul>
        <div class="px-3 py-2 border-top text-center" style="border-color: var(--asinco-border) !important;">
          <a href="<?= e(asinco_url('maintenance/liste.php')) ?>" class="small text-muted">Voir l'historique complet</a>
        </div>
      </div>
    </div>

    <div class="dropdown">
      <button class="btn btn-ghost btn-sm d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
        <i data-lucide="user-round"></i>
        <span class="d-none d-md-inline" data-profile-name>Admin</span>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="<?= e(asinco_url('parametres.php')) ?>"><i data-lucide="settings" class="icon-sm me-2"></i>Paramètres</a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <button type="button" class="dropdown-item text-danger"
                  data-confirm
                  data-confirm-title="Se déconnecter ?"
                  data-confirm-message="Vous serez redirigé vers l'écran de connexion. Les filtres et préférences resteront sauvegardés."
                  data-confirm-cta="Se déconnecter"
                  data-confirm-icon="log-out"
                  data-confirm-href="<?= e(asinco_url('login.php')) ?>">
            <i data-lucide="log-out" class="icon-sm me-2"></i>Déconnexion
          </button>
        </li>
      </ul>
    </div>
  </div>
</header>
