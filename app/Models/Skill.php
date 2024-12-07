<?php

namespace App\Models;

use CodeIgniter\Model;

class Skill extends Model{
    protected $table = 'skill';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name','description','create_time','edit_time','Category_skill_id'];
    protected $useTimestamps = true;
    protected $createdField = 'create_time'; 
    protected $updatedField = 'edit_time'; 
    protected $dateFormat = 'datetime';
}