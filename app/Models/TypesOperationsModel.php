<?php 
use CodeIgniter\Models;
namespace App\Models;

class TypesOperations extends Models
{
    protected $table = 'typesOperations';
    protected $primaryKey = 'idTypesOperations';
    protected $allowedFields = ['libelle'];
}