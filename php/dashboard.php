<?php
$pageTitle = 'Tableau de bord';
include __DIR__ . '/partials/app-header.php';

$kpis = asinco_kpis();

// Dernières interventions (5 plus récentes)
usort($INTERVENTIONS, fn($a, $b) => strcmp($b['date_intervention'], $a['date_intervention']));
$dernieres = array_slice($INTERVENTIONS, 0, 5);
?>

<div class="page-header">
  <div>
    <span class="eyebrow mb-2"><i data-lucide="layout-dashboard" class="icon-sm text-accent"></i>Pilotage</span>
    <h1>Tableau de bord</h1>
    <p class="subtitle">Vue d'ensemble du parc matériel et des interventions récentes.</p>
  </div>
  <div class="d-flex gap-2">
    <a href="materiel/ajout.php" class="btn btn-outline-light d-inline-flex align-items-center gap-2">
      <i data-lucide="plus" class="icon-sm"></i><span>Matériel</span>
    </a>
    <a href="maintenance/formulaire.php" class="btn btn-primary d-inline-flex align-items-center gap-2">
      <i data-lucide="wrench" class="icon-sm"></i><span>Nouvelle intervention</span>
    </a>
  </div>
</div>

<!-- KPIs en bento (cliquables — filtrent la liste matériels) -->
<div class="bento-grid mb-4" data-reveal-group>
  <a href="materiel/liste.php" class="bento-item bento-span-4 kpi-card kpi-link" data-reveal>
    <div class="d-flex justify-content-between align-items-start mb-3">
      <span class="kpi-label">Total matériels</span>
      <span class="kpi-icon"><i data-lucide="server"></i></span>
    </div>
    <div class="kpi-value"><?= $kpis['total'] ?></div>
    <div class="kpi-trend"><?= count($CATEGORIES) ?> catégories actives</div>
  </a>
  <a href="materiel/liste.php?etat=service" class="bento-item bento-span-4 kpi-card kpi-link" data-reveal>
    <div class="d-flex justify-content-between align-items-start mb-3">
      <span class="kpi-label">En service</span>
      <span class="kpi-icon"><i data-lucide="circle-check"></i></span>
    </div>
    <div class="kpi-value"><?= $kpis['service'] ?></div>
    <div class="kpi-trend up">
      <?= round($kpis['service'] * 100 / max($kpis['total'], 1)) ?>% du parc opérationnel
    </div>
  </a>
  <a href="materiel/liste.php?etat=reparation" class="bento-item bento-span-4 kpi-card kpi-link" data-reveal>
    <div class="d-flex justify-content-between align-items-start mb-3">
      <span class="kpi-label">En réparation</span>
      <span class="kpi-icon"><i data-lucide="alert-triangle"></i></span>
    </div>
    <div class="kpi-value"><?= $kpis['reparation'] ?></div>
    <div class="kpi-trend">Suivi en cours</div>
  </a>
  <a href="materiel/liste.php?etat=declasse" class="bento-item bento-span-4 kpi-card kpi-link" data-reveal>
    <div class="d-flex justify-content-between align-items-start mb-3">
      <span class="kpi-label">Déclassés</span>
      <span class="kpi-icon"><i data-lucide="archive"></i></span>
    </div>
    <div class="kpi-value"><?= $kpis['declasse'] ?></div>
    <div class="kpi-trend">Hors service permanent</div>
  </a>
  <a href="maintenance/liste.php" class="bento-item bento-span-4 kpi-card kpi-link" data-reveal>
    <div class="d-flex justify-content-between align-items-start mb-3">
      <span class="kpi-label">Interventions enregistrées</span>
      <span class="kpi-icon"><i data-lucide="wrench"></i></span>
    </div>
    <div class="kpi-value"><?= $kpis['interventions'] ?></div>
    <div class="kpi-trend">Historique cumulé</div>
  </a>
  <a href="technicien/liste.php" class="bento-item bento-span-4 kpi-card kpi-link" data-reveal>
    <div class="d-flex justify-content-between align-items-start mb-3">
      <span class="kpi-label">Techniciens actifs</span>
      <span class="kpi-icon"><i data-lucide="hard-hat"></i></span>
    </div>
    <div class="kpi-value"><?= count($TECHNICIENS) ?></div>
    <div class="kpi-trend">Toutes spécialités confondues</div>
  </a>
