

```
# 🖥️ ASINCO — Système de Gestion de Stock et de Maintenance

> Projet universitaire — Groupe 1  
> Application web de gestion du parc matériel et suivi des maintenances

---

## 📌 Description

ASINCO est une application web permettant à la société **ASINCO** de centraliser :
- La gestion de son **parc matériel** (serveurs, switchs, équipements réseau...)
- Le suivi des **interventions de maintenance**
- L'état en temps réel de chaque équipement

---

## 🛠️ Technologies utilisées

| Couche | Technologie |
|--------|-------------|
| Base de données | Oracle SQL + PL/SQL |
| Connexion BD | PHP 8.x + OCI8 |
| Frontend | HTML5 + CSS3 + Bootstrap 5 |
| Versioning | Git + GitHub |

---

## 📁 Structure du projet

```
asinco-gestion-stock/
│
├── analyse/
│   ├── MCD.png                  # Modèle Conceptuel de Données
│   └── MLD.md                   # Modèle Logique de Données
│
├── database/
│   ├── 01_create_tables.sql     # Création des tables + contraintes
│   ├── 02_plsql.sql             # Procédures et fonctions PL/SQL
│   └── 03_insert_data.sql       # Données de test
│
├── php/
│   ├── config/
│   │   └── connexion.php        # ⚠️ À créer manuellement (non versionné)
│   ├── materiel/
│   │   ├── liste.php            # Liste des matériels
│   │   ├── ajout.php            # Formulaire d'ajout
│   │   └── modification.php     # Formulaire de modification
│   └── maintenance/
│       ├── formulaire.php       # Nouvelle intervention
│       └── fiche.php            # Fiche matériel + nb interventions
│
├── rapport/
│   └── Rapport_final.pdf        # Rapport de projet
│
├── .gitignore
└── README.md
```

---

## ⚙️ Installation

### 1. Prérequis
- Oracle Database (XE ou autre) installé et configuré
- PHP 8.x avec l'extension **OCI8** activée
- Serveur local : XAMPP ou WAMP

### 2. Base de données
Exécuter les scripts SQL dans Oracle SQL Developer **dans cet ordre** :

```sql
-- Étape 1 : Création des tables
@database/01_create_tables.sql

-- Étape 2 : Procédures et fonctions
@database/02_plsql.sql

-- Étape 3 : Données de test
@database/03_insert_data.sql
```

### 3. Configuration PHP
Créer le fichier `php/config/connexion.php` (non versionné pour des raisons de sécurité) :

```php
<?php
$host     = 'localhost';
$port     = '1521';
$sid      = 'XE'; // Remplacer par votre SID Oracle
$user     = 'votre_user';
$password = 'votre_password';

$conn = oci_connect($user, $password, "$host:$port/$sid");

if (!$conn) {
    $e = oci_error();
    die("Erreur de connexion Oracle : " . $e['message']);
}
?>
```

### 4. Lancer l'application
Placer le dossier `php/` dans le répertoire `htdocs/` de XAMPP puis accéder à :
```
http://localhost/php/materiel/liste.php
```

---

## 🗄️ Objets PL/SQL

### Procédure — `PRC_AJOUT_INTERVENTION`
Insère une nouvelle intervention et met automatiquement à jour l'état du matériel à `En réparation`.

### Fonction — `FNC_NB_INTERVENTIONS`
Retourne le nombre total d'interventions effectuées pour un matériel donné.

---

---

## 📋 Livrables

- [x] Cahier des charges
- [ ] Dossier d'analyse (MCD + MLD)
- [ ] Scripts SQL complets
- [ ] Code source PHP
- [ ] Rapport final
- [ ] Démonstration / Captures d'écran

---

## ⚠️ Sécurité

Le fichier `php/config/connexion.php` est dans le `.gitignore` et ne doit **jamais** être pushé sur GitHub car il contient les identifiants Oracle.
```

---

Tu peux remplacer les **"Membre 1, Membre 2..."** par les vrais prénoms de ton groupe. Tu veux qu'on attaque les scripts SQL maintenant ?
