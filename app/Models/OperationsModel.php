<?php

namespace App\Models;

use CodeIgniter\Model;

class OperationsModel extends Model
{
    protected $table      = 'operations';
    protected $primaryKey = 'idOperations';

    protected $allowedFields = [
        'montant',
        'fraisAppliques',
        'dateOperation',
        'idTypesOperations',
        'idSource',
        'idDestinataire',
        'idOperateurs',
    ];

    /**
     * Solde = somme reçue (destinataire) - somme envoyée + frais déjà stockés (source)
     * IMPORTANT : on lit fraisAppliques tel qu'enregistré, on ne le recalcule JAMAIS ici,
     * car il peut combiner plusieurs frais (transfert + retrait) ou être réparti (envoi multiple).
     */
    public function getSolde(int $id): float
    {
        $db = \Config\Database::connect();
        $operations = $db->table('operations')
            ->where('idDestinataire', $id)
            ->orWhere('idSource', $id)
            ->get()
            ->getResultArray();

        $solde = 0.0;

        foreach ($operations as $operation) {
            $montant        = (float) ($operation['montant'] ?? 0);
            $fraisAppliques = (float) ($operation['fraisAppliques'] ?? 0);
            $idSource       = $operation['idSource'] ?? null;
            $idDestinataire = $operation['idDestinataire'] ?? null;

            if ((int) $idDestinataire === $id) {
                $solde += $montant;
                continue;
            }

            if ((int) $idSource === $id) {
                $solde -= $montant + $fraisAppliques;
            }
        }

        return (float) $solde;
    }
    public function calculerGainOperation(array $operation): float
    {
        $frais = (float) $operation['fraisAppliques'];
        $montant = (float) $operation['montant'];

        $idDestinataire = $operation['idDestinataire'];

        // Récupérer l'opérateur du destinataire
        $db = \Config\Database::connect();

        $destinataire = $db->table('utilisateurs u')
            ->select('p.idOperateurs')
            ->join('prefixes p', "SUBSTR(u.numeroTelephone,1,3) = p.valeur")
            ->where('u.idUtilisateurs', $idDestinataire)
            ->get()
            ->getRowArray();


        if (!$destinataire) {
            return 0;
        }


        // Ton opérateur (exemple : Telma id = 1)
        $monOperateur = 1;


        // Même opérateur
        if ($destinataire['idOperateurs'] == $monOperateur) {

            return $frais;
        }


        // Autre opérateur : chercher la commission
        $commission = $db->table('commissions')
            ->where('idOperateurs', $destinataire['idOperateurs'])
            ->get()
            ->getRowArray();


        if (!$commission) {
            return 0;
        }


        // Commission calculée sur le montant envoyé
        return $montant * ($commission['pourcentage'] / 100);
    }

    public function getHistorique(int $idUtilisateur, array $filtres = []): array
    {
        // Ajout de parenthèses strictes autour du OR pour isoler l'utilisateur connecté
        $sql = "
    SELECT
        operations.idOperations,
        operations.montant,
        operations.fraisAppliques,
        operations.dateOperation,
        operations.idTypesOperations,
        typesOperations.libelle AS typeLibelle,
        operations.idSource,
        operations.idDestinataire,
        CASE
            WHEN operations.idDestinataire = ? THEN 'entrant'
            ELSE 'sortant'
        END AS sens,
        src.numeroTelephone AS numeroSource,
        dst.numeroTelephone AS numeroDestinataire
    FROM operations
    JOIN typesOperations ON typesOperations.idTypesOperations = operations.idTypesOperations
    LEFT JOIN utilisateurs src ON src.idUtilisateurs = operations.idSource
    LEFT JOIN utilisateurs dst ON dst.idUtilisateurs = operations.idDestinataire
    WHERE (operations.idSource = ? OR operations.idDestinataire = ?)
";

        $params = [$idUtilisateur, $idUtilisateur, $idUtilisateur];

        // Les filtres s'appliqueront désormais STRICTEMENT à l'utilisateur connecté
        if (!empty($filtres['dateDebut'])) {
            $sql .= " AND date(operations.dateOperation) >= ? ";
            $params[] = $filtres['dateDebut'];
        }

        if (!empty($filtres['dateFin'])) {
            $sql .= " AND date(operations.dateOperation) <= ? ";
            $params[] = $filtres['dateFin'];
        }

        if (!empty($filtres['idTypesOperations'])) {
            $sql .= " AND operations.idTypesOperations = ? ";
            $params[] = $filtres['idTypesOperations'];
        }

        $sql .= " ORDER BY operations.dateOperation DESC ";

        $query = $this->db->query($sql, $params);

        return $query->getResultArray();
    }


