<?php

namespace App\Models;

use CodeIgniter\Model;


class CommissionModel extends Model
{

    protected $table='commissions';

    protected $primaryKey='idCommissions';


    protected $allowedFields=[
        'pourcentage',
        'idOperateurs'
    ];



    public function listeCommissions()
    {

        return $this
        ->select('commissions.*, operateurs.nom')
        ->join(
            'operateurs',
            'operateurs.idOperateurs = commissions.idOperateurs'
        )
        ->findAll();

    }


}