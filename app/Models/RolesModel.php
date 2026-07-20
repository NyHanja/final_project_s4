<?php 

use CodeIgniter\Model;
namespace App\Models;
class RoldesModel extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'idRoles';
    protected $allowedFields = ['libelle'];
}