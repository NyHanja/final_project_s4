<?php

use CodeIgniter\Model;

namespace App\Models;

class OperationsModel extends Model
{
    protected $table = 'operations';
    protected $primaryKey = 'idOperations';
    protected $allowedFields = ['montant', 'fraisAppliques', 'dateOperation', 'idTypesOperations', 'idSource', 'idDestinataire'];


    public function getSolde(int $id): float
    {
        $db = \Config\Database::connect();
        $sql = "SELECT
            COALESCE(SUM(CASE WHEN idDestinataire = ? THEN montant ELSE 0 END), 0) -
            COALESCE(SUM(CASE WHEN idSource = ? THEN montant + fraisAppliques ELSE 0 END), 0) AS solde
            FROM operations
            WHERE idDestinataire = ? OR idSource = ?";

        $query = $this->$db->query($sql, [$id, $id, $id, $id]);
        return (float) ($query->getRow()->solde ?? 0);
    }

    public function getHistorique(int $idUtilisateur): array
    {
        $db = \Config\Database::connect();
        $sql = "
            SELECT
                operations.idOperations,
                operations.montant,
                operations.fraisAppliques,
                operations.dateOperation,
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
            WHERE operations.idSource = ? OR operations.idDestinataire = ?
            ORDER BY operations.dateOperation DESC
        ";

        $query = $this->$db->query($sql, [$idUtilisateur, $idUtilisateur, $idUtilisateur]);

        return $query->getResultArray();
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
            'montant'           => $montant,
            'fraisAppliques'    => 0, 
            'dateOperation'     => $dateOperation,
            'idTypesOperations' => $idTypeDepot,
            'idSource'          => null,
            'idDestinataire'    => $idUtilisateur,
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
            return ['success' => false, 'message' => 'Solde insuffisant.'];
        }

        $this->insert([
            'montant'           => $montant,
            'fraisAppliques'    => $frais,
            'dateOperation'     => $dateOperation,
            'idTypesOperations' => $idTypeRetrait,
            'idSource'          => $idUtilisateur,
            'idDestinataire'    => null,
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

        if ($destinataire->idUtilisateurs == $idUtilisateurSource) {
            return ['success' => false, 'message' => 'Impossible de vous transférer à vous-même.'];
        }

        $idTypeTransfert = 3;

        $frais = $this->getFrais($idTypeTransfert, $montant);
        $solde = $this->getSolde($idUtilisateurSource);

        if ($solde < $montant + $frais) {
            return ['success' => false, 'message' => 'Solde insuffisant.'];
        }

        $this->insert([
            'montant'           => $montant,
            'fraisAppliques'    => $frais,
            'dateOperation'     => $dateOperation,
            'idTypesOperations' => $idTypeTransfert,
            'idSource'          => $idUtilisateurSource,
            'idDestinataire'    => $destinataire->idUtilisateurs,
        ]);

        return ['success' => true, 'message' => 'Transfert effectué avec succès.'];
    }
}