    public function gain($date = null): float
    {

        $builder = $this->whereIn('idTypesOperations', [2, 3]);

        if ($date != null) {
            $builder->where('DATE(dateOperation)', $date);
        }

        $operations = $builder->findAll();

        $total = 0;

        foreach ($operations as $operation) {
            $total += $this->calculerGainOperation($operation);
        }

        return $total;
    }
    public function gainParOperateur($date = null): array
    {
        $db = \Config\Database::connect();

        $builder = $this
            ->select('operations.*')
            ->whereIn('idTypesOperations', [2, 3]);

        if ($date != null) {
            $builder->where('DATE(dateOperation)', $date);
        }

        $operations = $builder->findAll();

        $monOperateur = 1;

        // FIX : On initialise l'opérateur principal (1) pour éviter l'erreur "Undefined array key 1"
        $gains = [
            $monOperateur => [
                'operateur' => 'Mon Opérateur', // Vous pouvez remplacer par le vrai nom (ex: Orange, Airtel...)
                'gain' => 0
            ]
        ];

        foreach ($operations as $operation) {
            $gain = 0;
            $idOperateur = null;
            $nomOperateur = "";
            $frais = (float)($operation['fraisAppliques'] ?? 0);

            if (!empty($operation['idDestinataire'])) {
                $destinataire = $db->table('utilisateurs u')
                    ->select('o.idOperateurs, o.nom')
                    ->join('prefixes p', "SUBSTR(u.numeroTelephone,1,3)=p.valeur")
                    ->join('operateurs o', 'o.idOperateurs=p.idOperateurs')
                    ->where('u.idUtilisateurs', $operation['idDestinataire'])
                    ->get()
                    ->getRowArray();

                if ($destinataire) {
                    $idOperateur = $destinataire['idOperateurs'];
                    $nomOperateur = $destinataire['nom'];

                    if ($idOperateur != $monOperateur) {
                        $commission = $db->table('commissions')
                            ->where('idOperateurs', $idOperateur)
                            ->get()
                            ->getRowArray();

                        if ($commission) {
                            $gain = $operation['montant'] * ($commission['pourcentage'] / 100);
                        }
                    }

                    // Initialisation dynamique pour les AUTRES opérateurs partenaires
                    if (!isset($gains[$idOperateur])) {
                        $gains[$idOperateur] = [
                            'operateur' => $nomOperateur,
                            'gain' => 0
                        ];
                    }

                    if ($idOperateur != $monOperateur) {
                        $gains[$idOperateur]['gain'] += $gain;
                    }
                }
            }

            // Plus aucun risque de plantage ici car $gains[1] est déjà initialisé
            $gains[$monOperateur]['gain'] += $frais;
        }

        // Retourner les gains sous forme de tableau indexé
        return array_values($gains);
    }
    public function getFrais(int $idTypesOperations, int $montant): int
    {
        $db = \Config\Database::connect();

        $frais = $db->table('frais')
            ->where('idTypesOperations', $idTypesOperations)
            ->where('montantMin <=', $montant)
            ->where('montantMax >=', $montant)
            ->get()
            ->getRow();

        return $frais ? (int) $frais->valeurFrais : 0;
    }

    public function effectuerDepot(int $idUtilisateur, int $montant, string $dateOperation): array
    {
        if ($montant <= 0) {
            return ['success' => false, 'message' => 'Montant invalide.'];
        }

        $utilisateurModel = new \App\Models\UtilisateursModel();
        $prefixeModel     = new \App\Models\PrefixeModel();

        $utilisateur = $utilisateurModel->find($idUtilisateur);
        if (!$utilisateur) {
            return ['success' => false, 'message' => 'Utilisateur introuvable.'];
        }

        $idOperateur = $prefixeModel->getOperateurByNumero($utilisateur['numeroTelephone']);
        if ($idOperateur === null) {
            return ['success' => false, 'message' => 'Votre numéro ne correspond à aucun opérateur connu.'];
        }

        $idTypeDepot = 1;

        $this->insert([
            'montant' => $montant,
            'fraisAppliques' => 0,
            'dateOperation' => $dateOperation,
            'idTypesOperations' => $idTypeDepot,

            'idSource'          => null,
            'idDestinataire'    => $idUtilisateur,
            'idOperateurs'      => $idOperateur,
        ]);

        return ['success' => true, 'message' => 'Dépôt effectué avec succès.'];
    }

