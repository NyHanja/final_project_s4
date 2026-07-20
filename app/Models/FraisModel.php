<?php

namespace App\Models;

use CodeIgniter\Model;

class FraisModel extends Model
{
    protected $table = 'frais';
    protected $primaryKey = 'idFrais';

    protected $allowedFields = [
        'montantMin',
        'montantMax',
        'valeurFrais',
        'idTypesOperations'
    ];

    public function totalGain($aa)
    {
        $montantFrais = 0;

        foreach ($aa as $a) {
            $fr = $this->where('idFrais', $a['fraisAppliques'])->first();

            if ($fr) {
                $montantFrais += $fr['valeurFrais'];
            }
        }

        return $montantFrais;
    }
}