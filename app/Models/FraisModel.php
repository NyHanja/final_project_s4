<?php 

namespace App\Models;
use CodeIgniter\Model;

class FraisModel extends Model
{
    protected $table = 'frais';
    protected $primaryKey = 'idFrais';
    protected $allowedFields = ['montantMin', 'montantMax', 'valeurFrais', 'idTypesOperations'];
}