-- ============================================================
--  ASINCO — Script 02 : Logique métier PL/SQL
--  Groupe 1 · Projet GL/IM
--  Exécuter EN DEUXIÈME (après 01_create_tables.sql)
-- ============================================================

-- ============================================================
--  PROCÉDURE : PRC_AJOUT_INTERVENTION
--  Insère une nouvelle intervention ET met l'état du matériel
--  à 'En réparation' de manière atomique.
-- ============================================================
CREATE OR REPLACE PROCEDURE PRC_AJOUT_INTERVENTION (
    p_date_intervention IN DATE,
    p_description       IN VARCHAR2,
    p_id_materiel       IN NUMBER,
    p_id_technicien     IN NUMBER
) AS
    v_count_mat  NUMBER;
    v_count_tech NUMBER;
BEGIN
    -- Vérifier que le matériel existe
    SELECT COUNT(*) INTO v_count_mat
    FROM MATERIEL
    WHERE ID_MATERIEL = p_id_materiel;

    IF v_count_mat = 0 THEN
        RAISE_APPLICATION_ERROR(-20001, 'Matériel introuvable : ID = ' || p_id_materiel);
    END IF;

    -- Vérifier que le technicien existe
    SELECT COUNT(*) INTO v_count_tech
    FROM TECHNICIEN
    WHERE ID_TECHNICIEN = p_id_technicien;

    IF v_count_tech = 0 THEN
        RAISE_APPLICATION_ERROR(-20002, 'Technicien introuvable : ID = ' || p_id_technicien);
    END IF;

    -- Insérer l'intervention
    INSERT INTO INTERVENTION (
        ID_INTERVENTION,
        DATE_INTERVENTION,
        DESCRIPTION,
        ID_MATERIEL,
        ID_TECHNICIEN
    ) VALUES (
        SEQ_INTERVENTION.NEXTVAL,
        p_date_intervention,
        p_description,
        p_id_materiel,
        p_id_technicien
    );

    -- Mettre à jour l'état du matériel ? En réparation
    UPDATE MATERIEL
    SET ETAT = 'En réparation'
    WHERE ID_MATERIEL = p_id_materiel;

    COMMIT;

    DBMS_OUTPUT.PUT_LINE('Intervention enregistrée. Matériel ID=' || p_id_materiel || ' ? En réparation.');

EXCEPTION
    WHEN OTHERS THEN
        ROLLBACK;
        RAISE;
END PRC_AJOUT_INTERVENTION;
/

-- ============================================================
--  FONCTION : FNC_NB_INTERVENTIONS
--  Retourne le nombre total d'interventions pour un matériel.
-- ============================================================
CREATE OR REPLACE FUNCTION FNC_NB_INTERVENTIONS (
    p_id_materiel IN NUMBER
) RETURN NUMBER AS
    v_nb NUMBER;
BEGIN
    SELECT COUNT(*)
    INTO v_nb
    FROM INTERVENTION
    WHERE ID_MATERIEL = p_id_materiel;

    RETURN v_nb;
END FNC_NB_INTERVENTIONS;
/

-- ============================================================
--  TEST RAPIDE (à exécuter avec SET SERVEROUTPUT ON)
-- ============================================================
-- SET SERVEROUTPUT ON;
-- EXEC PRC_AJOUT_INTERVENTION(SYSDATE, 'Test procédure', 1, 1);
-- SELECT FNC_NB_INTERVENTIONS(1) AS NB_INTER FROM DUAL;

SELECT 'Procédures et fonctions créées avec succès !' AS STATUT FROM DUAL;
