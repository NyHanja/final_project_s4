<?php 
namespace App\Models;
use CodeIgniter\Model;

class PrefixeModel extends Model
{
    protected $table = 'prefixes';
    protected $primaryKey = 'idPrefixes';
    protected $allowedFields = ['valeur', 'operateur'];

    public function validationPrefixes($numeroTelephone){
        $prefixe = substr($numeroTelephone, 0, 3);
        $prefixeModel = new PrefixeModel();
        $resultat = $prefixeModel->where('valeur', $prefixe)->first();
        if ($resultat) {
            return true; 
        } else {
            return false;
        }
    }
}