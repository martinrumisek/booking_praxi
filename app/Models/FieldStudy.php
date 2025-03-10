<?php

namespace App\Models;

use CodeIgniter\Model;

class FieldStudy extends Model{
    protected $table = 'Field_study';
    protected $primaryKey = 'field_id';
    protected $allowedFields = ['field_name','field_shortcut','field_create_time','field_edit_time', 'field_del_time','Type_school_type_id'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'field_create_time'; 
    protected $updatedField = 'field_edit_time'; 
    protected $deletedField = 'field_del_time';
    protected $dateFormat = 'datetime';
}