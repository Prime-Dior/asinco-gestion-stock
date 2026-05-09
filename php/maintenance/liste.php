<?php
$pageTitle = 'Interventions';
include __DIR__ . '/../partials/app-header.php';

$q       = $_GET['q']         ?? '';
$tec_id  = $_GET['technicien']?? '';

$rows = $INTERVENTIONS;
if ($q !== '') {
    $rows = array_filter($rows, function($i) use ($q) {
        $m = asinco_materiel($i['id_materiel']);
        $hay = $i['description'] . ' ' . ($m['reference'] ?? '') . ' ' . ($m['designation'] ?? '');
        return stripos($hay, $q) !== false;
    });
}
if ($tec_id !== '') $rows = array_filter($rows, fn($i) => (string)$i['id_technicien'] === $tec_id);

usort($rows, fn($a, $b) => strcmp($b['date_intervention'], $a['date_intervention']));
?>

<div class="page-header">
  <div>
    <nav class="breadcrumb">
      <a href="../dashboard.php">Pilotage</a> <span class="mx-1">/</span> <span>Interventions</span>
    </nav>
    <h1>Interventions de maintenance</h1>
    <p class="subtitle"><?= count($rows) ?> intervention<?= count($rows) > 1 ? 's' : '' ?> · sur <?= count($INTERVENTIONS) ?> au total</p>
  </div>
  <a href="formulaire.php" class="btn btn-primary d-inline-flex align-items-center gap-2">
    <i data-lucide="plus" class="icon-sm"></i><span>Nouvelle intervention</span>
  </a>
</div>

<form method="get" class="filters-bar">
  <div class="row g-2 align-items-end">
    <div class="col-md-6">
      <label class="form-label" for="q">Rechercher</label>
      <div class="input-group">
        <span class="input-group-text"><i data-lucide="search" class="icon-sm"></i></span>
        <input type="search" id="q" name="q" class="form-control" placeholder="Matériel, description…" value="<?= e($q) ?>">
      </div>
    </div>
    <div class="col-md-4">
      <label class="form-label" for="technicien">Technicien</label>
      <select id="technicien" name="technicien" class="form-select">
        <option value="">Tous</option>
        <?php foreach ($TECHNICIENS as $t): ?>
          <option value="<?= $t['id'] ?>" <?= (string)$t['id'] === $tec_id ? 'selected' : '' ?>>
            <?= e($t['prenom'] . ' ' . $t['nom']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-2 d-flex gap-2">
      <button type="submit" class="btn btn-primary w-100">Filtrer</button>
      <a href="liste.php" class="btn btn-ghost"><i data-lucide="x" class="icon-sm"></i></a>
    </div>
  </div>
</form>

<div class="table-card">
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead>
        <tr>
          <th>Date</th>
          <th>Matériel</th>
          <th>Technicien</th>
          <th>Description</th>
          <th class="text-end">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php if (!$rows): ?>
        <tr><td colspan="5" class="text-center text-muted py-5">
          <i data-lucide="inbox" class="icon-lg d-block mx-auto mb-2"></i>
          Aucune intervention ne correspond aux filtres.
        </td></tr>
      <?php else: foreach ($rows as $i):
        $mat = asinco_materiel($i['id_materiel']);
        $tec = asinco_technicien($i['id_technicien']);
      ?>
        <tr>
          <td class="text-muted small"><?= e(date('d/m/Y', strtotime($i['date_intervention']))) ?></td>
          <td>
            <a href="../materiel/fiche.php?id=<?= (int)$mat['id'] ?>" class="text-reset">
              <code class="small d-block text-muted"><?= e($mat['reference']) ?></code>
              <span class="fw-medium"><?= e($mat['designation']) ?></span>
            </a>
          </td>
          <td><?= e($tec['prenom'] . ' ' . $tec['nom']) ?> <span class="text-muted small d-block"><?= e($tec['specialite']) ?></span></td>
          <td class="text-muted"><?= e($i['description']) ?></td>
          <td class="text-end">
            <a href="../materiel/fiche.php?id=<?= (int)$mat['id'] ?>" class="btn btn-outline-light btn-sm" title="Voir le matériel">
              <i data-lucide="external-link" class="icon-sm"></i>
            </a>
          </td>
        </tr>
      <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/../partials/app-footer.php'; ?>
