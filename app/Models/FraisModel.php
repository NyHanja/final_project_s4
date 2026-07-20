<?php 

use CodeIgniter\Models;
namespace App\Models;

class FraisModel extends Models
{
    protected $table = 'frais';
    protected $primaryKey = 'idFrais';
    protected $allowedFields = ['montantMin', 'montantMax', 'valeurFrais', 'idTypesOperations'];
}