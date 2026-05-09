# UI-UX.md — Règles de Design Production-Grade (ASINCO)

> Lire avant tout code d'interface. Ce fichier définit le **comment** construire.
> Stack appliquée : Bootstrap 5 + PHP + CSS custom léger.

---

## 0. Le Problème à Éviter — "AI Design Slop"

Les LLMs produisent par défaut des interfaces reconnaissables entre mille.
Ce pattern doit être **activement évité** :

- Gros titre centré avec texte en dégradé
- 3 cartes identiques avec icône + titre + texte
- Bouton CTA `rounded-pill` arc-en-ciel avec scale au hover
- Glassmorphism décoratif sur un dashboard métier
- Particules animées en background d'une appli de gestion
- Progress bars sans signification fonctionnelle
- Footer 4 colonnes de liens là où une ligne suffit

**ASINCO est une appli métier interne.** Le ton est sobre, professionnel, dense en information. Pas une landing page SaaS.

---

## 1. Références — Ce Qu'on Reproduit

### Stripe Dashboard, Linear, Notion (apps métier)
- Sidebar gauche fixe, main content dense, peu d'ornement
- Tableaux comme composant principal — pas que des cartes
- Typographie sans-serif resserrée, hiérarchie claire
- Couleur primaire **réservée aux éléments interactifs** (boutons, liens, badges actifs)
- Espace blanc généreux dans les headers, dense dans les listes

