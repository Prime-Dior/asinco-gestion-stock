# 📈 AMELIORATIONS.md — Journal Vivant des Leçons Apprises (ASINCO)

> **INSTRUCTION** : Lire ce fichier AVANT de coder dans toute nouvelle session.
> Mettre à jour ce fichier APRÈS chaque tâche accomplie.

---

## 🗂️ Structure d'une Entrée

```markdown
### [DATE] — [Titre court de la tâche]
**Contexte** : Brève description de ce qui était demandé
**Ce qui a été fait** : Actions réalisées
**Erreurs rencontrées** : Problème exact + message d'erreur si disponible
**Solution appliquée** : Comment ça a été résolu
**Leçon retenue** : Ce qu'il faut retenir pour la prochaine fois
```

---

## ✅ Journal des Tâches

---

### [2026-05-07] — Réadaptation des fichiers .md au projet ASINCO

**Contexte** : Les fichiers `CLAUDE.md`, `AMELIORATIONS.md`, `SKILL.md`, `UI-UX.md`, `COMPONENTS.md` étaient calibrés pour le projet React **Alliance Bouclier**. Le projet courant est **ASINCO** (PHP + Bootstrap 5, frontend-only au stade actuel). Réécriture des 5 fichiers pour refléter la vraie stack et le vrai périmètre.

**Ce qui a été fait** :
- `CLAUDE.md` : nouvelle identité projet (ASINCO), arborescence PHP cible, périmètre fonctionnel issu du cahier des charges
- `AMELIORATIONS.md` : journal réinitialisé (les anciennes entrées Alliance Bouclier ne s'appliquent pas)
- `SKILL.md` : pivote de "design system React 63 composants" vers "design system Bootstrap 5 + PHP partials"
- `UI-UX.md` : règles de craft conservées (agnostiques) ; références aux classes Tailwind/CSS-vars retirées au profit de Bootstrap utilities
- `COMPONENTS.md` : remplacé l'inventaire de 63 composants Aceternity/Magic UI par un catalogue **Bootstrap 5** (composants, utilitaires, patterns ASINCO)

**Pages cibles identifiées** (cahier des charges + README) :
- Dashboard (`index.php`)
- Matériel : liste, ajout, modification, fiche
- Maintenance : liste, formulaire
- Catégorie : liste
- Technicien : liste, ajout, modification
- Auth : login
- Partials : header, sidebar, footer

**Leçon retenue** :
- Toujours vérifier la stack réelle (`README.md` + cahier des charges) avant d'écrire des règles dans les `.md` — un ancien set de règles React n'a aucune valeur sur un projet PHP/Bootstrap
- Les règles de craft UI (typo, layout, spacing, a11y) sont **réutilisables** d'un projet à l'autre ; seules les références techniques (classes, chemins, composants) doivent être réécrites

---

## 🐛 Catalogue d'Erreurs Résolues

> À remplir au fur et à mesure (PHP/Bootstrap/Oracle).

---

## 📚 Leçons Générales

| # | Leçon | Contexte |
|---|---|---|
| 1 | Lire SKILL.md → UI-UX.md → COMPONENTS.md AVANT tout code d'interface | Workflow obligatoire |
| 2 | Bootstrap-first : ne pas réécrire en CSS ce qu'une classe utilitaire fait déjà | `d-flex`, `gap-3`, `text-muted`… |
| 3 | Factoriser via `include 'partials/header.php'` dès la 2e page créée | Évite la duplication immédiate |
| 4 | Stocker les données mockées dans un seul fichier `data/mock.php` | Facilite le branchement Oracle |
| 5 | Utiliser `htmlspecialchars()` même sur les données mockées | Réflexe XSS dès le début |

---

## 🔧 Snippets Réutilisables

### Inclusion d'un partial PHP
```php
<?php include __DIR__ . '/../partials/header.php'; ?>
```

### Badge d'état matériel
```php
<?php
$badges = [
  'En service'    => 'bg-success',
  'En réparation' => 'bg-warning text-dark',
  'Déclassé'      => 'bg-secondary',
];
?>
<span class="badge <?= $badges[$etat] ?? 'bg-light text-dark' ?>">
  <?= htmlspecialchars($etat) ?>
</span>
```

### Tableau Bootstrap responsive
```html
<div class="table-responsive">
  <table class="table table-hover align-middle">
    <thead class="table-light">…</thead>
    <tbody>…</tbody>
  </table>
</div>
```

---

## 📊 Statistiques

| Métrique | Valeur |
|---|---|
| Tâches documentées | 2 |
| Pages frontend produites | 13 / 13 ✅ |
| Partials produits | 6 |
| Erreurs résolues | 0 |

---

*Dernière mise à jour : 2026-05-07 — Frontend complet ASINCO livré*
