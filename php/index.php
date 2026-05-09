<?php
$pageTitle = 'Accueil';
include __DIR__ . '/partials/head.php';
?>

<!-- Topbar publique -->
<header class="app-topbar d-flex align-items-center px-3 px-lg-4">
  <a href="index.php" class="brand d-flex align-items-center gap-2">
    <img src="<?= e(asinco_url('assets/img/logo.png')) ?>" alt="ASINCO" class="brand-logo">
    <span>ASINCO</span>
  </a>
  <nav class="ms-auto d-none d-md-flex align-items-center gap-4">
    <a href="#fonctionnalites" class="text-muted">Fonctionnalités</a>
    <a href="#workflow" class="text-muted">Workflow</a>
    <a href="#stack" class="text-muted">Stack</a>
  </nav>
  <div class="ms-auto ms-md-3 d-flex align-items-center gap-2">
    <a href="login.php" class="btn btn-ghost btn-sm">Connexion</a>
    <a href="login.php" class="btn btn-primary btn-sm d-flex align-items-center gap-2">
      <span>Accéder à l'app</span>
      <i data-lucide="arrow-right" class="icon-sm"></i>
    </a>
  </div>
</header>

<!-- HERO -->
<section class="landing-hero">
  <div class="grid-bg"></div>
  <div class="container position-relative" data-reveal-group data-reveal-immediate>
    <h1 data-reveal>
      Le <span class="hl-accent">parc</span> matériel.<br>
      Centralisé <span class="flip-words" data-words='["Maîtrisé.","Suivi.","Audité.","Optimisé."]'>Maîtrisé.</span>
    </h1>
    <p class="lead" data-reveal>
      ASINCO regroupe l'inventaire du parc, le suivi des maintenances et l'historique
      des interventions techniques. Fini les fichiers Excel — vos équipes travaillent
      sur une source de vérité unique.
    </p>
    <div class="d-flex flex-wrap gap-3" data-reveal>
      <a href="login.php" class="btn btn-primary btn-lg d-inline-flex align-items-center gap-2">
        <span>Se connecter</span>
        <i data-lucide="arrow-right" class="icon-sm"></i>
      </a>
      <a href="#fonctionnalites" class="btn btn-outline-light btn-lg d-inline-flex align-items-center gap-2">
        <i data-lucide="play" class="icon-sm"></i>
        <span>Voir les fonctionnalités</span>
      </a>
    </div>

    <!-- Stats sous le hero -->
    <div class="row g-4 mt-5 pt-4 border-top" style="border-color: var(--asinco-border) !important;" data-reveal-group>
      <div class="col-6 col-md-3" data-reveal>
        <div class="text-muted small">Matériels suivis</div>
        <div class="display-6 fw-bold">12<span class="text-accent">+</span></div>
      </div>
      <div class="col-6 col-md-3" data-reveal>
        <div class="text-muted small">Catégories</div>
        <div class="display-6 fw-bold">3</div>
      </div>
      <div class="col-6 col-md-3" data-reveal>
        <div class="text-muted small">Techniciens</div>
        <div class="display-6 fw-bold">5</div>
      </div>
      <div class="col-6 col-md-3" data-reveal>
        <div class="text-muted small">Interventions enregistrées</div>
        <div class="display-6 fw-bold">10</div>
      </div>
    </div>
  </div>
</section>

<!-- BENTO FEATURES -->
<section id="fonctionnalites" class="py-5 my-5">
  <div class="container">
    <div class="row mb-5">
      <div class="col-lg-7" data-reveal>
        <span class="text-accent fw-medium small">Fonctionnalités</span>
        <h2 class="display-5 mt-2 mb-3">Tout ce qu'il faut pour piloter un parc.</h2>
        <p class="text-muted lead mb-0">
          Des outils sobres, conçus pour la donnée. Aucune fioriture, juste l'information
          au bon endroit.
        </p>
      </div>
    </div>

    <div class="bento-grid" data-reveal-group>
      <div class="bento-item bento-span-6" data-reveal>
        <span class="bento-icon"><i data-lucide="server"></i></span>
        <h3>Inventaire complet du parc</h3>
        <p>Référencez chaque équipement avec sa date d'achat, sa catégorie et son état en temps réel — Réseau, Stockage, Calcul.</p>
      </div>
      <div class="bento-item bento-span-6">
        <span class="bento-icon"><i data-lucide="wrench"></i></span>
        <h3>Suivi des interventions</h3>
        <p>Enregistrez chaque maintenance, associez un technicien, gardez l'historique complet par matériel.</p>
      </div>
      <div class="bento-item bento-span-4" data-reveal>
        <span class="bento-icon"><i data-lucide="activity"></i></span>
        <h3>États en direct</h3>
        <p>En service, En réparation, Déclassé — l'état bascule automatiquement à chaque intervention.</p>
      </div>
      <div class="bento-item bento-span-4" data-reveal>
        <span class="bento-icon"><i data-lucide="hard-hat"></i></span>
        <h3>Gestion des techniciens</h3>
        <p>Annuaire des intervenants, spécialités, charge de travail visible d'un coup d'œil.</p>
      </div>
      <div class="bento-item bento-span-4" data-reveal>
        <span class="bento-icon"><i data-lucide="bar-chart-3"></i></span>
        <h3>Indicateurs métier</h3>
        <p>Nombre d'interventions par matériel, taux d'équipements en panne, vue d'ensemble immédiate.</p>
      </div>
    </div>
  </div>
