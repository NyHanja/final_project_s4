<?php

namespace App\Models;
use CodeIgniter\Model;
use App\Models\OperationsModel;
use App\Models\CommissionModel;
class OperateursModel extends Model
{
    protected $table = 'operateurs';
    protected $primaryKey = 'idOperateurs';
    protected $allowedFields = ['nom'];

    public function getSoldeOperateur(int $idOperateurExclu = 1): array
    {
        $operations = (new OperationsModel())
            ->where('idOperateurs !=', $idOperateurExclu)
            ->findAll();

        $solde = [];

        foreach ($operations as $operation) {
            $idOperateur = $operation['idOperateurs'];

            $montant = (float)($operation['montant'] ?? 0) - (float)($operation['fraisAppliques'] ?? 0);

            $commissionData = (new CommissionModel())
                ->where('idOperateurs', $idOperateur)
                ->first();

            if (!$commissionData) {
                continue;
            }

            $commission = $montant + ($montant * ((float)$commissionData['pourcentage'] / 100));

            $operateur = $this->find($idOperateur);
            $nomOperateur = $operateur['nom'] ?? ('Opérateur #' . $idOperateur);

            if (!isset($solde[$idOperateur])) {
                $solde[$idOperateur] = [
                    'idOperateur' => $idOperateur,
                    'nom' => $nomOperateur,
                    'solde' => 0
                ];
            }

            $solde[$idOperateur]['solde'] += $commission;
        }

        return array_values($solde);
    }
}