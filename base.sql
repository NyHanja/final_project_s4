PRAGMA foreign_keys = ON;

CREATE TABLE operateurs (
    idOperateurs INTEGER PRIMARY KEY,
    nom TEXT NOT NULL UNIQUE
);

CREATE TABLE prefixes (
    idPrefixes INTEGER PRIMARY KEY,
    valeur TEXT NOT NULL UNIQUE, 
    idOperateurs INTEGER,
    FOREIGN KEY (idOperateurs) REFERENCES operateurs(idOperateurs) 
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
    idOperateurs INTEGER NOT NULL,         
    fraisAppliques INTEGER NOT NULL,  
    dateOperation TEXT NOT NULL,       
    idTypesOperations INTEGER,
    idSource INTEGER,
    idDestinataire INTEGER,
    FOREIGN KEY (idOperateurs) REFERENCES operateurs(idOperateurs),
    FOREIGN KEY (idTypesOperations) REFERENCES typesOperations(idTypesOperations),
    FOREIGN KEY (idSource) REFERENCES utilisateurs(idUtilisateurs),
    FOREIGN KEY (idDestinataire) REFERENCES utilisateurs(idUtilisateurs)
);

CREATE TABLE commissions(
    idCommissions INTEGER PRIMARY KEY,
    pourcentage INTEGER NOT NULL,
    idOperateurs INTEGER,
    FOREIGN KEY (idOperateurs) REFERENCES operateurs(idOperateurs)
);

CREATE TABLE config_frais(
    idConfig_frais INTEGER PRIMARY KEY,
    pourcentage INTEGER NOT NULL
);


CREATE TABLE configEpargnes(
    idConfigEpargnes INTEGER PRIMARY KEY,
    idUtilisateur INTEGER NOT NULL,
    pourcentage INTEGER Not NULL
);
CREATE TABLE compteEpargnes(
    idEpargnes INTEGER PRIMARY KEY,
    montant INTEGER NOT NULL,
    idUtilisateurs INTEGER,
    FOREIGN KEY (idUtilisateurs) REFERENCES utilisateurs(idUtilisateurs)
);

