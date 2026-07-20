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