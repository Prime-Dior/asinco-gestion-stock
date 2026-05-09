<?php
/**
 * ASINCO — Données Oracle (remplace mock.php)
 * ─────────────────────────────────────────────────────────
 *  Ce fichier charge TOUTES les données depuis Oracle.
 *  Il expose les mêmes variables que mock.php :
 *    $CATEGORIES, $TECHNICIENS, $MATERIELS, $INTERVENTIONS, $ETATS
 *  Et les mêmes helpers : asinco_categorie(), asinco_technicien(), etc.
 * ─────────────────────────────────────────────────────────
 */

require_once __DIR__ . '/../config/connexion.php';

// ── Données constantes ────────────────────────────────────
$ETATS = ['En service', 'En réparation', 'Déclassé'];

// ── Catégories ────────────────────────────────────────────
$_rows = asinco_query('SELECT ID_CATEGORIE, LIBELLE, DESCRIPTION FROM CATEGORIE ORDER BY LIBELLE');
$CATEGORIES = [];
foreach ($_rows as $r) {
    $id = (int)$r['ID_CATEGORIE'];
    $CATEGORIES[$id] = [
        'id'          => $id,
        'libelle'     => $r['LIBELLE'],
        'description' => $r['DESCRIPTION'],
    ];
}

// ── Techniciens ───────────────────────────────────────────
$_rows = asinco_query('SELECT ID_TECHNICIEN, NOM, PRENOM, SPECIALITE FROM TECHNICIEN ORDER BY NOM');
$TECHNICIENS = [];
foreach ($_rows as $r) {
    $id = (int)$r['ID_TECHNICIEN'];
    $TECHNICIENS[$id] = [
        'id'         => $id,
        'nom'        => $r['NOM'],
        'prenom'     => $r['PRENOM'],
        'specialite' => $r['SPECIALITE'],
    ];
}

// ── Matériels ─────────────────────────────────────────────
$_rows = asinco_query(
    'SELECT ID_MATERIEL, REFERENCE, DESIGNATION,
            TO_CHAR(DATE_ACHAT,\'YYYY-MM-DD\') AS DATE_ACHAT,
            ETAT, ID_CATEGORIE
     FROM MATERIEL
     ORDER BY ID_MATERIEL'
);
$MATERIELS = [];
foreach ($_rows as $r) {
    $MATERIELS[] = [
        'id'           => (int)$r['ID_MATERIEL'],
        'reference'    => $r['REFERENCE'],
        'designation'  => $r['DESIGNATION'],
        'date_achat'   => $r['DATE_ACHAT'],
        'etat'         => $r['ETAT'],
        'id_categorie' => (int)$r['ID_CATEGORIE'],
    ];
}

// ── Interventions ─────────────────────────────────────────
$_rows = asinco_query(
    'SELECT ID_INTERVENTION,
            TO_CHAR(DATE_INTERVENTION,\'YYYY-MM-DD\') AS DATE_INTERVENTION,
            DESCRIPTION, ID_MATERIEL, ID_TECHNICIEN
     FROM INTERVENTION
     ORDER BY DATE_INTERVENTION DESC'
);
$INTERVENTIONS = [];
foreach ($_rows as $r) {
    $INTERVENTIONS[] = [
        'id'                => (int)$r['ID_INTERVENTION'],
        'date_intervention' => $r['DATE_INTERVENTION'],
        'description'       => $r['DESCRIPTION'],
        'id_materiel'       => (int)$r['ID_MATERIEL'],
        'id_technicien'     => (int)$r['ID_TECHNICIEN'],
    ];
}

// ── Helpers (identiques à mock.php) ──────────────────────

function asinco_categorie(int $id): ?array {
    global $CATEGORIES;
    return $CATEGORIES[$id] ?? null;
}

function asinco_technicien(int $id): ?array {
    global $TECHNICIENS;
    return $TECHNICIENS[$id] ?? null;
}

function asinco_materiel(int $id): ?array {
    global $MATERIELS;
    foreach ($MATERIELS as $m) if ($m['id'] === $id) return $m;
    return null;
}

/**
 * Utilise FNC_NB_INTERVENTIONS (fonction Oracle)
 */
function asinco_nb_interventions(int $id_materiel): int {
    return asinco_fnc_nb_interventions($id_materiel);
}

function asinco_interventions_par_materiel(int $id_materiel): array {
    global $INTERVENTIONS;
    return array_values(array_filter($INTERVENTIONS, fn($i) => $i['id_materiel'] === $id_materiel));
}

function asinco_state_class(string $etat): string {
    return match ($etat) {
        'En service'    => 'state-service',
        'En réparation' => 'state-reparation',
        'Déclassé'      => 'state-declasse',
        default         => '',
    };
}

function asinco_kpis(): array {
    global $MATERIELS, $INTERVENTIONS;
    $service = $reparation = $declasse = 0;
    foreach ($MATERIELS as $m) {
        if ($m['etat'] === 'En service')    $service++;
        if ($m['etat'] === 'En réparation') $reparation++;
        if ($m['etat'] === 'Déclassé')      $declasse++;
    }
    return [
        'total'         => count($MATERIELS),
        'service'       => $service,
        'reparation'    => $reparation,
        'declasse'      => $declasse,
        'interventions' => count($INTERVENTIONS),
    ];
}

/** Échappement HTML court */
function e(?string $s): string {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

/** URL helper — calcule le chemin absolu depuis n'importe quelle page */
function asinco_url(string $path): string {
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $dir    = dirname($script);
    $parent = basename($dir);
    $subdirs = ['materiel','maintenance','categorie','technicien','auth','partials'];
    $base = in_array($parent, $subdirs, true) ? dirname($dir) : $dir;
    $base = rtrim($base, '/');
    return ($base === '' ? '' : $base) . '/' . ltrim($path, '/');
}
