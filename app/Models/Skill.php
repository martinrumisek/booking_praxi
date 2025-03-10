<?php

namespace App\Models;

use CodeIgniter\Model;

class Skill extends Model{
    protected $table = 'Skill';
    protected $primaryKey = 'skill_id';
    protected $allowedFields = ['skill_name','skill_description','skill_create_time','skill_edit_time', 'skill_del_time','Category_skill_category_id'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'skill_create_time'; 
    protected $updatedField = 'skill_edit_time'; 
    protected $deletedField = 'skill_del_time';
    protected $dateFormat = 'datetime';
}