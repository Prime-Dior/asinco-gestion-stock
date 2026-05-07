<?php
$pageTitle = 'Nouveau technicien';
include __DIR__ . '/../partials/app-header.php';

$specialites = ['Réseau', 'Systèmes', 'Stockage', 'Calcul / GPU', 'Sécurité', 'Polyvalent'];
?>

<div class="page-header">
  <div>
    <nav class="breadcrumb">
      <a href="../dashboard.php">Pilotage</a> <span class="mx-1">/</span>
      <a href="liste.php">Techniciens</a> <span class="mx-1">/</span> <span>Nouveau</span>
    </nav>
    <h1>Nouveau technicien</h1>
    <p class="subtitle">Ajoutez un intervenant à l'annuaire.</p>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-8">
    <div class="card-soft">
      <form method="post" action="liste.php" novalidate data-store-form data-store-resource="techniciens" data-redirect="liste.php">
        <div class="row g-3">
          <div class="col-md-6">
            <label for="nom" class="form-label">Nom <span class="required">*</span></label>
            <input type="text" class="form-control" id="nom" name="nom" required placeholder="ex. KOUASSI">
          </div>
          <div class="col-md-6">
            <label for="prenom" class="form-label">Prénom <span class="required">*</span></label>
            <input type="text" class="form-control" id="prenom" name="prenom" required placeholder="ex. Mathieu">
          </div>
          <div class="col-md-6">
            <label for="specialite" class="form-label">Spécialité <span class="required">*</span></label>
            <select id="specialite" name="specialite" class="form-select" required>
              <option value="">— Choisir —</option>
              <?php foreach ($specialites as $s): ?>
                <option value="<?= e($s) ?>"><?= e($s) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="prenom.nom@asinco.bj">
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4 pt-3" style="border-top: 1px solid var(--asinco-border);">
          <a href="liste.php" class="btn btn-outline-light">Annuler</a>
          <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2">
            <i data-lucide="check" class="icon-sm"></i><span>Créer le technicien</span>
          </button>
        </div>
      </form>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card-soft">
      <div class="d-flex align-items-center gap-2 mb-3">
        <i data-lucide="info" class="text-accent"></i>
        <h2 class="h6 mb-0">Bon à savoir</h2>
      </div>
      <p class="text-muted small mb-0">
        Le technicien sera immédiatement disponible dans le formulaire des interventions.
        La spécialité sert au tri et au filtrage par compétence.
      </p>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../partials/app-footer.php'; ?>
