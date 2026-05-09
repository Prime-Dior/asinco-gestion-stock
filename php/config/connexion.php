<?php
/**
 * ASINCO — Connexion Oracle via OCI8
 * ─────────────────────────────────────────────────────────
 */

define('ORA_USER',     'ASINCO');           // Nom d'utilisateur Oracle
define('ORA_PASSWORD', 'asinco123');        // Mot de passe Oracle
define('ORA_DSN',      'localhost/XE');     // host/SID  — ex: localhost/ORCL  ou  localhost/XE

/**
 * Ouvre et retourne une connexion OCI8.
 * Lève une exception si la connexion échoue (évite les pages blanches silencieuses).
 *
 * @return resource  Ressource OCI8 valide
 * @throws RuntimeException
 */
function asinco_db(): mixed
{
    static $conn = null;          // singleton : une seule connexion par requête HTTP

    if ($conn !== null) {
        return $conn;
    }

    $conn = @oci_connect(ORA_USER, ORA_PASSWORD, ORA_DSN, 'AL32UTF8');

    if (!$conn) {
        $err = oci_error();
        $msg = $err ? $err['message'] : 'Connexion Oracle impossible.';
        // En production, logger $msg sans l'afficher
        throw new RuntimeException('Erreur BDD : ' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'));
    }

    return $conn;
}

/**
 * Helper : exécute une requête SELECT et retourne un tableau associatif.
 *
 * Exemple :
 *   $rows = asinco_query("SELECT * FROM MATERIEL WHERE ETAT = :etat", [':etat' => 'En service']);
 *
 * @param  string $sql    Requête SQL avec bind variables (:nom)
 * @param  array  $binds  Tableau [':variable' => valeur]
 * @return array          Tableau de lignes associatives (MAJUSCULE pour les clés Oracle)
 */
function asinco_query(string $sql, array $binds = []): array
{
    $conn = asinco_db();
    $stmt = oci_parse($conn, $sql);

    foreach ($binds as $key => $val) {
        oci_bind_by_name($stmt, $key, $binds[$key]);
    }

    oci_execute($stmt, OCI_DEFAULT);

    $rows = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $rows[] = $row;
    }

    oci_free_statement($stmt);
    return $rows;
}

/**
 * Helper : exécute un INSERT / UPDATE / DELETE et commite.
 *
 * @param  string $sql
 * @param  array  $binds
 * @return bool
 */
function asinco_execute(string $sql, array $binds = []): bool
{
    $conn = asinco_db();
    $stmt = oci_parse($conn, $sql);

    foreach ($binds as $key => $val) {
        oci_bind_by_name($stmt, $key, $binds[$key]);
    }

    $ok = oci_execute($stmt, OCI_COMMIT_ON_SUCCESS);
    oci_free_statement($stmt);
    return (bool)$ok;
}

/**
 * Helper : appelle une procédure stockée Oracle.
 *
 * Exemple :
 *   asinco_call_procedure('PRC_AJOUT_INTERVENTION', [
 *       ':p_date'  => '2026-05-08',
 *       ':p_desc'  => 'Remplacement disque',
 *       ':p_mat'   => 3,
 *       ':p_tech'  => 1,
 *   ]);
 *
 * @param  string $procedure_name   Nom exact de la procédure Oracle
 * @param  array  $binds            Bind variables nommés
 * @throws RuntimeException         Si Oracle renvoie une erreur
 */
function asinco_call_procedure(string $procedure_name, array $binds = []): void
{
    $conn = asinco_db();

    // Construire l'appel : BEGIN PROC(:a, :b, ...); END;
    $params = implode(', ', array_keys($binds));
    $sql    = "BEGIN {$procedure_name}({$params}); END;";

    $stmt = oci_parse($conn, $sql);

    foreach ($binds as $key => $val) {
        oci_bind_by_name($stmt, $key, $binds[$key]);
    }

    $ok = oci_execute($stmt, OCI_COMMIT_ON_SUCCESS);

    if (!$ok) {
        $err = oci_error($stmt);
        oci_free_statement($stmt);
        throw new RuntimeException('Erreur procédure ' . $procedure_name . ' : ' . htmlspecialchars($err['message'] ?? '', ENT_QUOTES, 'UTF-8'));
    }

    oci_free_statement($stmt);
}

/**
 * Helper : appelle FNC_NB_INTERVENTIONS (fonction Oracle → valeur scalaire).
 *
 * @param  int $id_materiel
 * @return int
 */
function asinco_fnc_nb_interventions(int $id_materiel): int
{
    $conn = asinco_db();
    $sql  = 'BEGIN :result := FNC_NB_INTERVENTIONS(:p_id); END;';
    $stmt = oci_parse($conn, $sql);

    $result = 0;
    oci_bind_by_name($stmt, ':result', $result, 10, SQLT_INT);
    oci_bind_by_name($stmt, ':p_id',   $id_materiel);

    oci_execute($stmt, OCI_DEFAULT);
    oci_free_statement($stmt);

    return (int)$result;
}
