<?php

namespace App\Models;

use CodeIgniter\Model;

class Practise extends Model{
    protected $table = 'practise';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name','description','contract_file','start_new_offer','end_new_offer','create_time','edit_time'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'create_time'; 
    protected $updatedField = 'edit_time'; 
    protected $deletedField = 'del_time';
    protected $dateFormat = 'datetime';
}