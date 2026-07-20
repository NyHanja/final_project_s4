<?php

namespace App\Models;
use CodeIgniter\Model;
class OperateursModel extends Model
{
    protected $table = 'operateurs';
    protected $primaryKey = 'idOperateurs';
    protected $allowedFields = ['libelle'];
}