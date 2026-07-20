<?php 
use CodeIgniter\Model;
namespace App\Models;

class TypesOperations extends Model
{
    protected $table = 'typesOperations';
    protected $primaryKey = 'idTypesOperations';
    protected $allowedFields = ['libelle'];
}