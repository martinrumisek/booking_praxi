<?php

namespace App\Models;

use CodeIgniter\Model;

class FieldStudy extends Model{
    protected $table = 'field_study';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name','shortcut','create_time','edit_time','Type_school_id'];
    protected $useTimestamps = true;
    protected $createdField = 'create_time'; 
    protected $updatedField = 'edit_time'; 
    protected $dateFormat = 'datetime';
}