<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfigEpargnesModel extends Model
{
        protected $table = 'configEpargnes';
    protected $primaryKey = 'idConfigEpargnes';

    protected $allowedFields = [
        'idUtilisateur',
        'pourcentage'
    ];

    public function getByUtilisateur(int $id){
        return $this->where('idUtilisateur',$id)->first();
    }
}
