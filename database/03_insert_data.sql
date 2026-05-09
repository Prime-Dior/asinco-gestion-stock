-- ============================================================
--  ASINCO — Script 03 : Données de test
--  Groupe 1 · Projet GL/IM
--  Exécuter EN TROISIÈME (après 02_plsql.sql)
-- ============================================================

-- ============================================================
--  CATÉGORIES (3 minimum)
-- ============================================================
INSERT INTO CATEGORIE (ID_CATEGORIE, LIBELLE, DESCRIPTION)
VALUES (SEQ_CATEGORIE.NEXTVAL, 'Réseau', 'Switchs, routeurs, points d''accès Wi-Fi');

INSERT INTO CATEGORIE (ID_CATEGORIE, LIBELLE, DESCRIPTION)
VALUES (SEQ_CATEGORIE.NEXTVAL, 'Stockage', 'Serveurs de stockage, NAS, baies disques');

INSERT INTO CATEGORIE (ID_CATEGORIE, LIBELLE, DESCRIPTION)
VALUES (SEQ_CATEGORIE.NEXTVAL, 'Calcul', 'Serveurs de calcul, GPU, workstations');

-- ============================================================
--  TECHNICIENS (5 techniciens)
-- ============================================================
INSERT INTO TECHNICIEN (ID_TECHNICIEN, NOM, PRENOM, SPECIALITE)
VALUES (SEQ_TECHNICIEN.NEXTVAL, 'KOUASSI', 'Mathieu', 'Réseau');

INSERT INTO TECHNICIEN (ID_TECHNICIEN, NOM, PRENOM, SPECIALITE)
VALUES (SEQ_TECHNICIEN.NEXTVAL, 'AHOUANSOU', 'Léonie', 'Systèmes');

INSERT INTO TECHNICIEN (ID_TECHNICIEN, NOM, PRENOM, SPECIALITE)
VALUES (SEQ_TECHNICIEN.NEXTVAL, 'TONOUKOUIN', 'Fabrice', 'Stockage');

INSERT INTO TECHNICIEN (ID_TECHNICIEN, NOM, PRENOM, SPECIALITE)
VALUES (SEQ_TECHNICIEN.NEXTVAL, 'AGBODJAN', 'Nadège', 'Calcul / GPU');

INSERT INTO TECHNICIEN (ID_TECHNICIEN, NOM, PRENOM, SPECIALITE)
VALUES (SEQ_TECHNICIEN.NEXTVAL, 'DOSSOU', 'Yannick', 'Polyvalent');

-- ============================================================
--  MATÉRIELS (12 équipements)
-- ============================================================
-- Catégorie Réseau (ID=1)
INSERT INTO MATERIEL (ID_MATERIEL, REFERENCE, DESIGNATION, DATE_ACHAT, ETAT, ID_CATEGORIE)
VALUES (SEQ_MATERIEL.NEXTVAL, 'SW-CSC-2960-01', 'Switch Cisco Catalyst 2960',
        TO_DATE('2023-04-12','YYYY-MM-DD'), 'En service', 1);

INSERT INTO MATERIEL (ID_MATERIEL, REFERENCE, DESIGNATION, DATE_ACHAT, ETAT, ID_CATEGORIE)
VALUES (SEQ_MATERIEL.NEXTVAL, 'SW-CSC-2960-02', 'Switch Cisco Catalyst 2960',
        TO_DATE('2023-04-12','YYYY-MM-DD'), 'En réparation', 1);

INSERT INTO MATERIEL (ID_MATERIEL, REFERENCE, DESIGNATION, DATE_ACHAT, ETAT, ID_CATEGORIE)
VALUES (SEQ_MATERIEL.NEXTVAL, 'RT-MK-CCR1009', 'Routeur MikroTik CCR1009',
        TO_DATE('2022-09-03','YYYY-MM-DD'), 'En service', 1);

INSERT INTO MATERIEL (ID_MATERIEL, REFERENCE, DESIGNATION, DATE_ACHAT, ETAT, ID_CATEGORIE)
VALUES (SEQ_MATERIEL.NEXTVAL, 'AP-UBQ-U6PRO-01', 'Borne Wi-Fi UniFi U6 Pro',
        TO_DATE('2024-01-22','YYYY-MM-DD'), 'En service', 1);

-- Catégorie Calcul (ID=3)
INSERT INTO MATERIEL (ID_MATERIEL, REFERENCE, DESIGNATION, DATE_ACHAT, ETAT, ID_CATEGORIE)
VALUES (SEQ_MATERIEL.NEXTVAL, 'SRV-DELL-R740', 'Dell PowerEdge R740',
        TO_DATE('2021-06-15','YYYY-MM-DD'), 'En service', 3);

INSERT INTO MATERIEL (ID_MATERIEL, REFERENCE, DESIGNATION, DATE_ACHAT, ETAT, ID_CATEGORIE)
VALUES (SEQ_MATERIEL.NEXTVAL, 'SRV-HPE-DL380', 'HPE ProLiant DL380 Gen10',
        TO_DATE('2020-11-08','YYYY-MM-DD'), 'En réparation', 3);

