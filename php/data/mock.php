<?php
/**
 * ASINCO — Données mockées (frontend-only)
 * À remplacer par des appels Oracle/OCI8 lorsque le backend sera branché.
 */

$CATEGORIES = [
    1 => ['id' => 1, 'libelle' => 'Réseau',    'description' => 'Switchs, routeurs, points d\'accès'],
    2 => ['id' => 2, 'libelle' => 'Stockage',  'description' => 'Serveurs de stockage, NAS, baies'],
    3 => ['id' => 3, 'libelle' => 'Calcul',    'description' => 'Serveurs de calcul, GPU, workstations'],
];

$TECHNICIENS = [
    1 => ['id' => 1, 'nom' => 'KOUASSI',  'prenom' => 'Mathieu',  'specialite' => 'Réseau'],
    2 => ['id' => 2, 'nom' => 'AHOUANSOU','prenom' => 'Léonie',   'specialite' => 'Systèmes'],
    3 => ['id' => 3, 'nom' => 'TONOUKOUIN','prenom' => 'Fabrice', 'specialite' => 'Stockage'],
    4 => ['id' => 4, 'nom' => 'AGBODJAN', 'prenom' => 'Nadège',   'specialite' => 'Calcul / GPU'],
    5 => ['id' => 5, 'nom' => 'DOSSOU',   'prenom' => 'Yannick',  'specialite' => 'Polyvalent'],
];

$ETATS = ['En service', 'En réparation', 'Déclassé'];

$MATERIELS = [
    ['id' => 1,  'reference' => 'SW-CSC-2960-01', 'designation' => 'Switch Cisco Catalyst 2960',     'date_achat' => '2023-04-12', 'etat' => 'En service',    'id_categorie' => 1],
    ['id' => 2,  'reference' => 'SW-CSC-2960-02', 'designation' => 'Switch Cisco Catalyst 2960',     'date_achat' => '2023-04-12', 'etat' => 'En réparation', 'id_categorie' => 1],
    ['id' => 3,  'reference' => 'RT-MK-CCR1009',  'designation' => 'Routeur MikroTik CCR1009',       'date_achat' => '2022-09-03', 'etat' => 'En service',    'id_categorie' => 1],
    ['id' => 4,  'reference' => 'AP-UBQ-U6PRO-01','designation' => 'Borne Wi-Fi UniFi U6 Pro',       'date_achat' => '2024-01-22', 'etat' => 'En service',    'id_categorie' => 1],
    ['id' => 5,  'reference' => 'SRV-DELL-R740',  'designation' => 'Dell PowerEdge R740',            'date_achat' => '2021-06-15', 'etat' => 'En service',    'id_categorie' => 3],
    ['id' => 6,  'reference' => 'SRV-HPE-DL380',  'designation' => 'HPE ProLiant DL380 Gen10',       'date_achat' => '2020-11-08', 'etat' => 'En réparation', 'id_categorie' => 3],
    ['id' => 7,  'reference' => 'NAS-SYNO-RS820', 'designation' => 'Synology RackStation RS820+',    'date_achat' => '2022-03-30', 'etat' => 'En service',    'id_categorie' => 2],
    ['id' => 8,  'reference' => 'NAS-QNAP-TS873', 'designation' => 'QNAP TS-873A',                   'date_achat' => '2023-07-19', 'etat' => 'En service',    'id_categorie' => 2],
    ['id' => 9,  'reference' => 'BAY-NETAPP-FAS', 'designation' => 'NetApp FAS2750',                 'date_achat' => '2019-02-11', 'etat' => 'Déclassé',      'id_categorie' => 2],
    ['id' => 10, 'reference' => 'GPU-NV-A100-01', 'designation' => 'NVIDIA A100 80GB',               'date_achat' => '2024-05-04', 'etat' => 'En service',    'id_categorie' => 3],
    ['id' => 11, 'reference' => 'WS-LEN-P620',    'designation' => 'Lenovo ThinkStation P620',       'date_achat' => '2023-12-01', 'etat' => 'En service',    'id_categorie' => 3],
    ['id' => 12, 'reference' => 'SW-HP-1950-01',  'designation' => 'HP Aruba 1950 Switch',           'date_achat' => '2021-08-25', 'etat' => 'Déclassé',      'id_categorie' => 1],
];

$INTERVENTIONS = [
    ['id' => 1,  'date_intervention' => '2026-05-02', 'description' => 'Remplacement de l\'alimentation principale après surtension', 'id_materiel' => 6, 'id_technicien' => 2],
    ['id' => 2,  'date_intervention' => '2026-04-28', 'description' => 'Mise à jour du firmware et reconfiguration VLAN',             'id_materiel' => 1, 'id_technicien' => 1],
    ['id' => 3,  'date_intervention' => '2026-04-21', 'description' => 'Diagnostic ventilateur défectueux',                            'id_materiel' => 2, 'id_technicien' => 1],
    ['id' => 4,  'date_intervention' => '2026-04-15', 'description' => 'Ajout d\'un disque NVMe 2TB',                                  'id_materiel' => 5, 'id_technicien' => 5],
    ['id' => 5,  'date_intervention' => '2026-04-10', 'description' => 'Reset usine et remise en service',                             'id_materiel' => 3, 'id_technicien' => 1],
    ['id' => 6,  'date_intervention' => '2026-04-02', 'description' => 'Inspection mensuelle baie de disques',                         'id_materiel' => 7, 'id_technicien' => 3],
    ['id' => 7,  'date_intervention' => '2026-03-25', 'description' => 'Vérification calibration GPU',                                 'id_materiel' => 10, 'id_technicien' => 4],
    ['id' => 8,  'date_intervention' => '2026-03-18', 'description' => 'Reconfiguration RAID 5 vers RAID 10',                          'id_materiel' => 8, 'id_technicien' => 3],
    ['id' => 9,  'date_intervention' => '2026-03-12', 'description' => 'Remplacement câble fibre',                                     'id_materiel' => 4, 'id_technicien' => 1],
    ['id' => 10, 'date_intervention' => '2026-03-05', 'description' => 'Maintenance préventive trimestrielle',                         'id_materiel' => 11, 'id_technicien' => 5],
];

/* ---------- Helpers ---------- */

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

function asinco_nb_interventions(int $id_materiel): int {
    global $INTERVENTIONS;
    $n = 0;
    foreach ($INTERVENTIONS as $i) if ($i['id_materiel'] === $id_materiel) $n++;
    return $n;
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
        'total'          => count($MATERIELS),
        'service'        => $service,
        'reparation'     => $reparation,
        'declasse'       => $declasse,
        'interventions'  => count($INTERVENTIONS),
    ];
}

/** Échappement court */
function e(?string $s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

/** URL helper — produit un chemin absolu depuis n'importe quelle page de l'app.
 *  Indépendant de la racine d'hébergement (XAMPP alias, /php/, /asinco/, etc.).
 *  Repose sur la structure connue : pages racines à plat + sous-dossiers d'1 niveau. */
function asinco_url(string $path): string {
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $dir    = dirname($script);
    $parent = basename($dir);
    $subdirs = ['materiel', 'maintenance', 'categorie', 'technicien', 'auth', 'partials'];
    // Si on est dans un sous-dossier connu, la racine app = un cran au-dessus
    $base = in_array($parent, $subdirs, true) ? dirname($dir) : $dir;
    $base = rtrim($base, '/');
    return ($base === '' ? '' : $base) . '/' . ltrim($path, '/');
}
