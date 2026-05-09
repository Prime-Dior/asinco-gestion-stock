<?php
$pageTitle = 'Fiche matériel';
include __DIR__ . '/../partials/app-header.php';

$id = (int)($_GET['id'] ?? 0);
$m  = asinco_materiel($id) ?? $MATERIELS[0];
$cat = asinco_categorie($m['id_categorie']);
$interventions = asinco_interventions_par_materiel($m['id']);
usort($interventions, fn($a, $b) => strcmp($b['date_intervention'], $a['date_intervention']));
?>

<div class="page-header">
  <div>
    <nav class="breadcrumb">
      <a href="../dashboard.php">Pilotage</a> <span class="mx-1">/</span>
      <a href="liste.php">Matériels</a> <span class="mx-1">/</span> <span><?= e($m['reference']) ?></span>
    </nav>
    <h1 class="d-flex align-items-center gap-3">
      <span><?= e($m['designation']) ?></span>
      <span class="badge-state <?= asinco_state_class($m['etat']) ?>"><?= e($m['etat']) ?></span>
    </h1>
    <p class="subtitle"><code class="text-muted"><?= e($m['reference']) ?></code> · <?= e($cat['libelle'] ?? '—') ?></p>
  </div>
  <div class="d-flex gap-2">
    <a href="../maintenance/formulaire.php?materiel=<?= (int)$m['id'] ?>" class="btn btn-outline-light d-inline-flex align-items-center gap-2">
      <i data-lucide="wrench" class="icon-sm"></i><span>Nouvelle intervention</span>
    </a>
    <a href="modification.php?id=<?= (int)$m['id'] ?>" class="btn btn-primary d-inline-flex align-items-center gap-2">
      <i data-lucide="pencil" class="icon-sm"></i><span>Modifier</span>
    </a>
  </div>
</div>

<div class="row g-3">
  <!-- Infos -->
  <div class="col-lg-4">
    <div class="card-soft">
      <h2 class="h6 mb-3">Informations</h2>
      <dl class="row mb-0 small">
        <dt class="col-5 text-muted">Référence</dt>
        <dd class="col-7"><code><?= e($m['reference']) ?></code></dd>

        <dt class="col-5 text-muted">Désignation</dt>
        <dd class="col-7"><?= e($m['designation']) ?></dd>

        <dt class="col-5 text-muted">Catégorie</dt>
        <dd class="col-7"><?= e($cat['libelle'] ?? '—') ?></dd>

        <dt class="col-5 text-muted">Date d'achat</dt>
        <dd class="col-7"><?= e(date('d/m/Y', strtotime($m['date_achat']))) ?></dd>

        <dt class="col-5 text-muted">Âge</dt>
        <dd class="col-7"><?= floor((time() - strtotime($m['date_achat'])) / 86400 / 365) ?> ans</dd>

        <dt class="col-5 text-muted">État</dt>
        <dd class="col-7"><span class="badge-state <?= asinco_state_class($m['etat']) ?>"><?= e($m['etat']) ?></span></dd>
      </dl>
    </div>

    <div class="card-soft mt-3">
      <h2 class="h6 mb-3">Statistiques</h2>
      <div class="row g-2">
        <div class="col-6">
          <div class="text-muted small">Interventions</div>
          <div class="fs-4 fw-bold"><?= count($interventions) ?></div>
        </div>
        <div class="col-6">
          <div class="text-muted small">Dernière</div>
          <div class="fs-6 fw-medium">
            <?= $interventions ? e(date('d/m/Y', strtotime($interventions[0]['date_intervention']))) : '—' ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Historique interventions -->
  <div class="col-lg-8">
    <div class="card-soft">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h6 mb-0">Historique des interventions</h2>
        <span class="text-muted small"><?= count($interventions) ?> au total</span>
      </div>

      <?php if (!$interventions): ?>
        <div class="text-center text-muted py-5">
          <i data-lucide="inbox" class="icon-lg d-block mx-auto mb-2"></i>
          Aucune intervention enregistrée pour ce matériel.
        </div>
      <?php else: ?>
        <ul class="list-unstyled m-0">
        <?php foreach ($interventions as $i):
          $tec = asinco_technicien($i['id_technicien']);
        ?>
          <li class="py-3 d-flex gap-3 align-items-start" style="border-bottom: 1px solid var(--asinco-border);">
            <div class="flex-shrink-0" style="width: 40px; height: 40px; border: 1px solid var(--asinco-border); border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; color: var(--asinco-accent);">
              <i data-lucide="wrench" class="icon-sm"></i>
            </div>
            <div class="flex-grow-1">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fw-medium"><?= e($i['description']) ?></span>
                <span class="text-muted small"><?= e(date('d/m/Y', strtotime($i['date_intervention']))) ?></span>
              </div>
              <div class="text-muted small d-flex align-items-center gap-2">
                <i data-lucide="user-round" class="icon-sm"></i>
                <span><?= e($tec['prenom'] . ' ' . $tec['nom']) ?> · <?= e($tec['specialite']) ?></span>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../partials/app-footer.php'; ?>
