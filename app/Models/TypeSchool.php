<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeSchool extends Model{
    protected $table = 'Type_school';
    protected $primaryKey = 'type_id';
    protected $allowedFields = ['type_name','type_shortcut','type_description','type_create_time','type_edit_time', 'type_del_time'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'type_create_time'; 
    protected $updatedField = 'type_edit_time'; 
    protected $deletedField = 'type_del_time';
    protected $dateFormat = 'datetime';
}