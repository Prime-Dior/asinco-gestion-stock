<?php
/**
 * ASINCO — Traitement POST : Suppression d'un matériel
 * ─────────────────────────────────────────────────────────
 *  Copier dans : php/materiel/actions/supprimer_materiel.php
 * ─────────────────────────────────────────────────────────
 */
require_once __DIR__ . '/../../config/connexion.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../liste.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['flash'] = ['type' => 'danger', 'msg' => 'Identifiant invalide.'];
    header('Location: ../liste.php');
    exit;
}

try {
    // Supprimer d'abord les interventions liées (contrainte FK)
    asinco_execute(
        'DELETE FROM INTERVENTION WHERE ID_MATERIEL = :id',
        [':id' => $id]
    );

    // Supprimer le matériel
    $ok = asinco_execute(
        'DELETE FROM MATERIEL WHERE ID_MATERIEL = :id',
        [':id' => $id]
    );

    if ($ok) {
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Matériel supprimé avec succès.'];
    } else {
        $_SESSION['flash'] = ['type' => 'warning', 'msg' => 'Matériel introuvable.'];
    }

} catch (RuntimeException $e) {
    $_SESSION['flash'] = ['type' => 'danger', 'msg' => 'Erreur Oracle : ' . $e->getMessage()];
}

header('Location: ../liste.php');
exit;
