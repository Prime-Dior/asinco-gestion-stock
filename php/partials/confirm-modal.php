<?php /* Modal de confirmation générique — alimenté par data-confirm-* sur le déclencheur */ ?>
<div class="modal fade" id="globalConfirm" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <div class="d-flex align-items-center gap-3">
          <span class="confirm-icon"><i data-lucide="alert-triangle"></i></span>
          <h5 class="modal-title mb-0" id="globalConfirmTitle">Confirmer l'action</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <p class="text-muted mb-0" id="globalConfirmMessage">Voulez-vous vraiment continuer ?</p>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="globalConfirmCta">Confirmer</button>
      </div>
    </div>
  </div>
</div>
