<?php
/**
 * ASINCO — Traitement POST : Ajout d'un matériel
 * ─────────────────────────────────────────────────────────
 *  Appelé par php/materiel/ajout.php (action="actions/ajout_materiel.php")
 *  Copier dans : php/materiel/actions/ajout_materiel.php
 * ─────────────────────────────────────────────────────────
 */
require_once __DIR__ . '/../../config/connexion.php';

session_start();

// ── Sécurité : POST uniquement ────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../liste.php');
    exit;
}

// ── Récupération et nettoyage des données ─────────────────
$reference   = trim($_POST['reference']   ?? '');
$designation = trim($_POST['designation'] ?? '');
$date_achat  = trim($_POST['date_achat']  ?? '');
$categorie   = (int)($_POST['categorie']  ?? 0);
$etat        = trim($_POST['etat']        ?? 'En service');

// ── Validation ────────────────────────────────────────────
$errors = [];

if ($reference === '' || !preg_match('/^[A-Z0-9\-]{3,50}$/', $reference)) {
    $errors[] = 'La référence est invalide (majuscules, chiffres, tirets, 3–50 caractères).';
}
if ($designation === '') {
    $errors[] = 'La désignation est obligatoire.';
}
if ($date_achat === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_achat)) {
    $errors[] = 'La date d\'achat est invalide.';
}
if ($categorie <= 0) {
    $errors[] = 'Veuillez choisir une catégorie.';
}
if (!in_array($etat, ['En service', 'En réparation', 'Déclassé'], true)) {
    $etat = 'En service';
}

if ($errors) {
    $_SESSION['flash'] = ['type' => 'danger', 'msg' => implode('<br>', $errors)];
    header('Location: ../ajout.php');
    exit;
}

// ── Insertion Oracle ──────────────────────────────────────
try {
    $conn = asinco_db();

    // Vérifier que la référence n'existe pas déjà
    $check = asinco_query(
        'SELECT COUNT(*) AS CNT FROM MATERIEL WHERE REFERENCE = :ref',
        [':ref' => $reference]
    );
    if ((int)($check[0]['CNT'] ?? 0) > 0) {
        $_SESSION['flash'] = ['type' => 'danger', 'msg' => "La référence <strong>" . htmlspecialchars($reference, ENT_QUOTES) . "</strong> existe déjà dans le parc."];
        header('Location: ../ajout.php');
        exit;
    }

    $sql = "INSERT INTO MATERIEL (ID_MATERIEL, REFERENCE, DESIGNATION, DATE_ACHAT, ETAT, ID_CATEGORIE)
            VALUES (SEQ_MATERIEL.NEXTVAL, :ref, :des, TO_DATE(:dat,'YYYY-MM-DD'), :eta, :cat)";

    $ok = asinco_execute($sql, [
        ':ref' => $reference,
        ':des' => $designation,
        ':dat' => $date_achat,
        ':eta' => $etat,
        ':cat' => $categorie,
    ]);

    if ($ok) {
        $_SESSION['flash'] = ['type' => 'success', 'msg' => "Matériel <strong>" . htmlspecialchars($reference, ENT_QUOTES) . "</strong> ajouté avec succès."];
        header('Location: ../liste.php');
    } else {
        throw new RuntimeException("L'insertion a échoué sans erreur explicite.");
    }

} catch (RuntimeException $e) {
    $_SESSION['flash'] = ['type' => 'danger', 'msg' => 'Erreur Oracle : ' . $e->getMessage()];
    header('Location: ../ajout.php');
}
exit;
