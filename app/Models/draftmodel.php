<?php namespace App\Models;

use CodeIgniter\Model;

class Draftmodel extends Model
{
    protected $table = 'draft';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;
    protected $returnType = "object";

    protected $allowedFields = ["title","body","used_count"];
    protected $useTimestamps = true;
}
