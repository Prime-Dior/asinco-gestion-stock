<?php
$pageTitle = 'Modifier un technicien';
include __DIR__ . '/../partials/app-header.php';

$id = (int)($_GET['id'] ?? 0);
$t  = asinco_technicien($id) ?? $TECHNICIENS[1];
$specialites = ['Réseau', 'Systèmes', 'Stockage', 'Calcul / GPU', 'Sécurité', 'Polyvalent'];
?>

<div class="page-header">
  <div>
    <nav class="breadcrumb">
      <a href="../dashboard.php">Pilotage</a> <span class="mx-1">/</span>
      <a href="liste.php">Techniciens</a> <span class="mx-1">/</span>
      <span><?= e($t['prenom'] . ' ' . $t['nom']) ?></span>
    </nav>
    <h1>Modifier le technicien</h1>
    <p class="subtitle">Mettez à jour l'identité ou la spécialité.</p>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-8">
    <div class="card-soft">
      <form method="post" action="liste.php" novalidate>
        <div class="row g-3">
          <div class="col-md-6">
            <label for="nom" class="form-label">Nom <span class="required">*</span></label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?= e($t['nom']) ?>" required>
          </div>
          <div class="col-md-6">
            <label for="prenom" class="form-label">Prénom <span class="required">*</span></label>
            <input type="text" class="form-control" id="prenom" name="prenom" value="<?= e($t['prenom']) ?>" required>
          </div>
          <div class="col-md-6">
            <label for="specialite" class="form-label">Spécialité <span class="required">*</span></label>
            <select id="specialite" name="specialite" class="form-select" required>
              <?php foreach ($specialites as $s): ?>
                <option value="<?= e($s) ?>" <?= $s === $t['specialite'] ? 'selected' : '' ?>><?= e($s) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email"
                   value="<?= e(strtolower($t['prenom'] . '.' . $t['nom']) . '@asinco.bj') ?>">
          </div>
        </div>

        <div class="d-flex justify-content-between gap-2 mt-4 pt-3" style="border-top: 1px solid var(--asinco-border);">
          <a href="liste.php" class="btn btn-outline-light text-danger d-inline-flex align-items-center gap-2">
            <i data-lucide="trash-2" class="icon-sm"></i><span>Supprimer</span>
          </a>
          <div class="d-flex gap-2">
            <a href="liste.php" class="btn btn-outline-light">Annuler</a>
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
      <h2 class="h6 mb-3">Activité</h2>
      <?php
        $charge = 0;
        foreach ($INTERVENTIONS as $i) if ($i['id_technicien'] === $t['id']) $charge++;
      ?>
      <dl class="row small mb-0">
        <dt class="col-6 text-muted">Interventions</dt>
        <dd class="col-6"><?= $charge ?></dd>
        <dt class="col-6 text-muted">Spécialité</dt>
        <dd class="col-6"><?= e($t['specialite']) ?></dd>
      </dl>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../partials/app-footer.php'; ?>
