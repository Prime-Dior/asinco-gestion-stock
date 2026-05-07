<?php
$pageTitle = 'Catégories';
include __DIR__ . '/../partials/app-header.php';
?>

<div class="page-header">
  <div>
    <nav class="breadcrumb">
      <a href="../dashboard.php">Pilotage</a> <span class="mx-1">/</span> <span>Catégories</span>
    </nav>
    <h1>Catégories de matériel</h1>
    <p class="subtitle">Classification utilisée pour le filtrage et les statistiques.</p>
  </div>
  <button type="button" class="btn btn-primary d-inline-flex align-items-center gap-2"
          data-bs-toggle="modal" data-bs-target="#newCategorie">
    <i data-lucide="plus" class="icon-sm"></i><span>Nouvelle catégorie</span>
  </button>
</div>

<div class="row g-3" data-reveal-group data-store-list="categories">
<?php foreach ($CATEGORIES as $c):
  $count = count(array_filter($MATERIELS, fn($m) => $m['id_categorie'] === $c['id']));
?>
  <div class="col-md-4" data-reveal>
    <div class="bento-item h-100" data-categorie-id="<?= (int)$c['id'] ?>">
      <div class="d-flex justify-content-between align-items-start">
        <span class="bento-icon"><i data-lucide="tag"></i></span>
        <div class="dropdown">
          <button class="btn btn-ghost btn-sm" data-bs-toggle="dropdown"><i data-lucide="more-horizontal"></i></button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><button type="button" class="dropdown-item" data-action="rename-categorie"><i data-lucide="pencil" class="icon-sm me-2"></i>Renommer</button></li>
            <li>
              <button type="button" class="dropdown-item text-danger"
                      data-confirm
                      data-confirm-title="Supprimer cette catégorie ?"
                      data-confirm-message="Cette catégorie sera retirée du parc. Les matériels associés ne seront pas supprimés mais perdront leur classement."
                      data-confirm-cta="Supprimer"
                      data-confirm-icon="trash-2"
                      data-confirm-variant="danger"
                      data-confirm-action="delete-categorie">
                <i data-lucide="trash-2" class="icon-sm me-2"></i>Supprimer
              </button>
            </li>
          </ul>
        </div>
      </div>
      <h3 class="cat-libelle" contenteditable="false"><?= e($c['libelle']) ?></h3>
      <p class="text-muted mb-0"><?= e($c['description']) ?></p>
      <div class="divider-soft"></div>
      <div class="d-flex justify-content-between align-items-center">
        <span class="text-muted small"><?= $count ?> matériel<?= $count > 1 ? 's' : '' ?></span>
        <a href="../materiel/liste.php?categorie=<?= (int)$c['id'] ?>" class="btn btn-ghost btn-sm d-inline-flex align-items-center gap-1">
          <span>Voir</span><i data-lucide="arrow-right" class="icon-sm"></i>
        </a>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>

<!-- Modal nouvelle catégorie -->
<div class="modal fade" id="newCategorie" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Nouvelle catégorie</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <form method="post" action="liste.php">
      <div class="modal-body">
        <div class="mb-3">
          <label for="lib" class="form-label">Libellé <span class="required">*</span></label>
          <input type="text" class="form-control" id="lib" name="libelle" required placeholder="ex. Sécurité">
        </div>
        <div class="mb-0">
          <label for="desc" class="form-label">Description</label>
          <textarea class="form-control" id="desc" name="description" rows="3" placeholder="Optionnel"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline-light" data-bs-dismiss="modal" type="button">Annuler</button>
        <button class="btn btn-primary" type="submit">Créer</button>
      </div>
    </form>
  </div></div>
</div>

<?php include __DIR__ . '/../partials/app-footer.php'; ?>
