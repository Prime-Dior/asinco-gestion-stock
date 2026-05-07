# COMPONENTS.md — Catalogue Bootstrap 5 + Patterns ASINCO

> Lire ce fichier AVANT de créer un composant UI.
> Stack : Bootstrap 5.3 (CDN) + PHP partials + CSS custom léger.

---

## Règle d'utilisation absolue

**Avant de créer n'importe quel composant UI :**

1. Chercher dans ce catalogue
2. S'il existe en natif Bootstrap → utiliser la classe officielle
3. S'il existe en pattern ASINCO custom (ci-dessous) → l'utiliser tel quel
4. Sinon → créer en respectant `UI-UX.md`, et le documenter ici

Doc officielle : <https://getbootstrap.com/docs/5.3/>

---

## 0. Chargement Bootstrap (à mettre dans `partials/header.php`)

```html
<!-- CSS Bootstrap + Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<!-- Police -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<!-- Custom -->
<link href="/assets/css/custom.css" rel="stylesheet">
```

```html
<!-- Avant </body> dans partials/footer.php -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/main.js"></script>
```

---

## 1. Composants Bootstrap natifs à utiliser

### Layout & containers
| Classe | Usage |
|---|---|
| `.container` / `.container-fluid` | Wrapper principal du `<main>` |
| `.row` + `.col-md-*` | Grille 12 colonnes |
| `.d-flex .gap-3 .align-items-center` | Flex layout |

### Navigation
| Composant | Usage ASINCO |
|---|---|
| `.navbar .navbar-expand-lg` | Topbar fixe en haut |
| `.offcanvas` | Sidebar mobile (slide depuis la gauche) |
| `.nav .flex-column` | Sidebar desktop (liste verticale) |
| `.breadcrumb` | Fil d'Ariane sur les fiches détail |
| `.pagination` | Pagination des tableaux |

### Tableaux
| Classe | Usage |
|---|---|
| `.table .table-hover .align-middle` | Tableau principal liste matériels/interventions |
| `.table-responsive` | Wrapper obligatoire pour scroll mobile |
| `.table-light` (sur thead) | Header de tableau |

### Formulaires
| Composant | Usage |
|---|---|
| `.form-control` / `.form-select` | Inputs et selects |
| `.form-label` | Label au-dessus du champ |
| `.form-text` | Hint sous le champ |
| `.is-invalid` + `.invalid-feedback` | États d'erreur |
| `.input-group` | Champ avec préfixe/suffixe (icône recherche) |

### Boutons & actions
| Composant | Usage |
|---|---|
| `.btn .btn-primary` | Action principale (Enregistrer) |
| `.btn .btn-outline-secondary` | Action neutre (Annuler) |
| `.btn .btn-outline-danger` | Suppression (avec confirmation modal) |
| `.btn-group .btn-group-sm` | Actions inline dans une ligne de tableau |
| `.btn-sm` | Variante compacte |

### Feedback
| Composant | Usage |
|---|---|
| `.alert .alert-success/warning/danger/info` | Messages de page |
| `.badge` | États matériel, compteurs |
| `.toast` | Notifications post-action |
| `.modal` | Confirmations, formulaires complexes |
| `.spinner-border` | Loading state |

### Cartes & affichage
| Composant | Usage |
|---|---|
| `.card .card-body` | KPI dashboard, fiches récap |
| `.list-group` | Listes simples (historique interventions) |
| `.progress` | Avancement (uniquement si donnée réelle, pas décoratif) |

---

## 2. Patterns ASINCO (à réutiliser tels quels)

### 2.1 Layout de page standard
```php
<?php
$pageTitle = 'Liste des matériels';
include __DIR__ . '/../partials/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h1 class="h3 mb-1"><?= htmlspecialchars($pageTitle) ?></h1>
    <p class="text-muted mb-0">Parc matériel ASINCO</p>
  </div>
  <a href="ajout.php" class="btn btn-primary">
    <i class="bi bi-plus-lg"></i> Ajouter un matériel
  </a>
</div>

<!-- Contenu spécifique -->

<?php include __DIR__ . '/../partials/footer.php'; ?>
```

### 2.2 Badge d'état matériel
```php
<?php
function badgeEtat(string $etat): string {
  $map = [
    'En service'    => 'bg-success',
    'En réparation' => 'bg-warning text-dark',
    'Déclassé'      => 'bg-secondary',
  ];
  $cls = $map[$etat] ?? 'bg-light text-dark';
  return '<span class="badge ' . $cls . '">' . htmlspecialchars($etat) . '</span>';
}
?>

<!-- Usage -->
<?= badgeEtat($materiel['etat']) ?>
```

### 2.3 Carte KPI dashboard
```html
<div class="col-md-3">
  <div class="card shadow-sm h-100">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <p class="text-muted small mb-1">Matériels en service</p>
          <h2 class="h3 mb-0">42</h2>
        </div>
        <span class="text-success fs-3"><i class="bi bi-check-circle"></i></span>
      </div>
    </div>
  </div>
</div>
```

