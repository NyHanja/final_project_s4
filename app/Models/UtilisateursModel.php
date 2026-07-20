<?php 

use CodeIgniter\Models;
namespace App\Models;
class UtilisateursModel extends Models
{
    protected $table = 'utilisateurs';
    protected $primaryKey = 'idUtilisateurs';
    protected $allowedFields = ['numeroTelephone', 'nom', 'prenom', 'idRoles'];
}