</section>

<!-- WORKFLOW -->
<section id="workflow" class="py-5 my-5">
  <div class="container">
    <div class="row mb-5">
      <div class="col-lg-7" data-reveal>
        <span class="text-accent fw-medium small">Workflow</span>
        <h2 class="display-5 mt-2 mb-3">Trois gestes, un parc maîtrisé.</h2>
      </div>
    </div>

    <div class="hover-card-grid" data-reveal-group>
      <div class="hover-card" data-reveal>
        <div class="d-flex align-items-center gap-2 mb-3">
          <span class="text-muted small">01</span>
          <i data-lucide="package-plus" class="text-accent"></i>
        </div>
        <h3>Référencer</h3>
        <p>Ajoutez un matériel : référence unique, désignation, date d'achat, catégorie. Validation automatique.</p>
      </div>
      <div class="hover-card" data-reveal>
        <div class="d-flex align-items-center gap-2 mb-3">
          <span class="text-muted small">02</span>
          <i data-lucide="clipboard-list" class="text-accent"></i>
        </div>
        <h3>Intervenir</h3>
        <p>Enregistrez l'intervention. L'état du matériel passe automatiquement à <em>En réparation</em>.</p>
      </div>
      <div class="hover-card" data-reveal>
        <div class="d-flex align-items-center gap-2 mb-3">
          <span class="text-muted small">03</span>
          <i data-lucide="line-chart" class="text-accent"></i>
        </div>
        <h3>Analyser</h3>
        <p>Consultez la fiche matériel, le compteur d'interventions, l'historique complet et l'état du parc.</p>
      </div>
    </div>
  </div>
</section>

<!-- STACK -->
<section id="stack" class="py-5 my-5">
  <div class="container">
    <div class="border-soft p-4 p-lg-5" data-reveal>
      <div class="row align-items-center g-4">
        <div class="col-lg-6">
          <span class="text-accent fw-medium small">Architecture</span>
          <h2 class="h2 mt-2 mb-3">Une stack robuste, taillée pour la durée.</h2>
          <p class="text-muted mb-0">
            Base Oracle pour la fiabilité métier, logique PL/SQL pour les opérations critiques,
            interface PHP/Bootstrap pour la simplicité de déploiement et de maintenance.
          </p>
        </div>
        <div class="col-lg-6">
          <div class="row g-3">
            <div class="col-6"><div class="card-soft text-center">
              <i data-lucide="database" class="icon-lg text-accent mb-2"></i>
              <div class="fw-bold">Oracle SQL</div>
              <div class="small text-muted">PL/SQL · OCI8</div>
            </div></div>
            <div class="col-6"><div class="card-soft text-center">
              <i data-lucide="code-2" class="icon-lg text-accent mb-2"></i>
              <div class="fw-bold">PHP 8</div>
              <div class="small text-muted">Backend serveur</div>
            </div></div>
            <div class="col-6"><div class="card-soft text-center">
              <i data-lucide="layout" class="icon-lg text-accent mb-2"></i>
              <div class="fw-bold">Bootstrap 5</div>
              <div class="small text-muted">UI responsive</div>
            </div></div>
            <div class="col-6"><div class="card-soft text-center">
              <i data-lucide="git-branch" class="icon-lg text-accent mb-2"></i>
              <div class="fw-bold">Git · GitHub</div>
              <div class="small text-muted">Versioning</div>
            </div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA FINAL -->
<section class="py-5 my-5">
  <div class="container text-center" data-reveal>
    <h2 class="display-5 mb-3">Prêt à reprendre le contrôle du parc ?</h2>
    <p class="text-muted lead mb-4">Connectez-vous pour accéder au tableau de bord ASINCO.</p>
    <a href="login.php" class="btn btn-primary btn-lg d-inline-flex align-items-center gap-2">
      <span>Accéder à l'application</span>
      <i data-lucide="arrow-right" class="icon-sm"></i>
    </a>
  </div>
</section>

<?php include __DIR__ . '/partials/public-footer.php'; ?>