    public function effectuerRetrait(int $idUtilisateur, int $montant, string $dateOperation): array
    {
        if ($montant <= 0) {
            return ['success' => false, 'message' => 'Montant invalide.'];
        }

        $utilisateurModel = new \App\Models\UtilisateursModel();
        $prefixeModel     = new \App\Models\PrefixeModel();

        $utilisateur = $utilisateurModel->find($idUtilisateur);
        if (!$utilisateur) {
            return ['success' => false, 'message' => 'Utilisateur introuvable.'];
        }

        $idOperateur = $prefixeModel->getOperateurByNumero($utilisateur['numeroTelephone']);
        if ($idOperateur === null) {
            return ['success' => false, 'message' => 'Votre numéro ne correspond à aucun opérateur connu.'];
        }

        $idTypeRetrait = 2;

        $frais = $this->getFrais($idTypeRetrait, $montant);
        $solde = $this->getSolde($idUtilisateur);

        if ($solde < $montant + $frais) {
            return ['success' => false, 'message' => 'Solde insuffisant pour effectuer ce retrait.'];
        }

        $this->insert([
            'montant' => $montant,
            'fraisAppliques' => $frais,
            'dateOperation' => $dateOperation,
            'idTypesOperations' => $idTypeRetrait,

            'idSource'          => $idUtilisateur,
            'idDestinataire'    => null,
            'idOperateurs'      => $idOperateur,
        ]);

        return ['success' => true, 'message' => 'Retrait effectué avec succès.'];
    }


    public function effectuerTransfert(
        int $idUtilisateurSource,
        string $numeroDestinataire,
        int $montant,
        bool $inclureFraisRetrait = false,
        ?int $fraisTransfertOverride = null
    ): array {
        if ($montant <= 0) {
            return ['success' => false, 'message' => 'Montant invalide.'];
        }

        $utilisateurModel = new \App\Models\UtilisateursModel();
        $prefixeModel     = new \App\Models\PrefixeModel();

        $sourceUser = $utilisateurModel->find($idUtilisateurSource);
        if (!$sourceUser) {
            return ['success' => false, 'message' => 'Utilisateur source introuvable.'];
        }

        $idOperateurSource       = $prefixeModel->getOperateurByNumero($sourceUser['numeroTelephone']);
        $idOperateurDestinataire = $prefixeModel->getOperateurByNumero($numeroDestinataire);

        if ($idOperateurSource === null) {
            return ['success' => false, 'message' => 'Votre numéro ne correspond à aucun opérateur connu.'];
        }
        if ($idOperateurDestinataire === null) {
            return ['success' => false, 'message' => 'Numéro destinataire invalide.'];
        }

        $estMemeOperateur = ($idOperateurSource === $idOperateurDestinataire);

        $destinataire = $utilisateurModel->where('numeroTelephone', $numeroDestinataire)->first();

        if ($destinataire && (int) $destinataire['idUtilisateurs'] === $idUtilisateurSource) {
            return ['success' => false, 'message' => 'Impossible de vous transférer à vous-même.'];
        }

        if ($estMemeOperateur && !$destinataire) {
            return ['success' => false, 'message' => 'Destinataire introuvable.'];
        }

        $idTypeTransfert = 3;
        $idTypeRetrait   = 2;

        // 1. Calcul des frais
        $fraisTransfert = $fraisTransfertOverride ?? $this->getFrais($idTypeTransfert, $montant);

        $fraisRetrait = ($inclureFraisRetrait && $estMemeOperateur)
            ? $this->getFrais($idTypeRetrait, $montant)
            : 0;

        // 2. Le total réel à vérifier et déduire de l'expéditeur
        $totalDebite = $montant + $fraisTransfert + $fraisRetrait;

        $solde = $this->getSolde($idUtilisateurSource);
        if ($solde < $totalDebite) {
            return ['success' => false, 'message' => 'Solde insuffisant.'];
        }

        $idDestinataireInsert = $estMemeOperateur ? (int) $destinataire['idUtilisateurs'] : null;
        $idOperateurInsert    = $estMemeOperateur ? $idOperateurSource : $idOperateurDestinataire;

        $this->insert([
            'montant'           => $montant,
            'fraisAppliques'    => $fraisTransfert + $fraisRetrait,
            'dateOperation'     => date('Y-m-d H:i:s'),
            'idTypesOperations' => $idTypeTransfert,
            'idSource'          => $idUtilisateurSource,
            'idDestinataire'    => $idDestinataireInsert,
            'idOperateurs'      => $idOperateurInsert,
        ]);

        $message = $estMemeOperateur
            ? 'Transfert effectué avec succès.'
            : 'Transfert envoyé vers un autre opérateur (le crédit au destinataire n\'est pas encore géré par le système).';

        return ['success' => true, 'message' => $message];
    }

