<?php

namespace App\Models;

use CodeIgniter\Model;

class ClassModel extends Model
{
    protected $table = 'class';
    protected $primaryKey = 'id';
    protected $allowedFields = ['year_graduation', 'class', 'letter_class','create_time','edit_time','Field_study_id'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'create_time'; 
    protected $updatedField = 'edit_time';
    protected $deletedField = 'del_time';  
    protected $dateFormat = 'datetime';    
}