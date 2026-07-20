<?php 

namespace App\Models;
use CodeIgniter\Model;
class UtilisateursModel extends Model
{
    protected $table = 'utilisateurs';
    protected $primaryKey = 'idUtilisateurs';
    protected $allowedFields = ['numeroTelephone', 'nom', 'prenom', 'idRoles'];
}