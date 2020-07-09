<?php namespace App\Models;

use CodeIgniter\Model;

class Emailgroupmodel extends Model
{
    protected $table = 'email_group';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;
    protected $returnType = "object";

    protected $allowedFields = ["name","address"];
    protected $useTimestamps = true;

    public function saveGroup(array $data) 
    {
        $data["address"] = serialize(array_unique($data["address"]));
        return $this->save($data);
    }
    public function updateGroup(array $data) 
    {
        $data["address"] = serialize(array_unique($data["address"]));
        return $this->save($data);
    }
}
