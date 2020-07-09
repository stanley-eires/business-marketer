<?php namespace App\Models;

use CodeIgniter\Model;

class Phonegroupmodel extends Model
{
    protected $table = 'phone_group';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;
    protected $returnType = "object";

    protected $allowedFields = ["name","numbers"];
    protected $useTimestamps = true;

    public function saveGroup(array $data) 
    {
        $data["numbers"] = serialize(array_unique($data["numbers"]));
        return $this->save($data);
    }
    public function updateGroup(array $data) 
    {
        $data["numbers"] = serialize(array_unique($data["numbers"]));
        return $this->save($data);
    }
}
