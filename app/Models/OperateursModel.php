<?php

namespace App\Models;
use CodeIgniter\Model;
use App\Models\OperationsModel;
use App\Models\CommissionModel;
class OperateursModel extends Model
{
    protected $table = 'operateurs';
    protected $primaryKey = 'idOperateurs';
    protected $allowedFields = ['libelle'];

    public function getSoldeOperateur(int $idOperateurExclu = 1): array
    {
        $operations = (new OperationsModel())
            ->where('idOperateurs !=', $idOperateurExclu)
            ->findAll();

        $solde = [];

        foreach ($operations as $operation) {
            $idOperateur = $operation['idOperateurs'];

            $montant = $operation['montant'] - $operation['fraisAppliques'];

            $commissionData = (new CommissionModel())->find($idOperateur);

            if (!$commissionData) {
                continue;
            }

            $commission = $montant * ($commissionData['pourcentage'] / 100)+$montant;

            if (!isset($solde[$idOperateur])) {
                $solde[$idOperateur] = [
                    'idOperateur' => $idOperateur,
                    'libelle' => $this->find($idOperateur)['libelle'],
                    'solde' => 0
                ];
            }

            $solde[$idOperateur]['solde'] += $commission;
        }

        return array_values($solde);
    }
}