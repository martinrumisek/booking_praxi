<?php

namespace App\Models;

use CodeIgniter\Model;

class Class_Practise extends Model{
    protected $table = 'class_has_practise';
    protected $primaryKey = 'id';
    protected $allowedFields = ['Class_id','Practise_id','create_time','edit_time'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'create_time'; 
    protected $updatedField = 'edit_time'; 
    protected $deletedField = 'del_time';
    protected $dateFormat = 'datetime';
}