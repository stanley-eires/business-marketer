<?php namespace App\Models;

use CodeIgniter\Model;

class smshistorymodel extends Model
{
    protected $table = 'smshistory';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;
    protected $returnType = "object";

    protected $allowedFields = ["gateway","phone","status","response","api_call"];
    protected $useTimestamps = true;

    
}


