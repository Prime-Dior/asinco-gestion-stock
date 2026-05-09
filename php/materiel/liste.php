<?php
$pageTitle = 'Matériels';
include __DIR__ . '/../partials/app-header.php';

$q       = $_GET['q']         ?? '';
$cat     = $_GET['categorie'] ?? '';
$etat    = $_GET['etat']      ?? '';

// Tolère les slugs venant des KPI du dashboard (service / reparation / declasse)
$slug2etat = [
  'service'    => 'En service',
  'reparation' => 'En réparation',
  'declasse'   => 'Déclassé',
];
if ($etat !== '' && isset($slug2etat[$etat])) {
    $etat = $slug2etat[$etat];
}

$rows = $MATERIELS;
if ($q !== '')    $rows = array_filter($rows, fn($m) => stripos($m['reference'].' '.$m['designation'], $q) !== false);
if ($cat !== '')  $rows = array_filter($rows, fn($m) => (string)$m['id_categorie'] === $cat);
if ($etat !== '') $rows = array_filter($rows, fn($m) => $m['etat'] === $etat);
?>

<div class="page-header">
  <div>
    <nav class="breadcrumb">
      <a href="../dashboard.php">Pilotage</a> <span class="mx-1">/</span> <span>Matériels</span>
    </nav>
    <h1>Parc matériel</h1>
    <p class="subtitle"><?= count($rows) ?> matériel<?= count($rows) > 1 ? 's' : '' ?> · sur <?= count($MATERIELS) ?> au total</p>
  </div>
  <a href="ajout.php" class="btn btn-primary d-inline-flex align-items-center gap-2">
    <i data-lucide="plus" class="icon-sm"></i><span>Ajouter un matériel</span>
  </a>
</div>

<form method="get" class="filters-bar">
  <div class="row g-2 align-items-end">
    <div class="col-md-5">
      <label class="form-label" for="q">Rechercher</label>
      <div class="input-group">
        <span class="input-group-text"><i data-lucide="search" class="icon-sm"></i></span>
        <input type="search" id="q" name="q" class="form-control" placeholder="Référence, désignation…" value="<?= e($q) ?>">
      </div>
    </div>
    <div class="col-md-3">
      <label class="form-label" for="categorie">Catégorie</label>
      <select id="categorie" name="categorie" class="form-select">
        <option value="">Toutes</option>
        <?php foreach ($CATEGORIES as $c): ?>
          <option value="<?= $c['id'] ?>" <?= (string)$c['id'] === $cat ? 'selected' : '' ?>><?= e($c['libelle']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-2">
      <label class="form-label" for="etat">État</label>
      <select id="etat" name="etat" class="form-select">
        <option value="">Tous</option>
        <?php foreach ($ETATS as $e): ?>
          <option value="<?= e($e) ?>" <?= $e === $etat ? 'selected' : '' ?>><?= e($e) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-2 d-flex gap-2">
      <button type="submit" class="btn btn-primary w-100">Filtrer</button>
      <a href="liste.php" class="btn btn-ghost" title="Réinitialiser"><i data-lucide="x" class="icon-sm"></i></a>
    </div>
  </div>
</form>

<div class="table-card">
  <div class="table-responsive">
    <table class="table table-hover align-middle" data-store-list="materiels"
           data-categories='<?= e(json_encode(array_combine(array_column($CATEGORIES, "id"), array_column($CATEGORIES, "libelle")), JSON_UNESCAPED_UNICODE)) ?>'>
      <thead>
        <tr>
          <th>Référence</th>
          <th>Désignation</th>
          <th>Catégorie</th>
          <th>Date d'achat</th>
          <th>État</th>
          <th>Interventions</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php if (!$rows): ?>
        <tr><td colspan="7" class="text-center text-muted py-5">
          <i data-lucide="inbox" class="icon-lg d-block mx-auto mb-2"></i>
          Aucun matériel ne correspond aux filtres.
        </td></tr>
      <?php else: foreach ($rows as $m):
        $c = asinco_categorie($m['id_categorie']);
        $nb = asinco_nb_interventions($m['id']);
      ?>
        <tr data-row-id="<?= (int)$m['id'] ?>">
          <td><code class="text-muted"><?= e($m['reference']) ?></code></td>
          <td class="fw-medium"><?= e($m['designation']) ?></td>
          <td><?= e($c['libelle'] ?? '—') ?></td>
          <td class="text-muted"><?= e(date('d/m/Y', strtotime($m['date_achat']))) ?></td>
          <td><span class="badge-state <?= asinco_state_class($m['etat']) ?>"><?= e($m['etat']) ?></span></td>
          <td><span class="text-muted"><?= $nb ?></span></td>
          <td class="text-end">
            <div class="btn-group btn-group-sm">
              <a href="fiche.php?id=<?= (int)$m['id'] ?>" class="btn btn-outline-light" title="Voir">
                <i data-lucide="eye" class="icon-sm"></i>
              </a>
              <a href="modification.php?id=<?= (int)$m['id'] ?>" class="btn btn-outline-light" title="Modifier">
                <i data-lucide="pencil" class="icon-sm"></i>
              </a>
              <button type="button" class="btn btn-outline-light text-danger" title="Supprimer"
                      data-confirm
                      data-confirm-title="Supprimer ce matériel ?"
                      data-confirm-message="Cette action est irréversible. Les interventions associées resteront archivées mais le matériel ne sera plus visible dans le parc."
                      data-confirm-cta="Supprimer"
                      data-confirm-icon="trash-2"
                      data-confirm-variant="danger"
                      data-confirm-action="delete-row"
                      data-target-resource="materiels"
                      data-target-id="<?= (int)$m['id'] ?>"
                      data-target-label="<?= e($m['reference']) ?>">
                <i data-lucide="trash-2" class="icon-sm"></i>
              </button>
            </div>
          </td>
        </tr>
      <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/../partials/app-footer.php'; ?>
