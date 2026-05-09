<?php
/**
 * ASINCO — Traitement POST : Modification d'un matériel
 * ─────────────────────────────────────────────────────────
 *  Copier dans : php/materiel/actions/modifier_materiel.php
 * ─────────────────────────────────────────────────────────
 */
require_once __DIR__ . '/../../config/connexion.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../liste.php');
    exit;
}

$id          = (int)($_POST['id']          ?? 0);
$reference   = trim($_POST['reference']    ?? '');
$designation = trim($_POST['designation']  ?? '');
$date_achat  = trim($_POST['date_achat']   ?? '');
$categorie   = (int)($_POST['categorie']   ?? 0);
$etat        = trim($_POST['etat']         ?? '');

$errors = [];
if ($id <= 0)            $errors[] = 'Identifiant matériel invalide.';
if ($reference === '')   $errors[] = 'La référence est obligatoire.';
if ($designation === '') $errors[] = 'La désignation est obligatoire.';
if ($date_achat === '')  $errors[] = 'La date d\'achat est obligatoire.';
if ($categorie <= 0)     $errors[] = 'Catégorie invalide.';
if (!in_array($etat, ['En service', 'En réparation', 'Déclassé'], true)) {
    $errors[] = 'État invalide.';
}

if ($errors) {
    $_SESSION['flash'] = ['type' => 'danger', 'msg' => implode('<br>', $errors)];
    header("Location: ../modification.php?id=$id");
    exit;
}

try {
    // Vérifie unicité référence (sauf pour ce matériel)
    $check = asinco_query(
        'SELECT COUNT(*) AS CNT FROM MATERIEL WHERE REFERENCE = :ref AND ID_MATERIEL <> :id',
        [':ref' => $reference, ':id' => $id]
    );
    if ((int)($check[0]['CNT'] ?? 0) > 0) {
        $_SESSION['flash'] = ['type' => 'danger', 'msg' => 'Cette référence est déjà utilisée par un autre matériel.'];
        header("Location: ../modification.php?id=$id");
        exit;
    }

    $sql = "UPDATE MATERIEL
            SET REFERENCE    = :ref,
                DESIGNATION  = :des,
                DATE_ACHAT   = TO_DATE(:dat,'YYYY-MM-DD'),
                ETAT         = :eta,
                ID_CATEGORIE = :cat
            WHERE ID_MATERIEL = :id";

    $ok = asinco_execute($sql, [
        ':ref' => $reference,
        ':des' => $designation,
        ':dat' => $date_achat,
        ':eta' => $etat,
        ':cat' => $categorie,
        ':id'  => $id,
    ]);

    if ($ok) {
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Matériel modifié avec succès.'];
        header('Location: ../liste.php');
    } else {
        throw new RuntimeException("La mise à jour a échoué.");
    }

} catch (RuntimeException $e) {
    $_SESSION['flash'] = ['type' => 'danger', 'msg' => 'Erreur Oracle : ' . $e->getMessage()];
    header("Location: ../modification.php?id=$id");
}
exit;
