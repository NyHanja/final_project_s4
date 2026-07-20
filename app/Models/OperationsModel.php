<?php
namespace App\Models;
use CodeIgniter\Model;
use App\Models\FraisModel;


class OperationsModel extends Model
{
    protected $table = 'operations';
    protected $primaryKey = 'idOperations';
    protected $allowedFields = ['montant', 'fraisAppliques', 'dateOperation', 'idTypesOperations', 'idSource', 'idDestinataire', 'idOperateurs'];

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
            $montant = (float) ($operation['montant'] ?? 0);
            $idSource = $operation['idSource'] ?? null;
            $idDestinataire = $operation['idDestinataire'] ?? null;
            $idTypeOperation = (int) ($operation['idTypesOperations'] ?? 0);

            if ((int) $idDestinataire === $id) {
                $solde += $montant;
                continue;
            }

            if ((int) $idSource === $id) {
                $frais = $this->getFrais($idTypeOperation, (int) $montant);
                $solde -= $montant + $frais;
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

        $gains = [];

        foreach ($operations as $operation) {

            $gain = 0;
            $idOperateur = null;
            $nomOperateur = "";

            if (!empty($operation['idDestinataire']) ) {

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
                    $frais = $operation['fraisAppliques'];

                    if ($idOperateur != $monOperateur) {

                       

                        $commission = $db->table('commissions')
                            ->where('idOperateurs', $idOperateur)
                            ->get()
                            ->getRowArray();

                        if ($commission) {
                            $gain = $operation['montant'] * ($commission['pourcentage'] / 100);
                        }
                    }

                    if (!isset($gains[$idOperateur])) {
                        $gains[$idOperateur] = [
                            'operateur' => $nomOperateur,
                            'gain' => 0
                        ];
                    }
                    if($idOperateur !=1){
                        $gains[$idOperateur]['gain'] += $gain;

                    }
                    else {
                        $gains[1]['gain'] += frais;
                    }

                }
            }
        }

        // Retourner les gains par opérateur
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

        $idTypeDepot = 1;

        $this->insert([
            'montant' => $montant,
            'fraisAppliques' => 0,
            'dateOperation' => $dateOperation,
            'idTypesOperations' => $idTypeDepot,
            'idSource' => null,
            'idDestinataire' => $idUtilisateur,
        ]);

        return ['success' => true, 'message' => 'Dépôt effectué avec succès.'];
    }

    public function effectuerRetrait(int $idUtilisateur, int $montant, string $dateOperation): array
    {
        if ($montant <= 0) {
            return ['success' => false, 'message' => 'Montant invalide.'];
        }

        $idTypeRetrait = 2;

        $frais = $this->getFrais($idTypeRetrait, $montant);
        $solde = $this->getSolde($idUtilisateur);

        if ($solde < $montant + $frais) {
            throw new \RuntimeException('Solde insuffisant pour effectuer ce retrait.');
        }

        $this->insert([
            'montant' => $montant,
            'fraisAppliques' => $frais,
            'dateOperation' => $dateOperation,
            'idTypesOperations' => $idTypeRetrait,
            'idSource' => $idUtilisateur,
            'idDestinataire' => null,
        ]);

        return ['success' => true, 'message' => 'Retrait effectué avec succès.'];
    }

    public function effectuerTransfert(int $idUtilisateurSource, string $numeroDestinataire, int $montant, string $dateOperation): array
    {
        if ($montant <= 0) {
            return ['success' => false, 'message' => 'Montant invalide.'];
        }

        $utilisateurModel = new \App\Models\UtilisateursModel();
        $destinataire = $utilisateurModel->where('numeroTelephone', $numeroDestinataire)->first();

        if (!$destinataire) {
            return ['success' => false, 'message' => 'Destinataire introuvable.'];
        }

        $destinataireId = is_array($destinataire) ? $destinataire['idUtilisateurs'] : $destinataire->idUtilisateurs;

        if ($destinataireId === $idUtilisateurSource) {
            return ['success' => false, 'message' => 'Impossible de vous transférer à vous-même.'];
        }

        $idTypeTransfert = 3;

        $frais = $this->getFrais($idTypeTransfert, $montant);
        $solde = $this->getSolde($idUtilisateurSource);

        if ($solde < $montant + $frais) {
            throw new \RuntimeException('Solde insuffisant pour effectuer ce transfert.');
        }

        $this->insert([
            'montant' => $montant,
            'fraisAppliques' => $frais,
            'dateOperation' => $dateOperation,
            'idTypesOperations' => $idTypeTransfert,
            'idSource' => $idUtilisateurSource,
            'idDestinataire' => $destinataireId,
        ]);

        return ['success' => true, 'message' => 'Transfert effectué avec succès.'];
    }
}

