---
name: design
description: >
  Skill UI production-grade pour ASINCO. Déclencher sur tout mot lié à une interface :
  "page", "tableau", "formulaire", "navbar", "sidebar", "card", "dashboard",
  "UI", "interface", "layout", "design", "/design".
  Lire ce fichier EN PREMIER, puis UI-UX.md et COMPONENTS.md avant d'écrire une seule ligne de code.
  Stack imposée : PHP 8 + Bootstrap 5. Ne jamais réinventer un composant qui existe déjà dans Bootstrap.
---

# SKILL.md — Design System ASINCO

## Instruction de démarrage obligatoire

Avant tout code d'interface, dans cet ordre strict :

1. Lire `UI-UX.md` (règles de craft, patterns, anti-patterns)
2. Lire `COMPONENTS.md` (catalogue Bootstrap 5 + patterns ASINCO)
3. Vérifier `php/partials/` : si un layout/composant existe déjà, l'inclure plutôt que le recréer
4. Seulement après : écrire le code

## Raccourci `/design`

Quand l'utilisateur tape `/design [description]` :
- Appliquer toutes les règles de `UI-UX.md`
- Consulter `COMPONENTS.md` et lister les composants Bootstrap qui correspondent
- Produire du code prêt à l'emploi (PHP + Bootstrap), pas du pseudo-code
- Passer la checklist de `UI-UX.md` avant de livrer

---

## Stack de référence (ASINCO)

```
PHP 8         — templating uniquement au stade actuel (include, foreach sur données mockées)
Bootstrap 5.3 — chargé via CDN jsDelivr (CSS + JS bundle)
HTML5 / CSS3
Custom CSS    — assets/css/custom.css (variables couleurs + surcouches mineures)
JS vanilla    — assets/js/main.js (filtres tableau, validations bootstrap)
Polices       — Inter ou Poppins via Google Fonts
```

Pas de framework JS, pas de build step, pas de Tailwind. **Bootstrap utilities first.**

---

## Règle absolue sur les composants

**Ne jamais créer un composant qui existe déjà dans Bootstrap 5.**

Workflow obligatoire :
1. Chercher dans `COMPONENTS.md` (résumé Bootstrap) ou la doc officielle (`getbootstrap.com/docs/5.3`)
2. Si Bootstrap fournit le composant (Card, Modal, Offcanvas, Toast, Pagination, Form…) → l'utiliser tel quel
3. Si surcouche nécessaire → ajouter une classe utilitaire ou une variable CSS dans `assets/css/custom.css`
4. Si vraiment inexistant → créer en respectant les patterns de `UI-UX.md`

```html
<!-- ✅ Correct : composant Bootstrap natif -->
<div class="card shadow-sm">
  <div class="card-body">…</div>
</div>

<!-- ❌ Interdit : recoder une carte from scratch alors que Bootstrap en a une -->
<div class="ma-carte-custom" style="border-radius:8px; box-shadow:…">…</div>
```

---

## Règle sur les couleurs (ASINCO)

État actuel :
- `assets/css/custom.css` n'existe pas encore — **première tâche UI** : créer les variables CSS ASINCO
- Tant que la palette officielle n'est pas validée, défaut suggéré :
  - `--asinco-navy: #1B2A4A` — couleur primaire (navbar, headings)
  - `--asinco-blue: #2E6DA4` — accent interactif (boutons, liens)
  - `--asinco-accent: #F39C12` — alerte/attention (à valider)
  - États matériel : `success` (En service), `warning` (En réparation), `secondary` (Déclassé)

```css
/* assets/css/custom.css — pattern à utiliser */
:root {
  --asinco-navy: #1B2A4A;
  --asinco-blue: #2E6DA4;
  --bs-primary: var(--asinco-blue);   /* override Bootstrap */
}
```

```html
<!-- ✅ Correct -->
<button class="btn btn-primary">Enregistrer</button>

<!-- ❌ Interdit : couleur hardcodée inline -->
<button style="background:#2E6DA4">Enregistrer</button>
```

---

## Règle sur les partials PHP

À partir de la 2e page créée, **toujours** factoriser :

```php
<?php include __DIR__ . '/../partials/header.php'; ?>
<main class="container py-4">
  <!-- contenu spécifique à la page -->
</main>
<?php include __DIR__ . '/../partials/footer.php'; ?>
```

`partials/header.php` doit contenir :
- `<!doctype html>`, `<head>` (meta, titre dynamique via variable `$pageTitle`, CSS Bootstrap + custom)
- `<body>`, navbar, sidebar (collapsible sur mobile)

`partials/footer.php` doit contenir :
- Fermeture `</main>`, footer minimal, JS Bootstrap, JS custom, `</body></html>`

---

## Arborescence frontend (ASINCO)

```
php/
├── index.php                  ← Dashboard
├── partials/
│   ├── header.php             ← <head>, navbar, ouverture <main>
│   ├── sidebar.php            ← Menu latéral (inclus dans header)
│   └── footer.php             ← Fermeture, scripts
├── auth/login.php
├── materiel/                  ← liste, ajout, modification, fiche
├── maintenance/               ← liste, formulaire
├── categorie/liste.php
├── technicien/                ← liste, ajout, modification
├── data/mock.php              ← Tableaux PHP factices
├── assets/
│   ├── css/custom.css
│   ├── js/main.js
│   └── img/
└── config/connexion.php       ← Plus tard (Oracle)
```

---

## Checklist avant de livrer du code UI

Avant tout commit / livraison :

- [ ] `UI-UX.md` checklist passée
- [ ] Aucune couleur hardcodée — tout passe par les classes Bootstrap ou les variables CSS
- [ ] Header/sidebar/footer inclus via `partials/`
- [ ] `htmlspecialchars()` sur toute donnée affichée
- [ ] Form HTML5 valide (`required`, `type`, `pattern`)
- [ ] Responsive testé mentalement (375px → 1280px)
- [ ] Pas de JS inline — tout dans `assets/js/main.js`
- [ ] Page accessible : labels, focus visible, contraste WCAG AA
