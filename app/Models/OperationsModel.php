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
}