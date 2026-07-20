# Version 1 & Version 2

## Initialisation

- Initialisation de l'environnement de développement.
- Initialisation de la base de données.
- Mise en place de la structure de l'application.

---

# Côté opérateur
*Responsable : etu003942*

## Gestion des préfixes opérateurs

- Configuration des préfixes valables pour l'opérateur principal (Exemples : 033, 037).
- **[V2]** Configuration des préfixes valables pour les **autres opérateurs** partenaires (Exemples : 032, 034, 038...).

Fonctionnalités :
- Ajouter un préfixe.
- Modifier un préfixe existant.
- Supprimer un préfixe.
- Associer un préfixe à un opérateur (principal ou externe).

---

## Gestion des types d'opérations et barèmes

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

## **[V2]** Gestion des commissions (Inter-opérateur)

- **[V2]** Configuration du **% de commission** en plus pour les transferts sortants vers les autres opérateurs.

---

## Situation des gains

Calcul et affichage des gains générés par :
- Les frais de retrait.
- Les frais de transfert.

**[V2] Nouvelle structure de la page "Situation des gains" :**
- Séparer distinctement les gains de l'**opérateur principal** et ceux des **autres opérateurs** (via les commissions).
- Total des frais collectés.
- Historique global des gains.

---

## **[V2]** Compensation inter-opérateur

- **[V2]** Suivi et situation des **montants globaux à envoyer** (dettes/crédits de transfert) à chaque opérateur tiers.

---

## Situation des comptes clients

Consultation des comptes clients :
- Liste des clients.
- Solde disponible.
- Historique des opérations.

---

# Côté client
*Responsable : etu004300*

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
- Consulter son solde actuel (calculé dynamiquement à partir des opérations).

---

## Opérations

### Dépôt
- Effectuer un dépôt (considéré comme automatique et sans frais).
- Le solde du compte est augmenté.

### Retrait
- Effectuer un retrait automatique.
- Le solde est diminué du montant + les frais de retrait selon le barème.

### Transfert Simple
Effectuer un transfert vers un autre client :
- Retrait du montant chez l'expéditeur.
- Ajout du montant chez le destinataire.
- Calcul automatique des frais de transfert (et application du % inter-opérateur si applicable).
- Mise à jour des soldes.

**[V2] Nouvelles fonctionnalités de transfert :**
- **Option "Inclure les frais de retrait"** : Permet à l'expéditeur de payer les frais de retrait à la place du destinataire (le destinataire reçoit `montant + frais de retrait`).
- **Règle inter-opérateur** : Il n'y a **aucun frais de retrait** appliqué si le transfert est envoyé vers un client d'un **autre opérateur**.

### **[V2]** Transfert Multiple
- Effectuer un envoi groupé vers **plusieurs numéros simultanément**.
- **Règle stricte** : Valable uniquement pour les numéros du **même opérateur** que l'expéditeur.
- Division automatique et équitable du montant total saisi entre chaque destinataire.

---

## Historique

Le client peut consulter :
- La liste filtrable de ses opérations (entrant / sortant).
- Les détails des transactions effectuées.
- Les montants transférés.
- Les frais appliqués à chaque transaction.