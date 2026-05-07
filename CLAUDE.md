# 🧠 CLAUDE.md — Mémoire Persistante de Session (ASINCO)

> **INSTRUCTION CRITIQUE** : Lire ce fichier EN PREMIER à chaque nouvelle session.
> Puis lire `AMELIORATIONS.md` avant tout acte de code.
> Pour toute tâche UI/UX : enchaîner `SKILL.md` → `UI-UX.md` → `COMPONENTS.md` AVANT d'écrire du code.

---

## 👤 Identité du Propriétaire

| Champ | Valeur |
|---|---|
| **Nom** | AMOUSSOU Siméon Céphas (alias `Gblewa`) |
| **Formation** | L2 Génie Logiciel — IFRI, Université d'Abomey-Calavi, Bénin |
| **Localisation** | Cotonou, Bénin 🇧🇯 |
| **Langue de travail** | Français (réponses et docs en FR par défaut) |

---

## 🎯 Projet Actif — ASINCO Gestion de Stock

| Champ | Valeur |
|---|---|
| **Type** | Projet universitaire — Groupe 1, IFRI |
| **Mission** | Application web de gestion du parc matériel + suivi des maintenances pour la société ASINCO (location de matériel informatique) |
| **Phase actuelle** | Production du **frontend uniquement** (HTML / CSS / Bootstrap / PHP statique avec données mockées) |
| **Branchement BDD** | Plus tard — Oracle + PL/SQL via OCI8 |

### Stack imposée
```
Frontend  : HTML5 · CSS3 · Bootstrap 5 · PHP 8 (templating only au stade actuel)
Backend   : PHP 8 + extension OCI8        (à venir)
BDD       : Oracle SQL + PL/SQL           (à venir)
DevOps    : XAMPP / WAMP en local · Git + GitHub
```

### Périmètre fonctionnel (cahier des charges)
1. **Parc matériel** : liste, ajout, modification, fiche détail, filtrage par catégorie/état
2. **Maintenances** : enregistrer une intervention, lister, fiche
3. **Techniciens** : CRUD basique
4. **Catégories** : Réseau, Stockage, Calcul
5. **États matériel** : `En service` · `En réparation` · `Déclassé`

### Objets PL/SQL prévus (côté backend, hors scope front)
- Procédure `PRC_AJOUT_INTERVENTION` — insère + passe le matériel à `En réparation`
- Fonction `FNC_NB_INTERVENTIONS` — compteur d'interventions par matériel

---

## 📁 Arborescence cible (frontend ASINCO)

```
asinco-gestion-stock/
├── php/
│   ├── index.php                       ← Tableau de bord (KPIs)
│   ├── partials/
│   │   ├── header.php                  ← <head> + topbar Bootstrap
│   │   ├── sidebar.php                 ← Menu latéral
│   │   └── footer.php
│   ├── auth/
│   │   └── login.php
│   ├── materiel/
│   │   ├── liste.php
│   │   ├── ajout.php
│   │   ├── modification.php
│   │   └── fiche.php
│   ├── maintenance/
│   │   ├── liste.php
│   │   └── formulaire.php
│   ├── categorie/
│   │   └── liste.php
│   ├── technicien/
│   │   ├── liste.php
│   │   ├── ajout.php
│   │   └── modification.php
│   ├── data/
│   │   └── mock.php                    ← Données factices (tableaux PHP)
│   ├── assets/
│   │   ├── css/custom.css              ← Surcouche Bootstrap
│   │   ├── js/main.js                  ← Filtres tableau, validations
│   │   └── img/
│   └── config/
│       └── connexion.php               ← (créé plus tard, .gitignore)
├── analyse/                            ← MCD/MLD
├── database/                           ← Scripts SQL
└── rapport/
```

---

## 📐 Principes de Code (à respecter toujours)

```
1. SIMPLE > complexe   — Une fonction = une responsabilité
2. LISIBLE             — Nommer en français métier (matériel, intervention…)
3. RÉUTILISABLE        — Partials PHP pour header/sidebar/footer
4. ROBUSTE             — Validations HTML5 + PHP server-side prévues
5. ACCESSIBLE          — Labels au-dessus des inputs, focus visible, contrastes WCAG AA
6. BOOTSTRAP-FIRST     — Privilégier les classes Bootstrap natives, custom.css uniquement pour la marque
```

---

## 🔄 Workflow Obligatoire par Session

```
DÉBUT DE SESSION :
  1. Lire CLAUDE.md          (ce fichier)
  2. Lire AMELIORATIONS.md   (leçons apprises)
  3. Pour tâche UI : SKILL.md → UI-UX.md → COMPONENTS.md
  4. Coder

FIN DE TÂCHE :
  1. Mettre à jour AMELIORATIONS.md
     - Ce qui a été fait
     - Erreurs rencontrées + solutions
     - Nouvelles leçons
```

---

## 📌 Notes Importantes

- **Front-only au stade actuel** : aucune connexion Oracle. Les pages `.php` ne servent qu'à factoriser les `include` (partials) et boucler sur des tableaux mockés.
- Bootstrap 5 chargé via CDN (jsDelivr) tant qu'on n'a pas de build pipeline.
- Police suggérée : `Inter` ou `Poppins` via Google Fonts (à confirmer avec l'équipe).
- Palette par défaut tant que rien n'est imposé : `navy #1B2A4A` · `blue #2E6DA4` · `accent #F39C12` (à valider).
- Les états du matériel sont représentés par des **badges Bootstrap colorés** : `bg-success` (En service), `bg-warning text-dark` (En réparation), `bg-secondary` (Déclassé).

---

*Dernière mise à jour : 2026-05-07 — Pivot vers projet ASINCO*
