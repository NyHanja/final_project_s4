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