-- Catégorie Stockage (ID=2)
INSERT INTO MATERIEL (ID_MATERIEL, REFERENCE, DESIGNATION, DATE_ACHAT, ETAT, ID_CATEGORIE)
VALUES (SEQ_MATERIEL.NEXTVAL, 'NAS-SYNO-RS820', 'Synology RackStation RS820+',
        TO_DATE('2022-03-30','YYYY-MM-DD'), 'En service', 2);

INSERT INTO MATERIEL (ID_MATERIEL, REFERENCE, DESIGNATION, DATE_ACHAT, ETAT, ID_CATEGORIE)
VALUES (SEQ_MATERIEL.NEXTVAL, 'NAS-QNAP-TS873', 'QNAP TS-873A',
        TO_DATE('2023-07-19','YYYY-MM-DD'), 'En service', 2);

INSERT INTO MATERIEL (ID_MATERIEL, REFERENCE, DESIGNATION, DATE_ACHAT, ETAT, ID_CATEGORIE)
VALUES (SEQ_MATERIEL.NEXTVAL, 'BAY-NETAPP-FAS', 'NetApp FAS2750',
        TO_DATE('2019-02-11','YYYY-MM-DD'), 'Déclassé', 2);

-- Calcul suite
INSERT INTO MATERIEL (ID_MATERIEL, REFERENCE, DESIGNATION, DATE_ACHAT, ETAT, ID_CATEGORIE)
VALUES (SEQ_MATERIEL.NEXTVAL, 'GPU-NV-A100-01', 'NVIDIA A100 80GB',
        TO_DATE('2024-05-04','YYYY-MM-DD'), 'En service', 3);

INSERT INTO MATERIEL (ID_MATERIEL, REFERENCE, DESIGNATION, DATE_ACHAT, ETAT, ID_CATEGORIE)
VALUES (SEQ_MATERIEL.NEXTVAL, 'WS-LEN-P620', 'Lenovo ThinkStation P620',
        TO_DATE('2023-12-01','YYYY-MM-DD'), 'En service', 3);

INSERT INTO MATERIEL (ID_MATERIEL, REFERENCE, DESIGNATION, DATE_ACHAT, ETAT, ID_CATEGORIE)
VALUES (SEQ_MATERIEL.NEXTVAL, 'SW-HP-1950-01', 'HP Aruba 1950 Switch',
        TO_DATE('2021-08-25','YYYY-MM-DD'), 'Déclassé', 1);

-- ============================================================
--  INTERVENTIONS via la procédure PRC_AJOUT_INTERVENTION
--  (les matériels concernés passent automatiquement "En réparation")
-- ============================================================
BEGIN
    PRC_AJOUT_INTERVENTION(
        TO_DATE('2026-05-02','YYYY-MM-DD'),
        'Remplacement de l''alimentation principale après surtension',
        6, 2
    );
END;
/
BEGIN
    PRC_AJOUT_INTERVENTION(
        TO_DATE('2026-04-28','YYYY-MM-DD'),
        'Mise à jour du firmware et reconfiguration VLAN',
        1, 1
    );
END;
/
BEGIN
    PRC_AJOUT_INTERVENTION(
        TO_DATE('2026-04-21','YYYY-MM-DD'),
        'Diagnostic ventilateur défectueux',
        2, 1
    );
END;
/
BEGIN
    PRC_AJOUT_INTERVENTION(
        TO_DATE('2026-04-15','YYYY-MM-DD'),
        'Ajout d''un disque NVMe 2TB',
        5, 5
    );
END;
/
BEGIN
    PRC_AJOUT_INTERVENTION(
        TO_DATE('2026-04-10','YYYY-MM-DD'),
        'Reset usine et remise en service',
        3, 1
    );
END;
/
BEGIN
    PRC_AJOUT_INTERVENTION(
        TO_DATE('2026-04-02','YYYY-MM-DD'),
        'Inspection mensuelle baie de disques',
        7, 3
    );
END;
/
BEGIN
    PRC_AJOUT_INTERVENTION(
        TO_DATE('2026-03-25','YYYY-MM-DD'),
        'Vérification calibration GPU',
        10, 4
    );
END;
/
BEGIN
    PRC_AJOUT_INTERVENTION(
        TO_DATE('2026-03-18','YYYY-MM-DD'),
        'Reconfiguration RAID 5 vers RAID 10',
        8, 3
    );
END;
/
BEGIN
    PRC_AJOUT_INTERVENTION(
        TO_DATE('2026-03-12','YYYY-MM-DD'),
        'Remplacement câble fibre',
        4, 1
    );
END;
/
BEGIN
    PRC_AJOUT_INTERVENTION(
        TO_DATE('2026-03-05','YYYY-MM-DD'),
        'Maintenance préventive trimestrielle',
        11, 5
    );
END;
/

COMMIT;

-- ============================================================
--  VÉRIFICATION FINALE
-- ============================================================
SELECT 'CATEGORIE'   AS TABLE_NOM, COUNT(*) AS TOTAL FROM CATEGORIE
UNION ALL
SELECT 'TECHNICIEN', COUNT(*) FROM TECHNICIEN
UNION ALL
SELECT 'MATERIEL',   COUNT(*) FROM MATERIEL
UNION ALL
SELECT 'INTERVENTION', COUNT(*) FROM INTERVENTION;
