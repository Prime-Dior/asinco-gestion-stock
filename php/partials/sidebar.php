<?php
/** Sidebar app shell — détecte la page active via le chemin du script */
$script = $_SERVER['SCRIPT_NAME'] ?? '';
function asinco_active(string $needle, string $script): string {
    return str_contains($script, $needle) ? 'active' : '';
}
?>
<aside class="app-sidebar">
  <div class="nav-section">Pilotage</div>
  <a class="nav-link <?= asinco_active('/dashboard.php', $script) ?>" href="<?= e(asinco_url('dashboard.php')) ?>">
    <i data-lucide="layout-dashboard"></i><span>Tableau de bord</span>
  </a>

  <div class="nav-section mt-3">Inventaire</div>
  <a class="nav-link <?= asinco_active('/materiel/', $script) ?>" href="<?= e(asinco_url('materiel/liste.php')) ?>">
    <i data-lucide="server"></i><span>Matériels</span>
  </a>
  <a class="nav-link <?= asinco_active('/categorie/', $script) ?>" href="<?= e(asinco_url('categorie/liste.php')) ?>">
    <i data-lucide="tags"></i><span>Catégories</span>
  </a>

  <div class="nav-section mt-3">Maintenance</div>
  <a class="nav-link <?= asinco_active('/maintenance/', $script) ?>" href="<?= e(asinco_url('maintenance/liste.php')) ?>">
    <i data-lucide="wrench"></i><span>Interventions</span>
  </a>
  <a class="nav-link <?= asinco_active('/technicien/', $script) ?>" href="<?= e(asinco_url('technicien/liste.php')) ?>">
    <i data-lucide="hard-hat"></i><span>Techniciens</span>
  </a>

  <div class="nav-section mt-3">Système</div>
  <a class="nav-link <?= asinco_active('/parametres.php', $script) ?>" href="<?= e(asinco_url('parametres.php')) ?>">
    <i data-lucide="settings-2"></i><span>Paramètres</span>
  </a>
  <button type="button" class="nav-link border-0 bg-transparent w-100 text-start"
          data-confirm
          data-confirm-title="Se déconnecter ?"
          data-confirm-message="Vous serez redirigé vers l'écran de connexion. Les filtres et préférences resteront sauvegardés."
          data-confirm-cta="Se déconnecter"
          data-confirm-icon="log-out"
          data-confirm-href="<?= e(asinco_url('login.php')) ?>">
    <i data-lucide="log-out"></i><span>Déconnexion</span>
  </button>
</aside>
