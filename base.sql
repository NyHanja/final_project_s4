CREATE DATABASE IF NOT EXISTS mobileMoney;

CREATE TABLE prefixes (
    idPrefixes INT AUTO_INCREMENT PRIMARY KEY,
    valeur VARCHAR(10) NOT NULL,
    operateur VARCHAR(50)
);

CREATE TABLE typesOperations (
    idTypesOperations INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(50) NOT NULL
);

CREATE TABLE frais (
    idFrais INT AUTO_INCREMENT PRIMARY KEY,
    montant1 DECIMAL(10,2) NOT NULL,
    montant2 DECIMAL(10,2) NOT NULL,
    valeurFrais DECIMAL(10,2) NOT NULL
    -- idTypesOperations INT,
    -- FOREIGN KEY (idTypesOperations) REFERENCES typesOperations(idTypesOperations)
);

CREATE TABLE roles (
    idRoles INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(50) NOT NULL
);

CREATE TABLE utilisateurs (
    idUtilisateurs INT AUTO_INCREMENT PRIMARY KEY,
    numeroTelephone VARCHAR(15) NOT NULL,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    idRoles INT,
    FOREIGN KEY (idRoles) REFERENCES roles(idRoles)
);

CREATE TABLE operations (
    idOperations INT AUTO_INCREMENT PRIMARY KEY,
    montant DECIMAL(10,2) NOT NULL,
    dateOperation DATETIME NOT NULL,
    idTypesOperations INT,
    idSource INT,
    idDestinataire INT,
    FOREIGN KEY (idTypesOperations) REFERENCES typesOperations(idTypesOperations),
    FOREIGN KEY (idSource) REFERENCES utilisateurs(idUtilisateurs),
    FOREIGN KEY (idDestinataire) REFERENCES utilisateurs(idUtilisateurs)
);


