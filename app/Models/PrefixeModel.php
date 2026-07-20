<?php 
use CodeIgniter\Models;
namespace App\Models;

class PrefixeModel extends Models
{
    protected $table = 'prefixes';
    protected $primaryKey = 'idPrefixes';
    protected $allowedFields = ['valeur', 'operateur'];
}