</div>

<!-- Dernières interventions + répartition catégories -->
<div class="row g-3">
  <div class="col-lg-8">
    <div class="table-card">
      <div class="d-flex justify-content-between align-items-center p-3 border-bottom" style="border-color: var(--asinco-border) !important;">
        <div>
          <h2 class="h6 mb-0">Dernières interventions</h2>
          <p class="text-muted small mb-0">5 dernières opérations enregistrées</p>
        </div>
        <a href="maintenance/liste.php" class="btn btn-ghost btn-sm d-inline-flex align-items-center gap-1">
          <span>Voir tout</span><i data-lucide="arrow-right" class="icon-sm"></i>
        </a>
      </div>
      <div class="px-3 py-2 border-bottom" style="border-color: var(--asinco-border) !important;">
        <input type="search" class="form-control form-control-sm" placeholder="Filtrer dans les interventions…"
               data-filter-table="#tblDernieres" aria-label="Filtre">
      </div>
      <div class="table-responsive">
        <table id="tblDernieres" class="table table-hover align-middle" data-sortable>
          <thead>
            <tr>
              <th data-sort>Date</th>
              <th data-sort>Matériel</th>
              <th data-sort>Technicien</th>
              <th data-sort>Description</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($dernieres as $i):
            $mat = asinco_materiel($i['id_materiel']);
            $tec = asinco_technicien($i['id_technicien']);
          ?>
            <tr>
              <td class="text-muted small"><?= e(date('d/m/Y', strtotime($i['date_intervention']))) ?></td>
              <td>
                <a href="materiel/fiche.php?id=<?= (int)$mat['id'] ?>" class="text-reset">
                  <code class="small d-block text-muted"><?= e($mat['reference']) ?></code>
                  <?= e($mat['designation']) ?>
                </a>
              </td>
              <td><?= e($tec['prenom'] . ' ' . $tec['nom']) ?></td>
              <td class="text-muted"><?= e($i['description']) ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card-soft h-100">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h6 mb-0">Répartition par catégorie</h2>
        <a href="categorie/liste.php" class="btn btn-ghost btn-sm">
          <i data-lucide="settings-2" class="icon-sm"></i>
        </a>
      </div>
      <ul class="list-unstyled m-0">
      <?php foreach ($CATEGORIES as $cat):
        $count = 0;
        foreach ($MATERIELS as $m) if ($m['id_categorie'] === $cat['id']) $count++;
        $pct = $kpis['total'] ? round($count * 100 / $kpis['total']) : 0;
      ?>
        <li class="mb-3">
          <div class="d-flex justify-content-between align-items-center mb-1">
            <span class="fw-medium"><?= e($cat['libelle']) ?></span>
            <span class="text-muted small"><?= $count ?> · <?= $pct ?>%</span>
          </div>
          <div class="progress" style="height: 6px; background: var(--asinco-surface-2);">
            <div class="progress-bar" role="progressbar"
                 style="width: <?= $pct ?>%; background: var(--asinco-accent);"
                 aria-valuenow="<?= $pct ?>" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </li>
      <?php endforeach; ?>
      </ul>

      <div class="divider-soft"></div>

      <h2 class="h6 mb-3">Actions rapides</h2>
      <div class="d-flex flex-column gap-2">
        <a href="materiel/ajout.php" class="btn btn-outline-light btn-sm d-inline-flex align-items-center gap-2 justify-content-start">
          <i data-lucide="package-plus" class="icon-sm"></i>Ajouter un matériel
        </a>
        <a href="maintenance/formulaire.php" class="btn btn-outline-light btn-sm d-inline-flex align-items-center gap-2 justify-content-start">
          <i data-lucide="clipboard-list" class="icon-sm"></i>Enregistrer une intervention
        </a>
        <a href="technicien/ajout.php" class="btn btn-outline-light btn-sm d-inline-flex align-items-center gap-2 justify-content-start">
          <i data-lucide="user-plus" class="icon-sm"></i>Nouveau technicien
        </a>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/partials/app-footer.php'; ?>
