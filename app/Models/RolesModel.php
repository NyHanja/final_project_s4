<?php 

use CodeIgniter\Models;
namespace App\Models;
class RoldesModel extends Models
{
    protected $table = 'roles';
    protected $primaryKey = 'idRoles';
    protected $allowedFields = ['libelle'];
}