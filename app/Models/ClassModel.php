<?php

namespace App\Models;

use CodeIgniter\Model;

class ClassModel extends Model
{
    protected $table = 'class';
    protected $primaryKey = 'class_id';
    protected $allowedFields = ['class_year_graduation', 'class_class', 'class_letter_class','class_create_time','class_edit_time', 'class_del_time','Field_study_field_id'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'class_create_time'; 
    protected $updatedField = 'class_edit_time';
    protected $deletedField = 'class_del_time';  
    protected $dateFormat = 'datetime';    
}