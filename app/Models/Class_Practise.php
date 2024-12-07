<?php

namespace App\Models;

use CodeIgniter\Model;

class Class_Practise extends Model{
    protected $table = 'class_has_practise';
    protected $primaryKey = ['Class_id', 'Practise_id'];
    protected $useAutoIncrement = false;
    protected $allowedFields = ['Class_id','Practise_id','create_time','edit_time'];
    protected $useTimestamps = true;
    protected $createdField = 'create_time'; 
    protected $updatedField = 'edit_time'; 
    protected $dateFormat = 'datetime';
}