    public function effectuerTransfertMultiple(int $idUtilisateurSource, array $numeros, int $montantTotal, bool $inclureFraisRetrait = false): array
    {
        $numeros = array_values(array_unique(array_filter($numeros)));
        $nombre  = count($numeros);

        if ($nombre < 2) {
            return ['success' => false, 'message' => 'Il faut au moins 2 destinataires pour un envoi multiple.'];
        }

        if ($montantTotal <= 0) {
            return ['success' => false, 'message' => 'Montant invalide.'];
        }

        $montantParDestinataire = intdiv($montantTotal, $nombre);
        if ($montantParDestinataire <= 0) {
            return ['success' => false, 'message' => 'Montant trop faible pour être divisé entre tous les destinataires.'];
        }

        $utilisateurModel = new \App\Models\UtilisateursModel();
        $prefixeModel     = new \App\Models\PrefixeModel();

        $sourceUser = $utilisateurModel->find($idUtilisateurSource);
        if (!$sourceUser) {
            return ['success' => false, 'message' => 'Utilisateur source introuvable.'];
        }

        $idOperateurSource = $prefixeModel->getOperateurByNumero($sourceUser['numeroTelephone']);

        // Validation complète AVANT tout insert : tous les numéros doivent être notre opérateur et exister
        foreach ($numeros as $numero) {
            $idOperateurDest = $prefixeModel->getOperateurByNumero($numero);

            if ($idOperateurDest === null || $idOperateurDest !== $idOperateurSource) {
                return ['success' => false, 'message' => "Le numéro $numero n'est pas dans notre réseau. L'envoi multiple est réservé au même opérateur."];
            }

            $dest = $utilisateurModel->where('numeroTelephone', $numero)->first();
            if (!$dest) {
                return ['success' => false, 'message' => "Le numéro $numero est introuvable."];
            }
        }

        $idTypeTransfert = 3; // même constante que dans effectuerTransfert

        // Frais de transfert calculé UNE SEULE FOIS sur le montant total
        $fraisTransfertTotal = $this->getFrais($idTypeTransfert, $montantTotal);
        $fraisTransfertParDestinataire = intdiv($fraisTransfertTotal, $nombre);
        $resteFrais = $fraisTransfertTotal - ($fraisTransfertParDestinataire * $nombre);

        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($numeros as $index => $numero) {
            // Le reste de la division entière est absorbé par le premier destinataire,
            // pour que la somme totale des frais enregistrés soit exacte au centime près
            $fraisTransfertCeDestinataire = $fraisTransfertParDestinataire + ($index === 0 ? $resteFrais : 0);

            $resultat = $this->effectuerTransfert(
                $idUtilisateurSource,
                $numero,
                $montantParDestinataire,
                $inclureFraisRetrait,
                $fraisTransfertCeDestinataire
            );

            if (!$resultat['success']) {
                $db->transRollback();
                return ['success' => false, 'message' => "Échec pour $numero : " . $resultat['message']];
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['success' => false, 'message' => "Erreur lors de l'enregistrement des transferts."];
        }

        return [
            'success' => true,
            'message' => "Envoi multiple effectué : $montantParDestinataire Ar envoyés à $nombre destinataires (frais de transfert total : $fraisTransfertTotal Ar).",
        ];
    }
}
