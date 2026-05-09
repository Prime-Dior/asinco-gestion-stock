```markdown
# 🖥️ ASINCO — Système de Gestion de Stock et de Maintenance
> Projet universitaire — Groupe 1  
> Application web de gestion du parc matériel et suivi des maintenances

---

## 📌 Description
ASINCO est une application web permettant à la société **ASINCO** de centraliser :
- La gestion de son **parc matériel** (serveurs, switchs, équipements réseau...)
- Le suivi des **interventions de maintenance**
- L'état en temps réel de chaque équipement (En service / En réparation / Déclassé)
- La gestion des **techniciens** et de leurs spécialités

---

## 🛠️ Technologies utilisées

| Couche | Technologie |
|--------|-------------|
| Base de données | Oracle SQL + PL/SQL (XE 11g) |
| Connexion BD | PHP 8.1 + OCI8 |
| Frontend | HTML5 + CSS3 + JS (design custom, thème sombre/clair) |
| Versioning | Git + GitHub |

---

## 📁 Structure du projet

```
asinco-gestion-stock/
├── database/
│   ├── 01_create_tables.sql   # DDL : tables, séquences, contraintes
│   ├── 02_plsql.sql           # Procédure PRC_AJOUT_INTERVENTION + Fonction FNC_NB_INTERVENTIONS
│   └── 03_insert_data.sql     # Données de test
├── php/
│   ├── config/
│   │   └── connexion.php      # Connexion Oracle OCI8 + helpers
│   ├── data/
│   │   └── db.php             # Requêtes SQL centralisées
│   ├── materiel/              # CRUD matériels
│   ├── maintenance/           # Formulaire et liste des interventions
│   ├── technicien/            # CRUD techniciens
│   ├── categorie/             # Liste des catégories
│   ├── partials/              # Composants réutilisables (sidebar, topbar...)
│   ├── dashboard.php          # Tableau de bord
│   └── login.php              # Page de connexion
└── README.md
```

---

## ⚙️ Installation

### Prérequis
- WAMP / XAMPP avec **PHP 8.1**
- **Oracle XE** installé localement
- Extension **OCI8** activée (php_oci8_19.dll)
- **Instant Client Oracle 19.x** dans le PATH système

### Configuration
1. Importer les scripts SQL dans Oracle :
```sql
@database/01_create_tables.sql
@database/02_plsql.sql
@database/03_insert_data.sql
```

2. Configurer la connexion dans `php/config/connexion.php` :
```php
define('ORA_USER',     'ASINCO');
define('ORA_PASSWORD', 'asinco123');
define('ORA_DSN',      'localhost/XE');
```

3. Placer le projet dans `C:\wamp64\www\` et accéder via :
```
http://localhost/asinco-gestion-stock-main/php/
```

---

## 🗄️ Modèle de données

- **CATEGORIE** (ID_CATEGORIE, LIBELLE, DESCRIPTION)
- **MATERIEL** (ID_MATERIEL, REFERENCE, DESIGNATION, DATE_ACHAT, ETAT, ID_CATEGORIE)
- **TECHNICIEN** (ID_TECHNICIEN, NOM, PRENOM, SPECIALITE)
- **INTERVENTION** (ID_INTERVENTION, DATE_INTERVENTION, DESCRIPTION, ID_MATERIEL, ID_TECHNICIEN)

---

## 🔧 Objets PL/SQL

- `PRC_AJOUT_INTERVENTION` : insère une intervention et met l'équipement à *En réparation*
- `FNC_NB_INTERVENTIONS` : retourne le nombre d'interventions pour un matériel donné

---

## 👥 Équipe — Groupe 1

| Membre | Rôle |
|--------|------|
| Membre 1 | Base de données + Backend OCI8 |
| Membre 2 | Analyse & Modélisation (MCD/MLD) |
| Membre 3 | Frontend Parc Matériel |
| Membre 4 | Frontend Maintenance |
| Membre 5 | Intégration PHP ↔ Oracle |
| Membre 6 | Rapport & Livrables |
```

