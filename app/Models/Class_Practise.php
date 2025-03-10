<?php

namespace App\Models;

use CodeIgniter\Model;

class Class_Practise extends Model{
    protected $table = 'Class_has_Practise';
    protected $primaryKey = 'class_practise_id';
    protected $allowedFields = ['Class_class_id','Practise_practise_id','class_practise_create_time','class_practise_edit_time', 'class_practise_del_time'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'class_practise_create_time'; 
    protected $updatedField = 'class_practise_edit_time'; 
    protected $deletedField = 'class_practise_del_time';
    protected $dateFormat = 'datetime';
}