### 2.4 Barre de filtres tableau
```html
<form class="row g-2 mb-3" method="get">
  <div class="col-md-4">
    <input type="search" name="q" class="form-control" placeholder="Rechercher une référence…">
  </div>
  <div class="col-md-3">
    <select name="categorie" class="form-select">
      <option value="">Toutes les catégories</option>
      <option value="reseau">Réseau</option>
      <option value="stockage">Stockage</option>
      <option value="calcul">Calcul</option>
    </select>
  </div>
  <div class="col-md-3">
    <select name="etat" class="form-select">
      <option value="">Tous les états</option>
      <option value="service">En service</option>
      <option value="reparation">En réparation</option>
      <option value="declasse">Déclassé</option>
    </select>
  </div>
  <div class="col-md-2">
    <button type="submit" class="btn btn-outline-primary w-100">Filtrer</button>
  </div>
</form>
```

### 2.5 Ligne de tableau avec actions
```html
<tr>
  <td><code><?= htmlspecialchars($m['reference']) ?></code></td>
  <td><?= htmlspecialchars($m['designation']) ?></td>
  <td><?= htmlspecialchars($m['categorie']) ?></td>
  <td><?= badgeEtat($m['etat']) ?></td>
  <td class="text-end">
    <div class="btn-group btn-group-sm" role="group">
      <a href="fiche.php?id=<?= $m['id'] ?>" class="btn btn-outline-secondary" title="Voir">
        <i class="bi bi-eye"></i>
      </a>
      <a href="modification.php?id=<?= $m['id'] ?>" class="btn btn-outline-primary" title="Modifier">
        <i class="bi bi-pencil"></i>
      </a>
      <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
              data-bs-target="#confirmDelete" data-id="<?= $m['id'] ?>" title="Supprimer">
        <i class="bi bi-trash"></i>
      </button>
    </div>
  </td>
</tr>
```

### 2.6 Formulaire ajout/édition
```html
<div class="card shadow-sm">
  <div class="card-body p-4">
    <form method="post" action="" novalidate>
      <div class="row g-3">
        <div class="col-md-6">
          <label for="reference" class="form-label">Référence <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="reference" name="reference" required>
        </div>
        <div class="col-md-6">
          <label for="designation" class="form-label">Désignation <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="designation" name="designation" required>
        </div>
        <div class="col-md-6">
          <label for="date_achat" class="form-label">Date d'achat <span class="text-danger">*</span></label>
          <input type="date" class="form-control" id="date_achat" name="date_achat" required>
        </div>
        <div class="col-md-6">
          <label for="categorie" class="form-label">Catégorie <span class="text-danger">*</span></label>
          <select class="form-select" id="categorie" name="categorie" required>
            <option value="">— Choisir —</option>
            <option value="1">Réseau</option>
            <option value="2">Stockage</option>
            <option value="3">Calcul</option>
          </select>
        </div>
      </div>
      <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
        <a href="liste.php" class="btn btn-outline-secondary">Annuler</a>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
      </div>
    </form>
  </div>
</div>
```

### 2.7 Modal de confirmation suppression
```html
<div class="modal fade" id="confirmDelete" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmer la suppression</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Cette action est irréversible. Voulez-vous vraiment supprimer ce matériel ?
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
        <a href="#" id="confirmDeleteLink" class="btn btn-danger">Supprimer</a>
      </div>
    </div>
  </div>
</div>
```

---

## 3. Icônes — Bootstrap Icons

CDN chargé en §0. Usage : `<i class="bi bi-NOM"></i>`.

Icônes ASINCO recommandées :
| Concept | Icône |
|---|---|
| Matériel | `bi-pc-display` ou `bi-hdd-rack` |
| Maintenance | `bi-tools` ou `bi-wrench` |
| Technicien | `bi-person-badge` |
| Catégorie | `bi-tag` |
| Dashboard | `bi-speedometer2` |
| Ajouter | `bi-plus-lg` |
| Modifier | `bi-pencil` |
| Supprimer | `bi-trash` |
| Voir | `bi-eye` |
| Filtrer | `bi-funnel` |
| Recherche | `bi-search` |
| Connexion | `bi-box-arrow-in-right` |
| Déconnexion | `bi-box-arrow-right` |

---

## 4. Combinaisons recommandées par page

| Page | Composants clés |
|---|---|
| Dashboard | 4 × KPI cards + tableau "Dernières interventions" + (optionnel) liste catégories |
| Liste matériels | Header + barre filtres §2.4 + tableau §2.5 + pagination |
| Ajout/édition matériel | Formulaire §2.6 dans une `.card` |
| Fiche matériel | Breadcrumb + header avec badge état + 2 colonnes (infos | historique interventions via `list-group`) |
| Liste interventions | Header + filtres + tableau (date, matériel, technicien, description tronquée) |
| Formulaire intervention | Form §2.6 adapté (matériel, technicien, date, description en `<textarea>`) |
| Login | Card centrée max 400px, logo en haut, form simple, lien "mot de passe oublié" |

---

## 5. Anti-patterns (interdits dans ce projet)

- ❌ Importer Tailwind / autre framework CSS en plus de Bootstrap
- ❌ jQuery (Bootstrap 5 ne le requiert plus)
- ❌ Composants React/Vue (stack imposée = HTML/PHP)
- ❌ Couleurs hardcodées en `style="…"` inline
- ❌ Recoder une carte/modal/form-group à la main
- ❌ Animations décoratives (parallax, particules, scale au hover)
- ❌ Glassmorphism sur une appli métier
- ❌ Afficher une variable PHP sans `htmlspecialchars()`

---

*COMPONENTS.md — Catalogue à enrichir au fur et à mesure que des patterns ASINCO récurrents émergent.*
