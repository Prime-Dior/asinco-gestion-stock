<?php
$pageTitle = 'Nouvelle intervention';
include __DIR__ . '/../partials/app-header.php';

$preselect = (int)($_GET['materiel'] ?? 0);
?>

<div class="page-header">
  <div>
    <nav class="breadcrumb">
      <a href="../dashboard.php">Pilotage</a> <span class="mx-1">/</span>
      <a href="liste.php">Interventions</a> <span class="mx-1">/</span> <span>Nouvelle</span>
    </nav>
    <h1>Enregistrer une intervention</h1>
    <p class="subtitle">L'état du matériel passera automatiquement à <em>En réparation</em>.</p>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-8">
    <div class="card-soft">
      <form method="post" action="liste.php" novalidate>
        <div class="row g-3">
          <div class="col-md-6">
            <label for="materiel" class="form-label">Matériel concerné <span class="required">*</span></label>
            <select class="form-select" id="materiel" name="materiel" required>
              <option value="">— Choisir un matériel —</option>
              <?php foreach ($MATERIELS as $m): ?>
                <option value="<?= (int)$m['id'] ?>" <?= $m['id'] === $preselect ? 'selected' : '' ?>>
                  <?= e($m['reference']) ?> — <?= e($m['designation']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label for="technicien" class="form-label">Technicien <span class="required">*</span></label>
            <select class="form-select" id="technicien" name="technicien" required>
              <option value="">— Assigner un technicien —</option>
              <?php foreach ($TECHNICIENS as $t): ?>
                <option value="<?= (int)$t['id'] ?>"><?= e($t['prenom'] . ' ' . $t['nom']) ?> · <?= e($t['specialite']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label for="date_intervention" class="form-label">Date d'intervention <span class="required">*</span></label>
            <input type="date" class="form-control" id="date_intervention" name="date_intervention"
                   value="<?= date('Y-m-d') ?>" required max="<?= date('Y-m-d') ?>">
          </div>
          <div class="col-md-6">
            <label for="duree" class="form-label">Durée estimée (h)</label>
            <input type="number" class="form-control" id="duree" name="duree" min="0.25" step="0.25" placeholder="ex. 1.5">
          </div>
          <div class="col-12">
            <label for="description" class="form-label">Description <span class="required">*</span></label>
            <textarea class="form-control" id="description" name="description" rows="5" required
                      placeholder="Décrivez l'intervention : symptômes, actions effectuées, pièces remplacées…"></textarea>
            <div class="form-text">Soyez précis : cet historique sert au diagnostic des pannes futures.</div>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4 pt-3" style="border-top: 1px solid var(--asinco-border);">
          <a href="liste.php" class="btn btn-outline-light">Annuler</a>
          <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2">
            <i data-lucide="check" class="icon-sm"></i><span>Enregistrer l'intervention</span>
          </button>
        </div>
      </form>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card-soft">
      <div class="d-flex align-items-center gap-2 mb-3">
        <i data-lucide="zap" class="text-accent"></i>
        <h2 class="h6 mb-0">Effets automatiques</h2>
      </div>
      <ul class="text-muted small ps-3 mb-0">
        <li class="mb-2">L'état du matériel bascule en <strong>En réparation</strong> (procédure <code>PRC_AJOUT_INTERVENTION</code>).</li>
        <li class="mb-2">Le compteur d'interventions du matériel est incrémenté.</li>
        <li>L'intervention apparaît dans le tableau de bord et la fiche matériel.</li>
      </ul>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../partials/app-footer.php'; ?>
