<?php 

use CodeIgniter\Model;
namespace App\Models;

class OperationsModel extends Model
{
    protected $table = 'operations';
    protected $primaryKey = 'idOperations';
    protected $allowedFields = ['montant', 'fraisAppliques', 'dateOperation', 'idTypesOperations', 'idSource', 'idDestinataire'];
}