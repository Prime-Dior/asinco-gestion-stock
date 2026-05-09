<?php
$pageTitle = 'Ajouter un matériel';
include __DIR__ . '/../partials/app-header.php';
?>

<div class="page-header">
  <div>
    <nav class="breadcrumb">
      <a href="../dashboard.php">Pilotage</a> <span class="mx-1">/</span>
      <a href="liste.php">Matériels</a> <span class="mx-1">/</span> <span>Nouveau</span>
    </nav>
    <h1>Ajouter un matériel</h1>
    <p class="subtitle">Référencez un nouvel équipement dans le parc.</p>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-8">
    <div class="card-soft">
      <form method="post" action="liste.php" novalidate data-store-form data-store-resource="materiels" data-redirect="liste.php">
        <div class="row g-3">
          <div class="col-md-6">
            <label for="reference" class="form-label">Référence <span class="required">*</span></label>
            <input type="text" class="form-control" id="reference" name="reference"
                   placeholder="ex. SW-CSC-2960-01" required pattern="[A-Z0-9\-]{3,30}">
            <div class="form-text">Identifiant unique. Lettres majuscules, chiffres, tirets.</div>
          </div>
          <div class="col-md-6">
            <label for="designation" class="form-label">Désignation <span class="required">*</span></label>
            <input type="text" class="form-control" id="designation" name="designation"
                   placeholder="ex. Switch Cisco Catalyst 2960" required>
          </div>
          <div class="col-md-6">
            <label for="date_achat" class="form-label">Date d'achat <span class="required">*</span></label>
            <input type="date" class="form-control" id="date_achat" name="date_achat" required max="<?= date('Y-m-d') ?>">
          </div>
          <div class="col-md-6">
            <label for="categorie" class="form-label">Catégorie <span class="required">*</span></label>
            <select class="form-select" id="categorie" name="categorie" required>
              <option value="">— Choisir —</option>
              <?php foreach ($CATEGORIES as $c): ?>
                <option value="<?= $c['id'] ?>"><?= e($c['libelle']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-12">
            <label for="etat" class="form-label">État initial</label>
            <select class="form-select" id="etat" name="etat">
              <?php foreach ($ETATS as $e): ?>
                <option value="<?= e($e) ?>" <?= $e === 'En service' ? 'selected' : '' ?>><?= e($e) ?></option>
              <?php endforeach; ?>
            </select>
            <div class="form-text">Par défaut, un matériel est créé <em>En service</em>.</div>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4 pt-3" style="border-top: 1px solid var(--asinco-border);">
          <a href="liste.php" class="btn btn-outline-light">Annuler</a>
          <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2">
            <i data-lucide="check" class="icon-sm"></i><span>Enregistrer le matériel</span>
          </button>
        </div>
      </form>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card-soft">
      <div class="d-flex align-items-center gap-2 mb-3">
        <i data-lucide="info" class="text-accent"></i>
        <h2 class="h6 mb-0">Bonnes pratiques</h2>
      </div>
      <ul class="text-muted small ps-3 mb-0">
        <li class="mb-2">La référence doit être <strong>unique</strong> dans tout le parc.</li>
        <li class="mb-2">La date d'achat sert au calcul d'amortissement et à la garantie.</li>
        <li class="mb-2">Choisir la bonne catégorie facilite le filtrage et les statistiques.</li>
        <li>L'état pourra être modifié à tout moment depuis la fiche matériel.</li>
      </ul>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../partials/app-footer.php'; ?>
