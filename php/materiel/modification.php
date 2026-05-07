<?php
$pageTitle = 'Modifier un matériel';
include __DIR__ . '/../partials/app-header.php';

$id = (int)($_GET['id'] ?? 0);
$m  = asinco_materiel($id) ?? $MATERIELS[0];
?>

<div class="page-header">
  <div>
    <nav class="breadcrumb">
      <a href="../dashboard.php">Pilotage</a> <span class="mx-1">/</span>
      <a href="liste.php">Matériels</a> <span class="mx-1">/</span>
      <a href="fiche.php?id=<?= (int)$m['id'] ?>"><?= e($m['reference']) ?></a> <span class="mx-1">/</span>
      <span>Modification</span>
    </nav>
    <h1>Modifier <span class="text-muted"><?= e($m['reference']) ?></span></h1>
    <p class="subtitle">Mettez à jour les informations de cet équipement.</p>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-8">
    <div class="card-soft">
      <form method="post" action="fiche.php?id=<?= (int)$m['id'] ?>" novalidate>
        <div class="row g-3">
          <div class="col-md-6">
            <label for="reference" class="form-label">Référence <span class="required">*</span></label>
            <input type="text" class="form-control" id="reference" name="reference"
                   value="<?= e($m['reference']) ?>" required>
          </div>
          <div class="col-md-6">
            <label for="designation" class="form-label">Désignation <span class="required">*</span></label>
            <input type="text" class="form-control" id="designation" name="designation"
                   value="<?= e($m['designation']) ?>" required>
          </div>
          <div class="col-md-6">
            <label for="date_achat" class="form-label">Date d'achat <span class="required">*</span></label>
            <input type="date" class="form-control" id="date_achat" name="date_achat"
                   value="<?= e($m['date_achat']) ?>" required>
          </div>
          <div class="col-md-6">
            <label for="categorie" class="form-label">Catégorie <span class="required">*</span></label>
            <select class="form-select" id="categorie" name="categorie" required>
              <?php foreach ($CATEGORIES as $c): ?>
                <option value="<?= $c['id'] ?>" <?= $c['id'] === $m['id_categorie'] ? 'selected' : '' ?>>
                  <?= e($c['libelle']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-12">
            <label for="etat" class="form-label">État</label>
            <select class="form-select" id="etat" name="etat">
              <?php foreach ($ETATS as $et): ?>
                <option value="<?= e($et) ?>" <?= $et === $m['etat'] ? 'selected' : '' ?>><?= e($et) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="d-flex justify-content-between gap-2 mt-4 pt-3" style="border-top: 1px solid var(--asinco-border);">
          <button type="button" class="btn btn-outline-light text-danger d-inline-flex align-items-center gap-2"
                  data-confirm
                  data-confirm-title="Supprimer ce matériel ?"
                  data-confirm-message="Action irréversible. Confirmer la suppression de <strong><?= e($m['reference']) ?></strong> ?"
                  data-confirm-cta="Supprimer"
                  data-confirm-icon="trash-2"
                  data-confirm-variant="danger"
                  data-confirm-href="liste.php">
            <i data-lucide="trash-2" class="icon-sm"></i><span>Supprimer</span>
          </button>
          <div class="d-flex gap-2">
            <a href="fiche.php?id=<?= (int)$m['id'] ?>" class="btn btn-outline-light">Annuler</a>
            <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2">
              <i data-lucide="check" class="icon-sm"></i><span>Enregistrer</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card-soft">
      <h2 class="h6 mb-3">Méta</h2>
      <dl class="row small mb-0">
        <dt class="col-5 text-muted">ID interne</dt>
        <dd class="col-7"><code><?= (int)$m['id'] ?></code></dd>
        <dt class="col-5 text-muted">Interventions</dt>
        <dd class="col-7"><?= asinco_nb_interventions($m['id']) ?></dd>
        <dt class="col-5 text-muted">État courant</dt>
        <dd class="col-7"><span class="badge-state <?= asinco_state_class($m['etat']) ?>"><?= e($m['etat']) ?></span></dd>
      </dl>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../partials/app-footer.php'; ?>
