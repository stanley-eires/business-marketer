<?php namespace App\Models;

use CodeIgniter\Model;

class Emailhistorymodel extends Model
{
    protected $table = 'emailhistory';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;
    protected $returnType = "object";

    protected $allowedFields = ["address","meta","status","subject","message"];
    protected $useTimestamps = true;

    
}


