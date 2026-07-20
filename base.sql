PRAGMA foreign_keys = ON;

CREATE TABLE prefixes (
    idPrefixes INTEGER PRIMARY KEY,
    valeur TEXT NOT NULL UNIQUE, 
    operateur TEXT NOT NULL     
);

CREATE TABLE typesOperations (
    idTypesOperations INTEGER PRIMARY KEY,
    libelle TEXT NOT NULL UNIQUE 
);

CREATE TABLE frais (
    idFrais INTEGER PRIMARY KEY,
    montantMin INTEGER NOT NULL,            
    montantMax INTEGER NOT NULL,            
    valeurFrais INTEGER NOT NULL,           
    idTypesOperations INTEGER,
    FOREIGN KEY (idTypesOperations) REFERENCES typesOperations(idTypesOperations)
);

CREATE TABLE roles (
    idRoles INTEGER PRIMARY KEY,
    libelle TEXT NOT NULL UNIQUE 
);

CREATE TABLE utilisateurs (
    idUtilisateurs INTEGER PRIMARY KEY,
    numeroTelephone TEXT NOT NULL UNIQUE, 
    nom TEXT NOT NULL,
    prenom TEXT NOT NULL,
    idRoles INTEGER,
    FOREIGN KEY (idRoles) REFERENCES roles(idRoles)
);

CREATE TABLE operations (
    idOperations INTEGER PRIMARY KEY,
    montant INTEGER NOT NULL,         
    fraisAppliques INTEGER NOT NULL,  
    dateOperation TEXT NOT NULL,       
    idTypesOperations INTEGER,
    idSource INTEGER,
    idDestinataire INTEGER,
    FOREIGN KEY (idTypesOperations) REFERENCES typesOperations(idTypesOperations),
    FOREIGN KEY (idSource) REFERENCES utilisateurs(idUtilisateurs),
    FOREIGN KEY (idDestinataire) REFERENCES utilisateurs(idUtilisateurs)
);

-- 1. Activer le support des clés étrangères
PRAGMA foreign_keys = ON;

-- 2. Insérer uniquement les deux rôles (SQLite va créer idRoles = 1 pour Admin et 2 pour Client)
INSERT INTO roles (libelle) VALUES ('Admin');
INSERT INTO roles (libelle) VALUES ('Client');

-- 3. Insérer des préfixes (exemples d'opérateurs à Madagascar comme Telma, Orange, Airtel)
INSERT INTO prefixes (valeur, operateur) VALUES ('033', 'Telma');
INSERT INTO prefixes (valeur, operateur) VALUES ('037', 'Airtel');

-- 4. Insérer tes premiers utilisateurs de test
-- Un administrateur (idRoles = 1)
INSERT INTO utilisateurs (numeroTelephone, nom, prenom, idRoles) 
VALUES ('0331122233', 'Rakoto', 'Jean', 1);

-- Un client lambda (idRoles = 2)
INSERT INTO utilisateurs (numeroTelephone, nom, prenom, idRoles) 
VALUES ('0378899900', 'Randria', 'Anja', 2);

-- Un deuxième client (idRoles = 2)
INSERT INTO utilisateurs (numeroTelephone, nom, prenom, idRoles) 
VALUES ('0330011223', 'Rabe', 'Marie', 2);

INSERT INTO typesOperations (libelle) VALUES ('Depot');
INSERT INTO typesOperations (libelle) VALUES ('Retrait');
INSERT INTO typesOperations (libelle) VALUES ('Transfert');

-- 1. Depot de 20 000 pour Randria (id 2)
INSERT INTO operations (montant, fraisAppliques, dateOperation, idTypesOperations, idSource, idDestinataire)
VALUES (20000, 0, '2026-07-20 08:00:00', 1, NULL, 2);

-- 2. Retrait de 5 000, frais 200, pour Randria (id 2)
INSERT INTO operations (montant, fraisAppliques, dateOperation, idTypesOperations, idSource, idDestinataire)
VALUES (5000, 200, '2026-07-20 09:00:00', 2, 2, NULL);

-- 3. Depot de 15 000 pour Rabe (id 3)
INSERT INTO operations (montant, fraisAppliques, dateOperation, idTypesOperations, idSource, idDestinataire)
VALUES (15000, 0, '2026-07-20 09:30:00', 1, NULL, 3);

-- 4. Transfert de Rabe (id 3) vers Randria (id 2) : 4 000, frais 100
INSERT INTO operations (montant, fraisAppliques, dateOperation, idTypesOperations, idSource, idDestinataire)
VALUES (4000, 100, '2026-07-20 10:00:00', 3, 3, 2);

-- 5. Transfert de Randria (id 2) vers Rabe (id 3) : 2 000, frais 50
INSERT INTO operations (montant, fraisAppliques, dateOperation, idTypesOperations, idSource, idDestinataire)
VALUES (2000, 50, '2026-07-20 11:00:00', 3, 2, 3);

-- ============================
-- FRAIS - DEPOT (idTypesOperations = 1)
-- En général gratuit pour inciter les gens à alimenter leur compte
-- ============================
INSERT INTO frais (montantMin, montantMax, valeurFrais, idTypesOperations) VALUES (0, 999999999, 0, 1);

-- ============================
-- FRAIS - RETRAIT (idTypesOperations = 2)
-- Barème par tranche de montant
-- ============================
INSERT INTO frais (montantMin, montantMax, valeurFrais, idTypesOperations) VALUES (100, 5000, 100, 2);
INSERT INTO frais (montantMin, montantMax, valeurFrais, idTypesOperations) VALUES (5001, 15000, 300, 2);
INSERT INTO frais (montantMin, montantMax, valeurFrais, idTypesOperations) VALUES (15001, 50000, 700, 2);
INSERT INTO frais (montantMin, montantMax, valeurFrais, idTypesOperations) VALUES (50001, 100000, 1200, 2);
INSERT INTO frais (montantMin, montantMax, valeurFrais, idTypesOperations) VALUES (100001, 300000, 2500, 2);
INSERT INTO frais (montantMin, montantMax, valeurFrais, idTypesOperations) VALUES (300001, 999999999, 5000, 2);

-- ============================
-- FRAIS - TRANSFERT (idTypesOperations = 3)
-- Généralement moins cher que le retrait
-- ============================
INSERT INTO frais (montantMin, montantMax, valeurFrais, idTypesOperations) VALUES (100, 5000, 50, 3);
INSERT INTO frais (montantMin, montantMax, valeurFrais, idTypesOperations) VALUES (5001, 15000, 150, 3);
INSERT INTO frais (montantMin, montantMax, valeurFrais, idTypesOperations) VALUES (15001, 50000, 400, 3);
INSERT INTO frais (montantMin, montantMax, valeurFrais, idTypesOperations) VALUES (50001, 100000, 800, 3);
INSERT INTO frais (montantMin, montantMax, valeurFrais, idTypesOperations) VALUES (100001, 300000, 1500, 3);
INSERT INTO frais (montantMin, montantMax, valeurFrais, idTypesOperations) VALUES (300001, 999999999, 3000, 3);