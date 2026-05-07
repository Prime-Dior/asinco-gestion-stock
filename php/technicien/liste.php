<?php
$pageTitle = 'Techniciens';
include __DIR__ . '/../partials/app-header.php';

// Charge par technicien
function asinco_charge_technicien(int $id, array $interventions): int {
    $n = 0; foreach ($interventions as $i) if ($i['id_technicien'] === $id) $n++; return $n;
}
?>

<div class="page-header">
  <div>
    <nav class="breadcrumb">
      <a href="../dashboard.php">Pilotage</a> <span class="mx-1">/</span> <span>Techniciens</span>
    </nav>
    <h1>Techniciens</h1>
    <p class="subtitle"><?= count($TECHNICIENS) ?> intervenants enregistrés.</p>
  </div>
  <a href="ajout.php" class="btn btn-primary d-inline-flex align-items-center gap-2">
    <i data-lucide="user-plus" class="icon-sm"></i><span>Nouveau technicien</span>
  </a>
</div>

<div class="table-card">
  <div class="table-responsive">
    <table class="table table-hover align-middle" data-store-list="techniciens">
      <thead>
        <tr>
          <th>Identité</th>
          <th>Spécialité</th>
          <th>Charge (interventions)</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($TECHNICIENS as $t):
        $charge = asinco_charge_technicien($t['id'], $INTERVENTIONS);
        $initials = strtoupper(substr($t['prenom'], 0, 1) . substr($t['nom'], 0, 1));
      ?>
        <tr data-row-id="<?= (int)$t['id'] ?>">
          <td>
            <div class="d-flex align-items-center gap-2">
              <div class="d-inline-flex align-items-center justify-content-center"
                   style="width:36px;height:36px;border:1px solid var(--asinco-border);border-radius:8px;font-weight:700;font-size:0.825rem;color:var(--asinco-text);background:var(--asinco-surface-2);">
                <?= e($initials) ?>
              </div>
              <div>
                <div class="fw-medium"><?= e($t['prenom'] . ' ' . $t['nom']) ?></div>
                <div class="text-muted small">ID #<?= (int)$t['id'] ?></div>
              </div>
            </div>
          </td>
          <td><span class="badge-state"><?= e($t['specialite']) ?></span></td>
          <td>
            <div class="d-flex align-items-center gap-2" style="max-width:220px;">
              <div class="progress flex-grow-1" style="height: 6px; background: var(--asinco-surface-2);">
                <div class="progress-bar" role="progressbar"
                     style="width: <?= min(100, $charge * 25) ?>%; background: var(--asinco-accent);"
                     aria-valuenow="<?= $charge ?>" aria-valuemin="0" aria-valuemax="4"></div>
              </div>
              <span class="text-muted small"><?= $charge ?></span>
            </div>
          </td>
          <td class="text-end">
            <div class="btn-group btn-group-sm">
              <a href="modification.php?id=<?= (int)$t['id'] ?>" class="btn btn-outline-light" title="Modifier">
                <i data-lucide="pencil" class="icon-sm"></i>
              </a>
              <button type="button" class="btn btn-outline-light text-danger" title="Supprimer"
                      data-confirm
                      data-confirm-title="Supprimer ce technicien ?"
                      data-confirm-message="Les interventions associées resteront archivées mais le technicien ne pourra plus être assigné."
                      data-confirm-cta="Supprimer"
                      data-confirm-icon="trash-2"
                      data-confirm-variant="danger"
                      data-confirm-action="delete-row"
                      data-target-resource="techniciens"
                      data-target-id="<?= (int)$t['id'] ?>"
                      data-target-label="<?= e($t['prenom'] . ' ' . $t['nom']) ?>">
                <i data-lucide="trash-2" class="icon-sm"></i>
              </button>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/../partials/app-footer.php'; ?>
