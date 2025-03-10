<?php

namespace App\Models;

use CodeIgniter\Model;

class User_Skill extends Model{
    protected $table = 'User_has_Skill';
    protected $primaryKey = 'user_skill_id';
    protected $allowedFields = ['User_user_id','Skill_skill_id','user_skill_create_time','user_skill_edit_time', 'user_skill_del_time'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'user_skill_create_time'; 
    protected $updatedField = 'user_skill_edit_time';
    protected $deletedField = 'user_skill_del_time';
    protected $dateFormat = 'datetime';
}