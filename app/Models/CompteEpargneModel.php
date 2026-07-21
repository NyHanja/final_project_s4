<?php

namespace App\Models;

use CodeIgniter\Model;

class CompteEpargnesModel extends Model
{
        protected $table = 'compteEpargnes';
    protected $primaryKey = 'idEpargnes';

    protected $allowedFields = [
        'idUtilisateurs',
        'montant'
    ];
    
}