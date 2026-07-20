PRAGMA foreign_keys = ON;

-- ============================
-- ROLES
-- ============================
INSERT INTO roles (idRoles, libelle) VALUES (1, 'Admin');
INSERT INTO roles (idRoles, libelle) VALUES (2, 'Client');


-- ============================
-- OPERATEURS
-- ============================
INSERT INTO operateurs (idOperateurs, nom) VALUES (1, 'Telma');
INSERT INTO operateurs (idOperateurs, nom) VALUES (2, 'Airtel');


-- ============================
-- PREFIXES
-- ============================
INSERT INTO prefixes (idPrefixes, valeur, idOperateurs) VALUES (1, '033', 1);
INSERT INTO prefixes (idPrefixes, valeur, idOperateurs) VALUES (2, '037', 2);


-- ============================
-- TYPES OPERATIONS
-- ============================
INSERT INTO typesOperations (idTypesOperations, libelle)
VALUES (1, 'Depot');

INSERT INTO typesOperations (idTypesOperations, libelle)
VALUES (2, 'Retrait');

INSERT INTO typesOperations (idTypesOperations, libelle)
VALUES (3, 'Transfert');


-- ============================
-- COMMISSIONS
-- Commission gagnée sur les autres opérateurs
-- Calcul : montant * pourcentage / 100
-- ============================

-- Transfert vers Airtel : 2% du montant envoyé
INSERT INTO commissions (idCommissions, pourcentage, idOperateurs)
VALUES (1, 2, 2);



-- ============================
-- UTILISATEURS
-- ============================

-- Admin Telma
INSERT INTO utilisateurs
(idUtilisateurs, numeroTelephone, nom, prenom, idRoles)
VALUES
(1, '0331122233', 'Rakoto', 'Jean', 1);


-- Client Telma
INSERT INTO utilisateurs
(idUtilisateurs, numeroTelephone, nom, prenom, idRoles)
VALUES
(2, '0330011223', 'Rabe', 'Marie', 2);


-- Client Airtel
INSERT INTO utilisateurs
(idUtilisateurs, numeroTelephone, nom, prenom, idRoles)
VALUES
(3, '0378899900', 'Randria', 'Anja', 2);

INSERT INTO utilisateurs 
(idUtilisateurs, numeroTelephone, nom, prenom, idRoles) 
VALUES 
(4, '0331122334', 'Rakoto', 'Jean', 2);

INSERT INTO utilisateurs (idUtilisateurs, numeroTelephone, nom, prenom, idRoles) VALUES 
(5, '0332233445', 'Andria', 'Tahina', 2),
(6, '0333344556', 'Razafy', 'Valisoa', 2),
(7, '0334455667', 'Ramanandraibe', 'Fitiavana', 2);



-- ============================
-- FRAIS DEPOT
-- ============================

INSERT INTO frais
(montantMin, montantMax, valeurFrais, idTypesOperations)
VALUES
(0, 999999999, 0, 1);



-- ============================
-- FRAIS RETRAIT
-- ============================

INSERT INTO frais
(montantMin, montantMax, valeurFrais, idTypesOperations)
VALUES
(100,5000,100,2);

INSERT INTO frais
(montantMin, montantMax, valeurFrais, idTypesOperations)
VALUES
(5001,15000,300,2);

INSERT INTO frais
(montantMin, montantMax, valeurFrais, idTypesOperations)
VALUES
(15001,50000,700,2);



-- ============================
-- FRAIS TRANSFERT
-- ============================

INSERT INTO frais
(montantMin, montantMax, valeurFrais, idTypesOperations)
VALUES
(100,5000,50,3);

INSERT INTO frais
(montantMin, montantMax, valeurFrais, idTypesOperations)
VALUES
(5001,15000,150,3);

INSERT INTO frais
(montantMin, montantMax, valeurFrais, idTypesOperations)
VALUES
(15001,50000,400,3);



-- ============================
-- OPERATIONS
-- ============================

-- Dépôt client Telma
-- Solde Marie +20000
INSERT INTO operations
(montant,idOperateurs,fraisAppliques,dateOperation,idTypesOperations,idSource,idDestinataire)
VALUES
(20000,1,0,'2026-07-20 08:00:00',1,NULL,2);



-- Retrait Marie
-- Frais = 100
INSERT INTO operations
(montant,idOperateurs,fraisAppliques,dateOperation,idTypesOperations,idSource,idDestinataire)
VALUES
(5000,1,100,'2026-07-20 09:00:00',2,2,NULL);



-- Dépôt client Airtel
INSERT INTO operations
(montant,idOperateurs,fraisAppliques,dateOperation,idTypesOperations,idSource,idDestinataire)
VALUES
(30000,2,0,'2026-07-20 09:30:00',1,NULL,3);



-- Transfert Telma -> Telma
-- Gain = frais (50 Ar)
INSERT INTO operations
(montant,idOperateurs,fraisAppliques,dateOperation,idTypesOperations,idSource,idDestinataire)
VALUES
(4000,1,50,'2026-07-20 10:00:00',3,2,2);



-- Transfert Telma -> Airtel
-- Montant 10000
-- Commission Airtel = 10000 * 2% = 200 Ar
INSERT INTO operations
(montant,idOperateurs,fraisAppliques,dateOperation,idTypesOperations,idSource,idDestinataire)
VALUES
(10000,1,150,'2026-07-20 11:00:00',3,2,3);

