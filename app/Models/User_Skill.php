<?php

namespace App\Models;

use CodeIgniter\Model;

class User_Skill extends Model{
    protected $table = 'user_has_skill';
    protected $primaryKey = ['User_id','Skill_id'];
    protected $useAutoIncrement = false;
    protected $allowedFields = ['User_id','Skill_id','create_time','edit_time'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'create_time'; 
    protected $updatedField = 'edit_time';
    protected $deletedField = 'del_time';
    protected $dateFormat = 'datetime';
}