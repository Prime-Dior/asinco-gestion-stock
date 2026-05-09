<?php
/**
 * ASINCO — Traitement POST : Nouvelle intervention
 * ─────────────────────────────────────────────────────────
 *  Appelle PRC_AJOUT_INTERVENTION (procédure Oracle)
 *  Copier dans : php/maintenance/actions/ajout_intervention.php
 * ─────────────────────────────────────────────────────────
 */
require_once __DIR__ . '/../../config/connexion.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../liste.php');
    exit;
}

$id_materiel       = (int)trim($_POST['materiel']           ?? 0);
$id_technicien     = (int)trim($_POST['technicien']         ?? 0);
$date_intervention = trim($_POST['date_intervention']       ?? '');
$description       = trim($_POST['description']             ?? '');

// ── Validation ────────────────────────────────────────────
$errors = [];
if ($id_materiel <= 0)         $errors[] = 'Veuillez choisir un matériel.';
if ($id_technicien <= 0)       $errors[] = 'Veuillez choisir un technicien.';
if ($date_intervention === '')  $errors[] = 'La date d\'intervention est obligatoire.';
if (strlen($description) < 10) $errors[] = 'La description doit faire au moins 10 caractères.';

if ($errors) {
    $_SESSION['flash'] = ['type' => 'danger', 'msg' => implode('<br>', $errors)];
    header("Location: ../formulaire.php?materiel=$id_materiel");
    exit;
}

// ── Appel de la procédure Oracle ──────────────────────────
try {
    asinco_call_procedure('PRC_AJOUT_INTERVENTION', [
        ':p_date_intervention' => $date_intervention,
        ':p_description'       => $description,
        ':p_id_materiel'       => $id_materiel,
        ':p_id_technicien'     => $id_technicien,
    ]);

    $_SESSION['flash'] = [
        'type' => 'success',
        'msg'  => 'Intervention enregistrée. Le matériel est maintenant <strong>En réparation</strong>.'
    ];
    header('Location: ../liste.php');

} catch (RuntimeException $e) {
    // Oracle renvoie l'erreur de PRC_AJOUT_INTERVENTION (ex: matériel inexistant)
    $_SESSION['flash'] = ['type' => 'danger', 'msg' => 'Erreur Oracle : ' . $e->getMessage()];
    header("Location: ../formulaire.php?materiel=$id_materiel");
}
exit;
