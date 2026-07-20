<?php 
namespace App\Models;
use CodeIgniter\Model;

class TypesOperationsModel extends Model
{
    protected $table = 'typesOperations';
    protected $primaryKey = 'idTypesOperations';
    protected $allowedFields = ['libelle'];
}