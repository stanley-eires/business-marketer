<?php namespace App\Models;

use CodeIgniter\Model;

class Emaildraftmodel extends Model
{
    protected $table = 'emaildraft';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;
    protected $returnType = "object";

    protected $allowedFields = ["title","body","used_count"];
    protected $useTimestamps = true;
}
