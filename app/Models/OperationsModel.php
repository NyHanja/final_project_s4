<?php 

use CodeIgniter\Models;
namespace App\Models;

class OperationsModel extends Models
{
    protected $table = 'operations';
    protected $primaryKey = 'idOperations';
    protected $allowedFields = ['montant', 'fraisAppliques', 'dateOperation', 'idTypesOperations', 'idSource', 'idDestinataire'];
}