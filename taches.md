# Version 1

## Initialisation

- Initialisation de l'environnement de développement.
- Initialisation de la base de données.
- Mise en place de la structure de l'application.

---

# Côté opérateur
**Responsable : 003942**

## Gestion des préfixes opérateurs

- Configuration des préfixes valables pour chaque opérateur.
- Exemple de préfixes :
  - 033
  - 037

Fonctionnalités :
- Ajouter un préfixe.
- Modifier un préfixe existant.
- Supprimer un préfixe.
- Associer un préfixe à un opérateur.

---

## Gestion des types d'opérations

Création des différents types d'opérations :

- Dépôt.
- Retrait.
- Transfert.

Gestion des barèmes de frais :

- Définition des frais selon des tranches de montant.
- Modification des barèmes existants.

Exemple :

| Montant minimum | Montant maximum | Frais |
|-----------------|-----------------|-------|
| 0               | 10000           | X Ar  |
| 10001           | 50000           | Y Ar  |

---

## Situation des gains

Calcul et affichage des gains générés par :

- Les frais de retrait.
- Les frais de transfert.

Informations affichées :
- Total des frais collectés.
- Historique des gains.

---

## Situation des comptes clients

Consultation des comptes clients :

- Liste des clients.
- Solde disponible.
- Historique des opérations.

---

# Côté client
**Responsable : etu004300**

## Connexion

Connexion automatique avec le numéro de téléphone.

Fonctionnement :

- L'utilisateur saisit son numéro.
- Vérification du préfixe opérateur.
- Si le numéro existe :
  - Connexion automatique.
- Si le numéro n'existe pas :
  - Création automatique du compte.
  - Connexion automatique.

---

## Gestion du solde

Le client peut :

- Consulter son solde actuel.

---

## Opérations

### Dépôt

- Effectuer un dépôt.
- Le dépôt est considéré comme automatique.
- Le solde du compte est augmenté.

---

### Retrait

- Effectuer un retrait.
- Le retrait est considéré comme automatique.
- Le solde est diminué.
- Calcul automatique des frais associés.

---

### Transfert

Effectuer un transfert entre deux clients :

- Retrait du montant chez l'expéditeur.
- Ajout du montant chez le destinataire.
- Calcul automatique des frais.
- Mise à jour des soldes.

---

## Historique

Le client peut consulter :

- La liste de ses opérations.
- Les détails des transactions effectuées.
- Les montants transférés.
- Les frais appliqués.