### Ce qu'on n'imite PAS
- Landing pages marketing (hero pleine hauteur, animations…)
- Sites de portfolio (pas notre cas d'usage)

---

## 2. Typographie

### Hiérarchie
```
H1 (titre de page)   : 1.75rem–2rem, weight 600, line-height 1.2
H2 (section)         : 1.25rem–1.5rem, weight 600
H3 (carte/panneau)   : 1rem–1.125rem, weight 600
Body                 : 1rem, weight 400, line-height 1.5
Small / meta         : 0.8125rem–0.875rem, weight 400–500, text-muted
```

### Règles
- Police : `Inter` ou `Poppins` via Google Fonts, fallback `system-ui`
- `letter-spacing: -0.01em` à `-0.02em` sur les H1/H2
- `text-muted` (Bootstrap) pour les méta-infos
- **Interdit** : texte en dégradé, `text-uppercase` sur les titres principaux, `font-weight:700` partout, emoji dans les titres

---

## 3. Layout

### Patterns par type de page ASINCO

```
Dashboard (index)        : Sidebar + main. KPIs en haut (4 cards Bootstrap),
                           graphiques/tableau récents en bas.
Liste (matériel, etc.)   : Sidebar + main. Header avec titre + bouton "Ajouter",
                           barre de filtres (selects + recherche), tableau full-width.
Formulaire ajout/édition : Sidebar + main. Carte centrale max 720px,
                           champs groupés logiquement.
Fiche détail             : Sidebar + main. Header avec breadcrumb + actions,
                           grille 2 colonnes (infos | historique).
Login                    : Pas de sidebar. Centré, max 400px, logo en haut.
```

### Respiration
- Sections : `padding-block` minimum **2rem** (`py-4` à `py-5` en Bootstrap)
- Container principal : `<main class="container py-4">` ou `container-fluid` si tableau dense
- Padding mobile : Bootstrap gère via le container

### Grille
- Bootstrap grid 12 colonnes (`row` + `col-md-*`)
- Jamais de pourcentages arbitraires hors grille
- `gap` cohérents : `g-3` (1rem), `g-4` (1.5rem)

---

## 4. Composants

### Boutons (Bootstrap)
```
Primaire    : .btn .btn-primary               → action principale
Secondaire  : .btn .btn-outline-secondary     → action neutre
Danger      : .btn .btn-outline-danger        → suppression (jamais .btn-danger plein
                                                tant qu'il n'y a pas de confirmation)
Tailles     : .btn-sm pour les actions inline dans un tableau
```

**Interdit :**
- ❌ `rounded-pill` sur les CTAs principaux (réservé aux badges)
- ❌ `transform: scale` au hover
- ❌ Couleur de bouton hardcodée en inline style
- ❌ Boutons full-width par défaut sur desktop

### Tableaux (composant central d'ASINCO)
```html
<div class="table-responsive">
  <table class="table table-hover align-middle">
    <thead class="table-light">
      <tr><th>Référence</th><th>Désignation</th><th>État</th><th class="text-end">Actions</th></tr>
    </thead>
    <tbody>…</tbody>
  </table>
</div>
```

Règles :
- Toujours `table-responsive` (scroll horizontal sur mobile)
- `align-middle` pour centrer verticalement les badges/boutons
- Actions à droite (`text-end`), groupées dans un `.btn-group btn-group-sm`
- Hauteur des lignes confortable mais dense — pas de `py-4` excessif

### Cartes
- `.card` + `.card-body` (padding `1rem`–`1.5rem` selon densité)
- `.shadow-sm` au max — jamais `.shadow-lg` pour du contenu métier
- Pas de `hover:scale`, pas de gradient en background

### Formulaires
```html
<div class="mb-3">
  <label for="reference" class="form-label">Référence <span class="text-danger">*</span></label>
  <input type="text" class="form-control" id="reference" name="reference" required>
  <div class="form-text">Identifiant unique du matériel.</div>
</div>
```

Règles :
- **Label TOUJOURS au-dessus du champ**, jamais placeholder seul
- Astérisque rouge pour les champs obligatoires
- `form-text` (Bootstrap) pour les hints sous les champs
- Erreurs : `.is-invalid` + `.invalid-feedback` (jamais juste un toast)
- Boutons en bas : `Annuler` (outline-secondary) à gauche, `Enregistrer` (primary) à droite

### Badges d'état (pattern ASINCO clé)
```html
<span class="badge bg-success">En service</span>
<span class="badge bg-warning text-dark">En réparation</span>
<span class="badge bg-secondary">Déclassé</span>
```

### Navigation
- **Topbar** : `navbar navbar-expand-lg` avec logo ASINCO à gauche, user menu à droite, hauteur ~56px
- **Sidebar** : `nav flex-column` avec icônes (Bootstrap Icons), entrée active surlignée via `.active`
- Sur mobile : sidebar devient `offcanvas` Bootstrap

---

## 5. Interactions et Animations

### Principe de retenue
Une appli de gestion ne danse pas. Les transitions servent à **adoucir un changement d'état**, pas à divertir.

### Permis
- Hover discret sur les lignes de tableau (`table-hover` natif)
- Focus visible sur les inputs (Bootstrap le gère)
- Toasts pour les confirmations d'action (`bootstrap.Toast`)
- Modals pour les confirmations destructives

### Interdit
- ❌ `animation-duration > 300ms` sur du UI fonctionnel
- ❌ Particules, parallax, rotations infinies
- ❌ `transition: all` — cibler les propriétés précises

---

## 6. Spacing — Système Bootstrap

Utiliser l'échelle Bootstrap : `0, 1, 2, 3, 4, 5` (= 0, 0.25rem, 0.5rem, 1rem, 1.5rem, 3rem).

```
m-0/p-0      → aucun espace
m-1/p-1      → 0.25rem (4px)
m-2/p-2      → 0.5rem (8px)
m-3/p-3      → 1rem (16px) — défaut le plus utilisé
m-4/p-4      → 1.5rem (24px)
m-5/p-5      → 3rem (48px) — sections importantes
```

**Règle** : pas de `style="margin:13px"` jamais. Si Bootstrap n'a pas la bonne valeur, ajouter une classe utilitaire dans `custom.css`.

---

## 7. Mobile-First

```
< 576px  : 1 colonne, sidebar en offcanvas, tableaux scrollables horizontalement
≥ 768px  : 2 colonnes possibles dans les formulaires, sidebar visible
≥ 992px  : layout complet, sidebar fixe à 240px
≥ 1200px : container max-width atteint
```

**Règles mobile :**
- Touch target minimum : 44px (Bootstrap respecte ça par défaut sur les `.btn`)
- `font-size: 16px` minimum sur les inputs (évite le zoom iOS)
- Tableaux : toujours dans `.table-responsive`

---

## 8. Accessibilité — Non-Négociable

```
Contraste texte/fond : minimum 4.5:1 (WCAG AA)
Focus visible        : Bootstrap le gère, NE PAS le supprimer avec outline:none
Labels               : associés aux inputs via for/id
Sémantique HTML      : <nav>, <main>, <aside>, <article>, <table> — pas que des <div>
Icônes seules        : aria-label obligatoire
Boutons icône-only   : aria-label + title
```

---

## 9. Sécurité d'affichage

- **Toujours** échapper les données affichées : `<?= htmlspecialchars($var) ?>`
- Réflexe à prendre dès le stade des données mockées
- Pour les attributs HTML : `htmlspecialchars($var, ENT_QUOTES)`

---

## 10. Checklist Avant Livraison

**Typographie**
- [ ] Police Google Fonts chargée dans `partials/header.php` ?
- [ ] Hiérarchie respectée (h1 unique par page) ?
- [ ] Aucun texte en dégradé ?

**Layout**
- [ ] Header/sidebar/footer inclus via `partials/` ?
- [ ] Container Bootstrap utilisé (pas de width arbitraire) ?
- [ ] Testé mentalement en 375px ?

**Composants**
- [ ] Composants Bootstrap natifs utilisés (pas réinventés) ?
- [ ] Formulaires : label au-dessus, astérisque sur required ?
- [ ] Tableaux dans `table-responsive` ?
- [ ] Badges d'état avec les bonnes classes (`bg-success`/`bg-warning`/`bg-secondary`) ?
- [ ] Pas de couleur hardcodée inline ?

**Sécurité**
- [ ] `htmlspecialchars()` sur toutes les données affichées ?

**Accessibilité**
- [ ] Tous les inputs ont un label associé ?
- [ ] Focus visible préservé ?
- [ ] Contraste WCAG AA ?
- [ ] Sémantique HTML correcte ?

---

*UI-UX.md — Règles de craft pour une appli métier sobre. Pas une landing page.*
